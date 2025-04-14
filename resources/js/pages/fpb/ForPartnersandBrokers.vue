<template>
    <div class="w-full h-fit px-12 py-12"
        :style="{ backgroundImage: `url(${fpbbg})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <div class="w-full h-fit py-12 px-4">
            <div class="flex items-center justify-center flex-col lg:flex-row gap-12">
                <div class="w-full h-fit flex items-center justify-center">
                    <img src="../../images/partnerspic1.jpg" alt="Selfie" class="max-w-full h-fit">
                </div>
                <div class="w-full h-fit">
                    <div class="mb-8">
                        <h2 class="text-white text-3xl md:text-4xl lg:text-5xl font-montserrat font-semibold">Be one of Our Partners</h2>
                    </div>
                    <div class="">
                        <p class="font-montserrat text-1xl md:text-1xl lg:text-2xl text-justify text-white">
                            Join us in shaping the future of real estate by becoming an accredited partner of MPDC.
                            By getting accredited, you'll gain access to exclusive deals and a supportive network
                            designed
                            to help you succeed.
                            Together, we can elevate the industry standard and create unparalleled opportunities for
                            growth
                            and success.
                            Partner with MPDC today and let's build a thriving future, one property at a time.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import fpbbg from '../../images/fpb_bg_blue.jpg';

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
