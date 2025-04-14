<template>
    <div class="bg-[#1a2a56] py-12 px-8 md:px-32 flex justify-center relative">
        <div class="w-full max-w-screen-xl flex flex-col lg:flex-row items-start overflow-hidden">

            <!-- Image with Scroll-based Fade-in Effect -->
            <div ref="imageContainer"
                class="w-full lg:w-1/2 flex relative order-1 lg:order-none opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': isImageVisible }">
                <img src="../images/ame2.jpg" alt="Community View" class="w-full h-full object-cover rounded-l-lg" />
            </div>

            <!-- Text Box with Scroll-based Fade-in Effect -->
            <div ref="textContainer"
                class="relative w-full lg:w-1/2 flex flex-col order-2 lg:order-none opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': isTextVisible }">

                <!-- Text Box -->
                <div
                    class="bg-gray-300 p-8 md:p-12 w-full flex flex-col justify-between md:min-h-[450px] lg:min-h-[592px] relative z-10 rounded-r-lg">

                    <!-- Title -->
                    <h4 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-semibold font-montserrat text-blue-900">
                        Location
                    </h4>

                    <!-- Text Content -->
                    <div class="flex-grow">
                        <p class="text-black text-lg md:text-xl mt-10 leading-relaxed font-montserrat">
                            Nestled in a master planned estate in close proximity to techno-industrial parks, Citadines
                            Southwoods
                            Binan is made suitable for
                            both short-term and long-term accommodation for corporate guests such as expats working
                            around the area.
                            It is also conveniently situated
                            at roughly 10 kilometers from Alabang.
                        </p>
                        <a href="/location">
                            <button
                                class="mt-12 px-10 py-3 bg-blue-900 text-white text-lg font-semibold rounded-lg hover:bg-blue-800 transition block mx-auto">
                                Visit our Showroom
                            </button>
                        </a>


                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

const isImageVisible = ref(false);
const isTextVisible = ref(false);
const imageContainer = ref<HTMLElement | null>(null);
const textContainer = ref<HTMLElement | null>(null);

// Intersection Observer for smooth fade-in when scrolling
const handleIntersection = (entries: IntersectionObserverEntry[]) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            if (entry.target === imageContainer.value) {
                isImageVisible.value = true;
            }
            if (entry.target === textContainer.value) {
                isTextVisible.value = true;
            }
        }
    });
};

onMounted(() => {
    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.3 });

    if (imageContainer.value) observer.observe(imageContainer.value);
    if (textContainer.value) observer.observe(textContainer.value);
});
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}

/* Scroll-based Fade-in */
.opacity-0 {
    opacity: 0;
    transform: translateY(20px);
}

.fade-in {
    opacity: 1;
    transform: translateY(0);
}
</style>
