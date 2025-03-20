<template>
    <div class="bg-white w-full h-fit">
        <!-- Hero Section -->
        <div class="flex flex-col items-center mt-6 px-4">
            <div class="bg-[#0F0F17] w-full h-fit px-12 py-8 md:py-12">
                <h2 ref="textSection"
                    class="text-3xl md:text-5xl font-cormorant text-white opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': textVisible }">Be one of Our Partners</h2>
            </div>
        </div>

        <!-- Content Section -->
        <div class="bg-[#D9D9D9] w-full h-fit py-8 px-4 md:px-8">
            <div ref="imageSection"
                class="flex flex-col md:flex-row items-center justify-center space-y-6 md:space-y-0 md:space-x-12 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': imageVisible }">
                <img src="../../images/selfie.png" alt="Selfie" class="max-w-full h-auto w-2/3 md:w-1/3">
                <div class="w-full max-w-3xl px-4">
                    <p class="font-cormorant text-2xl md:text-2xl lg:text-4xl text-justify text-black">
                        Join us in shaping the future of real estate by becoming an accredited partner of MPDC.
                        By getting accredited, you'll gain access to exclusive deals and a supportive network designed
                        to help you succeed.
                        Together, we can elevate the industry standard and create unparalleled opportunities for growth
                        and success.
                        Partner with MPDC today and let's build a thriving future, one property at a time.
                    </p>
                </div>
            </div>
        </div>
        <!-- Image Section -->
        <div class="flex justify-center">
            <img src="../../images/productknoledgeseminar.png" class="w-full h-auto">
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
