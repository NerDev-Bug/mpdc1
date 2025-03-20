<template>
    <div class="w-full h-fit xl:h-screen flex items-center justify-center py-12"
        :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <div class="flex items-center justify-center flex-col md:flex-row px-8 lg:px-4 gap-4 lg:gap-8 w-full max-w-7xl">
            <!-- Left Section: Heading & Paragraph with Scroll Animation -->
            <div ref="textSection"
                class="md:w-1/2 text-white font-cormorant leading-relaxed text-center md:text-left opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': textVisible }">
                <h2 class="text-2xl sm:text-3xl md:text-3xl lg:text-3xl xl:text-5xl font-bold mb-4 sm:mb-6 md:mb-8">
                    Citadines Southwoods <br> Biñan at the Cerise Tower
                </h2>
                <div class="bg-black bg-opacity-50 w-full h-fit px-8 py-8">
                    <p class="text-sm sm:text-base md:text-1xl lg:text-1xl xl:text-2xl text-justify">
                    The Cerise Tower is MPDC’s first project set to rise in Southwoods City, Biñan, Laguna. Designed for
                    business owners and corporate executives, MPDC and The Ascott Limited partnered to create a
                    master-planned 22-floor mixed-use building equipped to offer a world-class Live-Work-Play-Relax lifestyle.
                </p>
                </div>
                <!-- Navigation Links -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 md:gap-8 mt-6 sm:mt-8 md:mt-10 lg:mt-12">
                    <a class="text-base sm:text-lg md:text-[13px] lg:text-[13px] xl:text-2xl bg-[#7995B0] border rounded-xl border-black px-4 sm:px-6 py-2 text-black hover:bg-white hover:text-black transition text-center"
                        href="/location">Location</a>
                    <a class="text-base sm:text-lg md:text-[13px] lg:text-[13px] xl:text-2xl bg-[#7995B0] border rounded-xl border-black px-4 sm:px-6 py-2 text-black hover:bg-white hover:text-black transition text-center"
                        href="/amenities">Amenities</a>
                    <a class="text-base sm:text-lg md:text-[12.8px] lg:text-[12.8px] xl:text-2xl bg-[#7995B0] border rounded-xl border-black px-4 sm:px-6 py-2 text-black hover:bg-white hover:text-black transition text-center"
                        href="/service-residence">Serviced Residences</a>
                    <a class="text-base sm:text-lg md:text-[13px] lg:text-[13px] xl:text-2xl bg-[#7995B0] border rounded-xl border-black px-4 sm:px-6 py-2 text-black hover:bg-white hover:text-black transition text-center"
                        href="/private-residence">Private Residences</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <!-- Right Section: Image with Bordered Background -->
                <div ref="imageSection"
                    class="bg-[#0b1021] w-full max-w-lg sm:max-w-xl md:max-w-[550px] lg:max-w-1xl xl:max-w-1xl p-4 sm:p-3 flex justify-center opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': imageVisible }">
                    <img src="../../images/citadines_normal-view.jpg"
                        class="w-full h-auto shadow-lg object-cover rounded-lg translate-x-2 translate-y-2">
                </div>
            </div>
        </div>
    </div>
</template>



<script setup lang="ts">
import { ref, onMounted } from "vue";
import heroImage from '../../images/pattern21.png';

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
