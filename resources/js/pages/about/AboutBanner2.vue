<template>
    <div class="w-full min-h-screen bg-gray-200 flex flex-col md:flex-row items-center justify-center p-6 relative">
        <!-- Title Section -->
        <div class="absolute top-12 left-12">
            <h2 class="text-4xl md:text-5xl text-gray-700 font-montserrat font-bold">Our Conglomerate Map</h2>
        </div>
        <br>
        <!-- Left Section: Heading & Paragraph with Scroll Animation -->
        <div ref="textSection"
            class="md:w-1/2 text-gray-700 text-2xl font-montserrat leading-relaxed px-8 md:px-12 lg:px-6 py-24 text-center md:text-left opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': textVisible }">
            <p class="text-justify mt-24 sm:mt-4 md:mt-0">
                LEADS Agricultural Products Corporation, the lead subsidiary of MHC, capitalized on skills in distributing useful
                and cost-effective farming solutions to grow the business beyond expectations. This opened new doors for expansion
                into other industries where plans to establish a head office turned into an opportunity to go into real estate.
            </p>
        </div>

        <!-- Right Section: Image with Scroll Animation -->
        <div ref="imageSection"
            class="md:w-1/2 flex justify-center p-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': imageVisible }">
            <img src="../../images/logo3.png" alt="Conglomerate Map" class="max-w-full h-auto">
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
    const observerOptions: IntersectionObserverInit = { threshold: 0.5 };

    const observer = new IntersectionObserver((entries: IntersectionObserverEntry[]) => {
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
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
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
