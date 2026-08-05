<template>
    <AppLayout>
        <SeoHead
            :title="article.meta_title"
            :description="article.meta_description"
            :canonical-path="article.canonical_path"
            :image="article.image_url"
            :image-alt="article.alt_text"
            type="article"
            :structured-data="structuredData"
        />

        <main class="min-h-screen bg-[#f7f5f1] pt-20 font-montserrat text-[#1c2852]">
            <article>
                <header class="bg-[#10182f] px-6 py-12 text-white sm:py-16 lg:px-16">
                    <div class="mx-auto max-w-4xl">
                        <nav aria-label="Breadcrumb" class="mb-8 text-sm text-slate-300">
                            <Link href="/news" class="hover:text-white hover:underline">News and Updates</Link>
                            <span class="mx-2" aria-hidden="true">/</span>
                            <span aria-current="page">Article</span>
                        </nav>
                        <time :datetime="article.published_at" class="text-xs font-semibold uppercase tracking-[0.2em] text-[#d4b578]">
                            {{ formattedDate }}
                        </time>
                        <h1 class="mt-4 font-cormorant text-4xl font-bold leading-tight sm:text-5xl lg:text-6xl">
                            {{ article.title }}
                        </h1>
                        <p v-if="article.description" class="mt-6 max-w-3xl text-lg leading-8 text-slate-200">
                            {{ article.description }}
                        </p>
                    </div>
                </header>

                <div class="mx-auto max-w-5xl px-6 py-10 sm:py-14 lg:px-8">
                    <img
                        :src="article.image_url"
                        :alt="article.alt_text"
                        :width="article.image_width || undefined"
                        :height="article.image_height || undefined"
                        fetchpriority="high"
                        decoding="async"
                        class="h-auto w-full rounded-sm shadow-sm"
                    />

                    <div class="mx-auto mt-10 max-w-3xl font-cormorant text-xl leading-8 text-slate-800 sm:text-2xl sm:leading-9">
                        <p v-for="(paragraph, index) in bodyParagraphs" :key="index" class="mb-6 whitespace-pre-line">
                            {{ paragraph }}
                        </p>
                    </div>

                    <div class="mx-auto mt-12 max-w-3xl border-t border-[#1c2852]/15 pt-6">
                        <Link href="/news" class="inline-flex items-center text-sm font-semibold text-[#1c2852] hover:underline">
                            <span class="mr-2" aria-hidden="true">&larr;</span> Back to News and Updates
                        </Link>
                    </div>
                </div>
            </article>
        </main>
    </AppLayout>
</template>

<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Article {
    id: number;
    title: string;
    description: string | null;
    body: string;
    image_url: string;
    image_width: number | null;
    image_height: number | null;
    alt_text: string;
    published_at: string;
    updated_at: string;
    canonical_path: string;
    canonical_url: string;
    meta_title: string;
    meta_description: string;
}

interface SharedProps {
    [key: string]: unknown;
    seo?: {
        siteUrl?: string;
    };
}

const props = defineProps<{
    article: Article;
}>();

const page = usePage<SharedProps>();

const bodyParagraphs = computed(() =>
    props.article.body
        .split(/\r?\n\s*\r?\n/)
        .map((paragraph) => paragraph.trim())
        .filter(Boolean),
);

const formattedDate = computed(() =>
    new Intl.DateTimeFormat('en-PH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'Asia/Manila',
    }).format(new Date(props.article.published_at)),
);

const siteUrl = computed(() => {
    const configuredUrl = page.props.seo?.siteUrl?.trim();

    if (configuredUrl) {
        try {
            const url = new URL(configuredUrl);
            url.search = '';
            url.hash = '';

            return url.toString().replace(/\/?$/, '/');
        } catch {
            // Fall back to the origin of the canonical article URL.
        }
    }

    try {
        return `${new URL(props.article.canonical_url).origin}/`;
    } catch {
        return props.article.canonical_url;
    }
});

const publisher = computed(() => ({
    '@type': 'Organization',
    name: 'Malveda Properties and Development Corporation',
    url: siteUrl.value,
}));

const structuredData = computed(() => ({
    '@type': 'Article',
    headline: props.article.title,
    description: props.article.meta_description,
    image: [props.article.image_url],
    datePublished: props.article.published_at,
    dateModified: props.article.updated_at,
    author: publisher.value,
    mainEntityOfPage: {
        '@type': 'WebPage',
        '@id': props.article.canonical_url,
    },
    publisher: {
        ...publisher.value,
        logo: {
            '@type': 'ImageObject',
            url: new URL('icon.png', siteUrl.value).toString(),
        },
    },
}));
</script>
