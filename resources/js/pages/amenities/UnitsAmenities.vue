<template>
    <div class="w-full py-12 px-4 flex flex-col items-center md:flex-row md:justify-center md:space-x-6 lg:space-x-12">
        <h2 ref="textContainer"
            class="font-montserrat font-semibold text-white text-center text-3xl sm:text-4xl md:text-5xl font-serif leading-tight opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': isTextVisible }">
            Explore Our Unit
        </h2>
        <div ref="textContainer"
            class="flex flex-wrap justify-center gap-4 mt-4 md:mt-0 opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': isTextVisible }">
            <a href="/serviced-residence"
                :style="{ backgroundImage: `url(${goldbutton})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
                class="text-black font-montserrat font-semibold text-center px-12 py-3 rounded-2xl text-base sm:text-lg lg:text-xl shadow-md shadow-black transition duration-300 ">
                Serviced Residences
            </a>
            <a href="/private-residence"
                :style="{ backgroundImage: `url(${goldbutton})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
                class="text-black font-montserrat font-semibold text-center px-12 py-3 rounded-2xl text-base sm:text-lg lg:text-xl shadow-md shadow-black transition duration-300">
                Private Residences
            </a>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import goldbutton from '../../images/goldbutton34.jpg';

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
