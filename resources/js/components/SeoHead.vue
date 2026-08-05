<template>
    <Head :title="escapedTitle">
        <meta head-key="description" name="description" :content="escapedDescription" />
        <meta head-key="robots" name="robots" :content="escapedRobots" />
        <link v-if="canonicalUrl" head-key="canonical" rel="canonical" :href="escapedCanonicalUrl" />
        <link v-if="imageUrl && preloadImage" head-key="hero-image-preload" rel="preload" as="image" :href="escapedImageUrl" fetchpriority="high" />

        <meta head-key="og:type" property="og:type" :content="escapedType" />
        <meta head-key="og:title" property="og:title" :content="escapedTitle" />
        <meta head-key="og:description" property="og:description" :content="escapedDescription" />
        <meta v-if="canonicalUrl" head-key="og:url" property="og:url" :content="escapedCanonicalUrl" />
        <meta v-if="siteName" head-key="og:site_name" property="og:site_name" :content="escapedSiteName" />
        <meta v-if="imageUrl" head-key="og:image" property="og:image" :content="escapedImageUrl" />
        <meta v-if="imageUrl && imageAlt" head-key="og:image:alt" property="og:image:alt" :content="escapedImageAlt" />

        <meta head-key="twitter:card" name="twitter:card" :content="imageUrl ? 'summary_large_image' : 'summary'" />
        <meta head-key="twitter:title" name="twitter:title" :content="escapedTitle" />
        <meta head-key="twitter:description" name="twitter:description" :content="escapedDescription" />
        <meta v-if="imageUrl" head-key="twitter:image" name="twitter:image" :content="escapedImageUrl" />
        <meta v-if="imageUrl && imageAlt" head-key="twitter:image:alt" name="twitter:image:alt" :content="escapedImageAlt" />

        <JsonLd v-if="structuredDataJson" />
    </Head>
</template>

<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed, h } from 'vue';

type StructuredData = Record<string, unknown>;

interface SharedSeoProps {
    [key: string]: unknown;
    seo?: {
        siteName?: string;
        siteUrl?: string;
    };
}

const props = withDefaults(
    defineProps<{
        title: string;
        description: string;
        canonicalPath?: string;
        image?: string;
        imageAlt?: string;
        preloadImage?: boolean;
        robots?: string;
        type?: string;
        structuredData?: StructuredData | StructuredData[];
    }>(),
    {
        canonicalPath: undefined,
        image: undefined,
        imageAlt: undefined,
        preloadImage: true,
        robots: 'index, follow',
        type: 'website',
        structuredData: undefined,
    },
);

const page = usePage<SharedSeoProps>();

const siteName = computed(() => page.props.seo?.siteName?.trim() || 'MPDC');

const siteUrl = computed(() => {
    const configuredUrl = page.props.seo?.siteUrl?.trim();

    if (configuredUrl) {
        try {
            const parsedUrl = new URL(configuredUrl);

            if (parsedUrl.protocol === 'http:' || parsedUrl.protocol === 'https:') {
                return parsedUrl.toString();
            }
        } catch {
            // Use the current request origin when a configured URL is invalid.
        }
    }

    return typeof window !== 'undefined' ? window.location.origin : '';
});

const toAbsoluteUrl = (value: string, stripSearch = false) => {
    if (!value || !siteUrl.value) return '';

    try {
        const url = new URL(value, siteUrl.value);

        if (url.protocol !== 'http:' && url.protocol !== 'https:') return '';

        if (stripSearch) {
            url.search = '';
            url.hash = '';
        }

        return url.toString();
    } catch {
        return '';
    }
};

const canonicalUrl = computed(() => toAbsoluteUrl(props.canonicalPath || page.url || '/', true));
const imageUrl = computed(() => (props.image ? toAbsoluteUrl(props.image) : ''));

const escapeHeadHtml = (value: string) =>
    value
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');

const escapedTitle = computed(() => escapeHeadHtml(props.title));
const escapedDescription = computed(() => escapeHeadHtml(props.description));
const escapedRobots = computed(() => escapeHeadHtml(props.robots));
const escapedType = computed(() => escapeHeadHtml(props.type));
const escapedCanonicalUrl = computed(() => escapeHeadHtml(canonicalUrl.value));
const escapedSiteName = computed(() => escapeHeadHtml(siteName.value));
const escapedImageUrl = computed(() => escapeHeadHtml(imageUrl.value));
const escapedImageAlt = computed(() => escapeHeadHtml(props.imageAlt || ''));

const structuredDataJson = computed(() => {
    if (!props.structuredData) return '';

    const records = Array.isArray(props.structuredData) ? props.structuredData : [props.structuredData];
    const normalizedRecords = records.map((record) => {
        const normalizedRecord: StructuredData = {
            ...record,
            ...(typeof record.logo === 'string' ? { logo: toAbsoluteUrl(record.logo) } : {}),
            ...(typeof record.image === 'string' ? { image: toAbsoluteUrl(record.image) } : {}),
        };

        return {
            '@context': 'https://schema.org',
            ...(!normalizedRecord.name ? { name: props.title } : {}),
            ...(!normalizedRecord.description ? { description: props.description } : {}),
            ...(canonicalUrl.value && !normalizedRecord.url ? { url: canonicalUrl.value } : {}),
            ...(imageUrl.value && !normalizedRecord.image ? { image: imageUrl.value } : {}),
            ...normalizedRecord,
        };
    });
    const data = normalizedRecords.length === 1 ? normalizedRecords[0] : normalizedRecords;

    return JSON.stringify(data).replace(/</g, '\\u003c');
});

// Inertia's Vue Head serializer only writes VNode string children into script
// elements. A functional VNode keeps JSON-LD in the script body for both SSR
// and client navigation instead of serializing it as an invalid HTML attribute.
const JsonLd = () =>
    h(
        'script',
        {
            type: 'application/ld+json',
            'head-key': 'structured-data',
        },
        structuredDataJson.value,
    );
</script>
