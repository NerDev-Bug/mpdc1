<template>
    <div class="w-full min-h-screen bg-gray-900 flex flex-col md:flex-row items-center justify-center p-6">
        <!-- Left Section: Heading & Paragraph with Scroll Animation -->
        <div ref="textSection"
            class="md:w-1/2 text-white text-lg font-cormorant leading-relaxed p-6 text-center md:text-left opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': textVisible }">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 md:mb-8">Our Conglomerate Map</h2>
            <p>
                LEADS Agricultural Products Corporation, the lead subsidiary of MHC, capitalized on skills in distributing useful
                and cost-effective farming solutions to grow the business beyond expectations. This opened new doors for expansion
                into other industries where plans to establish a head office turned into an opportunity to go into real estate.
            </p>
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
