<template>
    <section
        class="flex h-fit w-full items-center justify-center p-6 md:p-10 lg:p-16"
        aria-labelledby="news-carousel-heading"
        :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
    >
        <h2 id="news-carousel-heading" class="sr-only">Latest news and property updates</h2>
        <div class="mx-auto h-full">
            <div class="relative flex w-full items-center justify-center overflow-hidden">
                <figure
                    class="group relative max-w-[1300px]"
                    aria-roledescription="carousel"
                    :aria-label="`Slide ${currentIndex + 1} of ${images.length}`"
                >
                    <component
                        :is="currentSlide.url ? 'a' : 'div'"
                        :href="currentSlide.url || undefined"
                        :aria-label="currentSlide.url ? `Read ${currentSlide.title || currentSlide.alt}` : undefined"
                        class="block"
                    >
                        <transition name="fade" mode="out-in">
                            <img
                                :key="currentIndex"
                                :src="currentSlide.src"
                                :alt="currentSlide.alt || currentSlide.title"
                                width="1920"
                                height="1079"
                                loading="lazy"
                                decoding="async"
                                class="xs:h-auto h-auto max-h-[750px] w-full max-w-[1300px] transform object-cover transition-transform duration-500 sm:h-auto md:h-[750px]"
                            />
                        </transition>
                    </component>

                    <button
                        v-if="images.length > 1"
                        type="button"
                        aria-label="Show previous update"
                        class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-black/60 px-4 py-3 text-2xl text-white hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
                        @click="previousImage"
                    >
                        <span aria-hidden="true">‹</span>
                    </button>
                    <button
                        v-if="images.length > 1"
                        type="button"
                        aria-label="Show next update"
                        class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-black/60 px-4 py-3 text-2xl text-white hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
                        @click="nextImage"
                    >
                        <span aria-hidden="true">›</span>
                    </button>
                    <div v-if="images.length > 1" class="absolute right-3 top-3">
                        <button
                            type="button"
                            :aria-label="isPaused ? 'Play updates' : 'Pause updates'"
                            class="rounded bg-black/60 px-3 py-2 text-sm text-white hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
                            @click="toggleAutoplay"
                        >
                            {{ isPaused ? 'Play' : 'Pause' }}
                        </button>
                    </div>
                </figure>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';

import slide1 from '../images/dec_1.jpg';
import slide2 from '../images/dec_2.jpg';
import slide3 from '../images/dec_3.jpg';
import slide4 from '../images/dec_4.jpg';
import slide5 from '../images/dec_5.jpg';
import slide6 from '../images/dec_6.jpg';

import heroImage from '../images/pattbg.png';

interface SlideData {
    id?: number;
    src: string;
    alt: string;
    title: string;
    description: string;
    url?: string;
}

const props = withDefaults(
    defineProps<{
        slides?: SlideData[];
    }>(),
    {
        slides: () => [],
    },
);

// Fallback static images
const staticImages: SlideData[] = [
    {
        src: slide1,
        alt: 'The Cerise Tower and the 2025 Dot Property Philippines Awards winner plaque',
        title: 'Best Serviced Apartment at the 2025 Dot Property Philippines Awards',
        description: 'Citadines Southwoods Biñan at The Cerise Tower received the Best Serviced Apartment award.',
    },
    {
        src: slide2,
        alt: 'Citadines Southwoods Biñan roof-deck pool reservation promotion',
        title: 'Citadines Southwoods Biñan campaign archive',
        description: 'Previously published campaign artwork featuring the roof-deck pool.',
    },
    {
        src: slide3,
        alt: 'Living area of a Citadines Southwoods Biñan hotel unit',
        title: 'Own a Citadines hotel unit',
        description: 'Explore hotel-unit ownership at Citadines Southwoods Biñan at The Cerise Tower.',
    },
    {
        src: slide4,
        alt: 'Dining and living area in a private residence at The Cerise Tower',
        title: 'Private residences at The Cerise Tower',
        description: 'Discover private residence living with hotel-style amenities in Southwoods City, Biñan.',
    },
    {
        src: slide5,
        alt: 'The Cerise Tower year-end reservation promotion',
        title: 'The Cerise Tower year-end campaign archive',
        description: 'Previously published year-end campaign artwork from The Cerise Tower.',
    },
    {
        src: slide6,
        alt: 'Citadines Southwoods Biñan property-viewing promotion',
        title: 'The Cerise Tower property-viewing campaign archive',
        description: 'Previously published property-viewing campaign artwork from The Cerise Tower.',
    },
];

// Use dynamic slides from DB if available, otherwise fall back to static
const images = computed(() => {
    return props.slides && props.slides.length > 0 ? props.slides : staticImages;
});

const currentIndex = ref<number>(0);
const isPaused = ref<boolean>(false);
let autoSlideInterval: ReturnType<typeof setInterval> | undefined;

const currentSlide = computed(() => images.value[currentIndex.value] ?? staticImages[0]);

const nextImage = (): void => {
    currentIndex.value = (currentIndex.value + 1) % images.value.length;
};

const previousImage = (): void => {
    currentIndex.value = (currentIndex.value - 1 + images.value.length) % images.value.length;
};

const startAutoSlide = (): void => {
    if (autoSlideInterval) clearInterval(autoSlideInterval);
    if (images.value.length < 2 || isPaused.value) return;

    autoSlideInterval = setInterval(() => {
        nextImage();
    }, 5000);
};

const toggleAutoplay = (): void => {
    isPaused.value = !isPaused.value;
    startAutoSlide();
};

onMounted(() => {
    isPaused.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    startAutoSlide();
});

onUnmounted(() => {
    if (autoSlideInterval) clearInterval(autoSlideInterval);
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.8s ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
