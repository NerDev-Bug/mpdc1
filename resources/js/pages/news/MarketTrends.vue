<template>
    <div class="w-full h-fit bg-white relative">
        <div class="relative">
            <!-- Background Image -->
            <img src="../../images/markettrends.png" class="w-full h-[270px] md:h-auto object-cover">

            <!-- Title -->
            <div ref="textSection"
                class="absolute top-4 md:top-6 lg:top-10 left-3 md:left-6 lg:left-10 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': textVisible }">
                <h2 class="text-left font-cormorant text-white text-3xl md:text-5xl lg:text-6xl">
                    Market Trends
                </h2>
            </div>

            <!-- Overlay Section -->
            <div class="absolute inset-0 flex items-center justify-center px-4 mt-12 md:mt-16">
                <div ref="imageSection"
                    class="bg-black bg-opacity-60 w-full max-w-5xl h-auto md:h-[180px] rounded-lg md:rounded-full grid grid-cols-2 gap-4 md:gap-16 sm:flex sm:flex-row items-center justify-center px-4 md:px-12 py-4 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': imageVisible }">

                    <!-- First Statistic -->
                    <div class="flex flex-row items-center justify-center space-x-4">
                        <img src="../../images/money.png" class="w-12 h-12 md:w-20 md:h-20">
                        <div class="text-white text-center sm:text-left">
                            <h1 class="text-[20px] md:text-2xl font-bold">9000</h1>
                            <p class="text-sm md:text-md lg:text-lg">Condominium apartments <br> in strategic locations
                            </p>
                        </div>
                    </div>

                    <!-- Second Statistic -->
                    <div class="flex flex-row items-center justify-center space-x-4">
                        <img src="../../images/rate.png" class="w-10 h-10 md:w-20 md:h-20">
                        <div class="text-white text-center sm:text-left">
                            <h1 class="text-[20px] md:text-2xl font-bold">6% - 7%</h1>
                            <p class="text-sm md:text-md lg:text-lg">GDP Increase</p>
                        </div>
                    </div>

                    <!-- Third Statistic (Moves Below on Small Screens) -->
                    <div class="flex flex-row items-center justify-center space-x-4 col-span-2 sm:col-span-1">
                        <img src="../../images/list.png" class="w-10 h-10 md:w-20 md:h-20">
                        <div class="text-white text-center sm:text-left">
                            <h1 class="text-[20px] md:text-2xl font-bold">12.9%</h1>
                            <p class="text-sm md:text-md lg:text-lg">Increase in demand<br class="hidden md:block"> for
                                condos</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>



<script setup lang="ts">
import { ref, onMounted } from "vue";

const textVisible = ref<boolean>(false);
const imageVisible = ref<boolean>(false);
const textSection = ref<HTMLElement | null>(null);
const imageSection = ref<HTMLElement | null>(null);

// Intersection Observer for Scroll Animation
onMounted(() => {
    const observerOptions = { threshold: 0.5 };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target === textSection.value) {
                    textVisible.value = true;
                } else if (entry.target === imageSection.value) {
                    imageVisible.value = true;
                }
            }
        });
    }, observerOptions);

    if (textSection.value) observer.observe(textSection.value);
    if (imageSection.value) observer.observe(imageSection.value);
});
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
}

/* Initial State */
.opacity-0 {
    opacity: 0;
    transform: translateY(20px);
}

/* Fade-in on Scroll */
.fade-in {
    opacity: 1;
    transform: translateY(0);
}
</style>
