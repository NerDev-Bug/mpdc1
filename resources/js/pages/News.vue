<template>
    <div class="w-full h-fit p-6 md:p-10 lg:p-16 flex justify-center items-center"
        :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <div class="mx-auto h-full">
            <div class="relative w-full overflow-hidden flex justify-center items-center">
                <div class="relative group">
                    <transition name="fade" mode="out-in">
                        <img :key="currentIndex" :src="images[currentIndex].src" :alt="images[currentIndex].alt"
                            class="w-full max-w-[1300px] h-auto xs:h-auto sm:h-auto md:h-[750px] max-h-[750px] object-cover transition-transform duration-500 transform" />
                    </transition>
                    <div ref="textContainer" class="absolute top-[50%] left-[10%] text-white font-cormorant
                     opacity-0 transform translate-y-10 transition-all duration-700 ease-out"
                        :class="{ 'fade-in': isTextVisible }">
                        <h3 class="text-2xl sm:text-3xl md:text-5xl font-bold leading-tight">
                            {{ images[currentIndex].title }}
                        </h3>
                        <p class="mt-3 text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
                            {{ images[currentIndex].description }}
                        </p>
                    </div>
                    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[100%]">
                        <div class="transition-all duration-[3000ms]" :style="{ width: progressBarWidth }"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
// import temu1 from '../images/indulge_adjusted.jpg';
// import temu2 from '../images/let your  property work for you_adjusted.jpg';
// import temu3 from '../images/discover first rate amenities_adjusted.jpg';
// import temu1 from '../images/promotion/promo-1.jpg';
// import temu2 from '../images/promotion/promo-2.jpg';
// import temu3 from '../images/promotion/promo-3.jpg';
// import temu4 from '../images/promotion/promo-4.jpg';

import temu1 from '../images/promotion/august_promo_1.jpg';
import temu2 from '../images/promotion/august_promo_2.jpg';
import temu3 from '../images/promotion/august_promo_3.jpg';
import temu4 from '../images/promotion/august_promo_4.jpg';
import temu5 from '../images/promotion/august_promo_5.jpg';
import temu6 from '../images/promotion/august_promo_6.jpg';

// import temu5 from '../images/dash_bg.jpg';
import heroImage from '../images/pattbg.png'

interface Image {
    src: string;
    alt: string;
    title: string;
    description: string;
}

const images = ref<Image[]>([
    { src: temu1, alt: '', title: '', description: '' },
    { src: temu2, alt: '', title: '', description: '' },
    { src: temu3, alt: '', title: '', description: '' },
    { src: temu4, alt: '', title: '', description: '' },
    { src: temu5, alt: '', title: '', description: '' },
    { src: temu6, alt: '', title: '', description: '' },
]);

const currentIndex = ref<number>(0);
const progressBarWidth = ref<string>('0%');
let autoSlideInterval: NodeJS.Timeout;
const isTextVisible = ref<boolean>(false);
const isTitleVisible = ref<boolean>(false);
const textContainer = ref<HTMLElement | null>(null);
const titleContainer = ref<HTMLElement | null>(null);

const nextImage = (): void => {
    currentIndex.value = (currentIndex.value + 1) % images.value.length;
    resetProgress();
};

const startAutoSlide = (): void => {
    autoSlideInterval = setInterval(() => {
        nextImage();
    }, 5000);
};

const resetProgress = (): void => {
    progressBarWidth.value = '0%';
    setTimeout(() => {
        progressBarWidth.value = '100%';
    }, 50);
};

const handleIntersection = (entries: IntersectionObserverEntry[]): void => {
    entries.forEach((entry) => {
        if (entry.target === textContainer.value && entry.isIntersecting) {
            isTextVisible.value = true;
        }
        if (entry.target === titleContainer.value && entry.isIntersecting) {
            isTitleVisible.value = true;
        }
    });
};

onMounted(() => {
    startAutoSlide();
    resetProgress();
    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.6 });
    if (textContainer.value) observer.observe(textContainer.value);
    if (titleContainer.value) observer.observe(titleContainer.value);
});

onUnmounted(() => {
    clearInterval(autoSlideInterval);
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.8s ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.opacity-0 {
    opacity: 0;
    transform: translateY(20px);
}

.fade-in {
    opacity: 1;
    transform: translateY(0);
}
</style>
