# SEO deployment checklist

The public metadata and page content are server-rendered. A production deploy is complete only when the Laravel app and the Inertia SSR process are both running.

## Before building

- Point the web server document root at `public/`.
- Set `APP_URL` to the final public HTTPS origin, without a trailing slash. Canonicals, structured data, and the sitemap use this value.
- Confirm the preferred host resolves publicly and redirects HTTP and `www` traffic to the same HTTPS origin.

## Deploy commands

```shell
composer install --no-dev --optimize-autoloader
npm ci
npm run build:ssr
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

The storage link lets the web server deliver uploaded files directly and should
be kept healthy. News images also have an application fallback at
`/storage/news/{filename}` so a missing link does not leave the homepage or admin
preview blank.

## Keep SSR running

Run `php artisan inertia:start-ssr` under the server's process manager so it starts after a reboot and restarts after a failure or deploy. The built-in health endpoint should return a JSON status of `OK`:

```shell
curl --fail http://127.0.0.1:13714/health
```

Without this process, the site falls back to client rendering and the initial response no longer contains the page-specific H1 and metadata.

## Verify after deployment

```shell
curl --fail https://www.malvedaproperties.com/
curl --fail https://www.malvedaproperties.com/sitemap.xml
curl --fail -I https://www.malvedaproperties.com/login
curl --fail -I https://www.malvedaproperties.com/storage/news/REPLACE_WITH_A_REAL_FILENAME.jpg
```

Confirm the homepage response contains one `<title>`, one `<h1>`, a description, a canonical URL, and JSON inside an `application/ld+json` script. Confirm private routes return an `X-Robots-Tag: noindex` header.

After the public domain is live, submit `/sitemap.xml` in Google Search Console. The news index stays out of the sitemap and uses `noindex, follow` until the first complete article is published.
