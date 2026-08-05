<template>
    <AppLayout>
        <SeoHead
            title="News and Updates"
            description="Read official news, property updates, and announcements from Malveda Properties and Development Corporation."
            canonical-path="/news"
            :robots="articles.length ? 'index, follow' : 'noindex, follow'"
            :preload-image="false"
            :structured-data="structuredData"
        />

        <main class="min-h-screen bg-[#f7f5f1] pt-20 font-montserrat text-[#1c2852]">
            <header class="bg-[#10182f] px-6 py-16 text-white sm:py-20 lg:px-16">
                <div class="mx-auto max-w-6xl">
                    <p class="mb-3 text-sm font-semibold uppercase tracking-[0.24em] text-[#d4b578]">MPDC</p>
                    <h1 class="font-cormorant text-4xl font-bold leading-tight sm:text-5xl lg:text-6xl">News and Updates</h1>
                    <p class="mt-5 max-w-2xl text-base leading-relaxed text-slate-200 sm:text-lg">
                        Official property updates, announcements, and stories from Malveda Properties and Development Corporation.
                    </p>
                </div>
            </header>

            <section class="mx-auto max-w-6xl px-6 py-12 sm:py-16 lg:px-8" aria-label="Published articles">
                <div v-if="articles.length" class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="article in articles"
                        :key="article.id"
                        class="overflow-hidden rounded-sm bg-white shadow-sm ring-1 ring-black/5 transition-transform duration-300 hover:-translate-y-1"
                    >
                        <Link :href="article.canonical_path" class="group block h-full">
                            <img
                                :src="article.image_url"
                                :alt="article.alt_text"
                                :width="article.image_width || undefined"
                                :height="article.image_height || undefined"
                                loading="lazy"
                                decoding="async"
                                class="h-auto w-full"
                            />
                            <div class="p-6">
                                <time :datetime="article.published_at" class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8b6c38]">
                                    {{ formatDate(article.published_at) }}
                                </time>
                                <h2 class="mt-3 font-cormorant text-2xl font-bold leading-snug text-[#1c2852] group-hover:underline">
                                    {{ article.title }}
                                </h2>
                                <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">
                                    {{ article.summary }}
                                </p>
                                <span class="mt-5 inline-flex items-center text-sm font-semibold text-[#1c2852]">
                                    Read article <span class="ml-2" aria-hidden="true">&rarr;</span>
                                </span>
                            </div>
                        </Link>
                    </article>
                </div>

                <div v-else class="rounded-sm bg-white px-6 py-14 text-center shadow-sm ring-1 ring-black/5">
                    <p class="font-cormorant text-2xl font-semibold text-[#1c2852]">No articles have been published yet.</p>
                    <p class="mt-2 text-sm text-slate-600">Please check back for official MPDC updates.</p>
                </div>
            </section>
        </main>
    </AppLayout>
</template>

<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface ArticleSummary {
    id: number;
    title: string;
    summary: string;
    image_url: string;
    image_width: number | null;
    image_height: number | null;
    alt_text: string;
    published_at: string;
    canonical_path: string;
    canonical_url: string;
}

const props = defineProps<{
    articles: ArticleSummary[];
}>();

const structuredData = computed(() => ({
    '@type': 'CollectionPage',
    name: 'News and Updates',
    mainEntity: {
        '@type': 'ItemList',
        numberOfItems: props.articles.length,
        itemListElement: props.articles.map((article, index) => ({
            '@type': 'ListItem',
            position: index + 1,
            name: article.title,
            url: article.canonical_url,
        })),
    },
}));

const formatDate = (value: string) =>
    new Intl.DateTimeFormat('en-PH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'Asia/Manila',
    }).format(new Date(value));
</script>
