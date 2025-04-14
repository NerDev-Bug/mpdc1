<template>
    <AppLayout>
        <div class="flex flex-col min-h-screen bg-white">
            <!-- Hero Section -->
            <main class="relative bg-white">
                <div class="w-full h-fit xl:h-screen bg-cover bg-center relative flex flex-col justify-center px-12 md:px-16 lg:px-32 py-12 md:py-16 lg:py-32"
                    :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
                    <!-- Black Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>

                    <!-- Hero Title with Scroll Effect -->
                    <div ref="heroText"
                        class="relative z-10 w-full max-w-4xl opacity-0 translate-y-10 transition-all duration-1000 ease-out pt-24 lg:pt-0">
                        <h2
                            class="text-white font-montserrat text-center md:text-left text-2xl sm:text-[3rem] md:text-[3.5rem] lg:text-[4rem] xl:text-[4.5rem] font-bold leading-tight">
                            Purposeful
                            Living <br>
                            Redefined
                        </h2>
                    </div>

                    <!-- Text Box with Scroll Effect -->
                    <div ref="heroTextBox"
                        class="relative z-10 mt-6 md:mt-0 flex justify-center md:justify-end w-full opacity-0 translate-y-10 transition-all duration-1000 ease-out">
                        <div class="bg-black bg-opacity-60 text-white font-montserrat p-6 sm:p-8 md:p-10 rounded-lg
                                    w-full md:max-w-lg lg:max-w-xl xl:max-w-2xl shadow-lg">
                            <p class="text-base sm:text-lg md:text-xl leading-relaxed tracking-wide">
                                Malveda Properties and Development Corporation, a subsidiary and the real estate
                                division of Malveda Holding Corporation, was established in 2019. The company
                                specializes in innovative real estate developments strategically located in thriving and
                                emerging cities across the Philippines.
                            </p>
                            <p class="text-base sm:text-lg md:text-xl mt-2 leading-relaxed tracking-wide">
                                With a clear vision, a commitment to excellence, and unwavering dedication, MPDC aims to
                                deliver thoughtfully designed, distinctive, and premium real estate investments that
                                meet the evolving needs of its clients.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- About Banner -->
                <AboutBanner />
                <AboutBanner1 />
                <AboutBanner2 />
            </main>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import heroImage from '../../images/ame3.jpg';
import AppLayout from '@/layouts/AppLayout.vue';
import AboutBanner from './AboutBanner.vue';
import AboutBanner1 from './AboutBanner1.vue';
import AboutBanner2 from './AboutBanner2.vue';

// Refs for scroll animations
const heroText = ref<HTMLElement | null>(null);
const heroTextBox = ref<HTMLElement | null>(null);

onMounted(() => {
    const observerOptions: IntersectionObserverInit = {
        root: null,
        threshold: 0.2, // Triggers when 20% is visible
    };

    const handleIntersect = (entries: IntersectionObserverEntry[], observer: IntersectionObserver) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                observer.unobserve(entry.target); // Ensure animation runs only once
            }
        });
    };

    const observer = new IntersectionObserver(handleIntersect, observerOptions);

    if (heroText.value) observer.observe(heroText.value);
    if (heroTextBox.value) observer.observe(heroTextBox.value);
});
</script>



<style scoped>
/* Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}

/* Scroll Animation Initial State */
.opacity-0 {
    opacity: 0;
}

.opacity-100 {
    opacity: 1;
}

.translate-y-10 {
    transform: translateY(40px);
}

.translate-y-0 {
    transform: translateY(0);
}
</style>
