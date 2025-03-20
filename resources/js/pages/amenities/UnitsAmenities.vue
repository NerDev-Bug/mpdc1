<template>
    <div
        class="bg-[#8a7965] w-full py-12 px-4 flex flex-col items-center md:flex-row md:justify-center md:space-x-6 lg:space-x-12">
        <h2 ref="textContainer"
            class="text-[#1c3459] text-center text-3xl sm:text-4xl md:text-5xl font-serif leading-tight opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': isTextVisible }">
            Explore Our Unit
        </h2>
        <div ref="textContainer"
            class="flex flex-wrap justify-center gap-4 mt-4 md:mt-0 opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': isTextVisible }">
            <a href="/residence1"
                class="bg-[#2db24a] text-white text-center px-6 py-3 rounded-2xl text-base sm:text-lg shadow-md transition duration-300 hover:bg-[#24993e]">
                Serviced Residences
            </a>
            <a href="/residence2"
                class="bg-[#2db24a] text-white text-center px-6 py-3 rounded-2xl text-base sm:text-lg shadow-md transition duration-300 hover:bg-[#24993e]">
                Private Residences
            </a>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

const isTextVisible = ref(false);
const textContainer = ref<HTMLElement | null>(null);

// Intersection Observer for smooth fade-in when scrolling
const handleIntersection = (entries: IntersectionObserverEntry[]) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {

            if (entry.target === textContainer.value) {
                isTextVisible.value = true;
            }
        }
    });
};

onMounted(() => {
    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.3 });

    if (textContainer.value) observer.observe(textContainer.value);
});
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
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
