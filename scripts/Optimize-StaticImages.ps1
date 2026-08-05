param(
    [switch] $Apply,
    [switch] $OptimizePng,
    [ValidateRange(40, 100)]
    [int] $JpegQuality = 84,
    [ValidateRange(640, 3840)]
    [int] $MaximumJpegWidth = 1920,
    [ValidateRange(640, 3840)]
    [int] $MaximumPngWidth = 1280,
    [ValidateRange(1, 100)]
    [int] $MinimumSavingPercent = 5
)

$ErrorActionPreference = 'Stop'

Add-Type -AssemblyName System.Drawing

$projectRoot = [System.IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..'))
$sourceRoot = Join-Path $projectRoot 'resources\js'
$imageRoot = Join-Path $sourceRoot 'images'

if (-not (Test-Path -LiteralPath $sourceRoot) -or -not (Test-Path -LiteralPath $imageRoot)) {
    throw 'The script must remain inside the MPDC project scripts directory.'
}

$imageRootPrefix = $imageRoot.TrimEnd('\') + '\'
$referencedNames = New-Object 'System.Collections.Generic.HashSet[string]' ([System.StringComparer]::OrdinalIgnoreCase)
$assetPattern = [regex]::new('(?:\.\./)+images/(?<name>[^''"\r\n]+\.(?:jpe?g|png))', [System.Text.RegularExpressions.RegexOptions]::IgnoreCase)

Get-ChildItem -LiteralPath $sourceRoot -Recurse -File |
    Where-Object { $_.Extension -in @('.vue', '.ts', '.js') } |
    ForEach-Object {
        $contents = Get-Content -LiteralPath $_.FullName -Raw
        foreach ($match in $assetPattern.Matches($contents)) {
            [void] $referencedNames.Add($match.Groups['name'].Value.Replace('/', '\'))
        }
    }

$jpegCodec = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() |
    Where-Object { $_.MimeType -eq 'image/jpeg' } |
    Select-Object -First 1

if (-not $jpegCodec) {
    throw 'The System.Drawing JPEG encoder is not available.'
}

$originalTotal = [long] 0
$optimizedTotal = [long] 0
$optimizedCount = 0
$skippedCount = 0

foreach ($relativeName in ($referencedNames | Sort-Object)) {
    $sourcePath = [System.IO.Path]::GetFullPath((Join-Path $imageRoot $relativeName))

    if (-not $sourcePath.StartsWith($imageRootPrefix, [System.StringComparison]::OrdinalIgnoreCase)) {
        throw "Resolved image path escaped the image directory: $relativeName"
    }

    if (-not (Test-Path -LiteralPath $sourcePath -PathType Leaf)) {
        continue
    }

    $sourceFile = Get-Item -LiteralPath $sourcePath
    $originalLength = [long] $sourceFile.Length
    $originalTotal += $originalLength
    $extension = $sourceFile.Extension.ToLowerInvariant()

    # System.Drawing can alter unusual alpha-channel masks in branded PNG files.
    # PNG processing is therefore opt-in and JPEG optimization remains the safe default.
    if ($extension -eq '.png' -and -not $OptimizePng) {
        $optimizedTotal += $originalLength
        $skippedCount++
        continue
    }

    $sourceImage = $null
    $targetBitmap = $null
    $graphics = $null
    $encoderParameters = $null
    $temporaryPath = "$sourcePath.seo-opt.tmp$extension"

    try {
        $sourceImage = [System.Drawing.Image]::FromFile($sourcePath)
        $maximumWidth = if ($extension -eq '.png') { $MaximumPngWidth } else { $MaximumJpegWidth }
        $shouldResize = $sourceImage.Width -gt $maximumWidth
        $shouldReencode = $extension -in @('.jpg', '.jpeg') -and $originalLength -gt 300KB

        if (-not $shouldResize -and -not $shouldReencode) {
            $optimizedTotal += $originalLength
            $skippedCount++
            continue
        }

        $targetWidth = if ($shouldResize) { $maximumWidth } else { $sourceImage.Width }
        $targetHeight = [Math]::Max(1, [int] [Math]::Round($sourceImage.Height * ($targetWidth / $sourceImage.Width)))
        $pixelFormat = if ($extension -eq '.png') {
            [System.Drawing.Imaging.PixelFormat]::Format32bppArgb
        } else {
            [System.Drawing.Imaging.PixelFormat]::Format24bppRgb
        }

        $targetBitmap = New-Object System.Drawing.Bitmap($targetWidth, $targetHeight, $pixelFormat)
        $targetBitmap.SetResolution(72, 72)
        $graphics = [System.Drawing.Graphics]::FromImage($targetBitmap)
        $graphics.CompositingMode = [System.Drawing.Drawing2D.CompositingMode]::SourceCopy
        $graphics.CompositingQuality = [System.Drawing.Drawing2D.CompositingQuality]::HighQuality
        $graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
        $graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
        $graphics.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality
        $graphics.DrawImage($sourceImage, 0, 0, $targetWidth, $targetHeight)

        if (Test-Path -LiteralPath $temporaryPath) {
            Remove-Item -LiteralPath $temporaryPath -Force
        }

        if ($extension -eq '.png') {
            $targetBitmap.Save($temporaryPath, [System.Drawing.Imaging.ImageFormat]::Png)
        } else {
            $encoderParameters = New-Object System.Drawing.Imaging.EncoderParameters(1)
            $encoderParameters.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter(
                [System.Drawing.Imaging.Encoder]::Quality,
                [long] $JpegQuality
            )
            $targetBitmap.Save($temporaryPath, $jpegCodec, $encoderParameters)
        }
    }
    finally {
        if ($graphics) { $graphics.Dispose() }
        if ($targetBitmap) { $targetBitmap.Dispose() }
        if ($sourceImage) { $sourceImage.Dispose() }
        if ($encoderParameters) { $encoderParameters.Dispose() }
    }

    if (-not (Test-Path -LiteralPath $temporaryPath -PathType Leaf)) {
        $optimizedTotal += $originalLength
        continue
    }

    $candidateLength = [long] (Get-Item -LiteralPath $temporaryPath).Length
    $savingPercent = if ($originalLength -gt 0) {
        [Math]::Round((1 - ($candidateLength / $originalLength)) * 100, 1)
    } else {
        0
    }

    if ($candidateLength -ge $originalLength -or $savingPercent -lt $MinimumSavingPercent) {
        Remove-Item -LiteralPath $temporaryPath -Force
        $optimizedTotal += $originalLength
        $skippedCount++
        continue
    }

    $optimizedTotal += $candidateLength
    $optimizedCount++
    $action = if ($Apply) { 'optimized' } else { 'would optimize' }
    Write-Output ("{0}: {1} ({2:N2} MB -> {3:N2} MB, {4}% smaller, {5}x{6})" -f
        $action,
        $relativeName,
        ($originalLength / 1MB),
        ($candidateLength / 1MB),
        $savingPercent,
        $targetWidth,
        $targetHeight)

    if ($Apply) {
        Move-Item -LiteralPath $temporaryPath -Destination $sourcePath -Force
    } else {
        Remove-Item -LiteralPath $temporaryPath -Force
    }
}

$totalSavingPercent = if ($originalTotal -gt 0) {
    [Math]::Round((1 - ($optimizedTotal / $originalTotal)) * 100, 1)
} else {
    0
}

Write-Output ("Referenced assets: {0}; {1}: {2}; skipped: {3}; projected total: {4:N2} MB -> {5:N2} MB ({6}% smaller)." -f
    $referencedNames.Count,
    $(if ($Apply) { 'optimized' } else { 'optimizable' }),
    $optimizedCount,
    $skippedCount,
    ($originalTotal / 1MB),
    ($optimizedTotal / 1MB),
    $totalSavingPercent)
