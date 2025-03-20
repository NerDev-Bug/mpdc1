<template>
    <div class="w-full h-fit bg-white flex justify-center px-2 py-4">
        <div class="w-full h-fit bg-white">
            <div ref="imageSection"
                class="grid grid-cols-1 sm:grid-cols-2 gap-6 px-4 py-4 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': imageVisible }">
                <div>
                    <div class="relative w-full max-w-2xl mx-auto">
                        <!-- Black Transparent Overlay -->
                        <div class="absolute inset-0 bg-black opacity-50 rounded-lg"></div>
                        <img src="../../images/thecerisetowertoppingoffcelebration.png"
                            alt="The Cerise Tower Topping Off Celebration" class="w-full h-auto rounded-lg shadow-2xl">
                        <h2
                            class="absolute bottom-5 md:bottom-6 lg:bottom-7 left-5 font-cormorant text-white text-2xl md:text-3xl lg:text-4xl font-bold px-4 py-2 rounded-lg">
                            The Cerise Tower Topping <br>Off Celebration
                        </h2>
                    </div>
                    <div class="w-full h-fit px-4 py-4">
                        <h1 class="text-xl font-cormorant text-black text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </h1>
                    </div>
                </div>
                <div>
                    <div class="relative w-full max-w-2xl mx-auto">
                        <!-- Black Transparent Overlay -->
                        <div class="absolute inset-0 bg-black opacity-50 rounded-lg"></div>
                        <img src="../../images/adhikahomesgroundbreakingceremony.png"
                            class="w-full h-auto rounded-lg shadow-2xl">
                        <h2
                            class="absolute bottom-5 md:bottom-6 lg:bottom-7 left-5 font-cormorant text-white text-2xl md:text-3xl lg:text-4xl font-bold px-4 py-2 rounded-lg">
                            Adhika Homes <br>Groundbreaking Ceremony
                        </h2>
                    </div>
                    <div class="w-full h-fit px-4 py-4">
                        <h1 class="text-xl font-cormorant text-black text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </h1>
                    </div>
                </div>
                <div>
                    <div class="relative w-full max-w-2xl mx-auto">
                        <!-- Black Transparent Overlay -->
                        <div class="absolute inset-0 bg-black opacity-50 rounded-lg"></div>
                        <img src="../../images/marchopenhouseeventsunshine&lemonade.png"
                            class="w-full h-auto rounded-lg shadow-2xl">
                        <h2
                            class="absolute bottom-5 md:bottom-6 lg:bottom-7 left-5 font-cormorant text-white text-2xl md:text-3xl lg:text-4xl font-bold px-4 py-2 rounded-lg">
                            March Open House Event:<br>Sunshine & Lemonade
                        </h2>
                    </div>
                    <div class="w-full h-fit px-4 py-4">
                        <h1 class="text-xl font-cormorant text-black text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </h1>
                    </div>
                </div>
                <div>
                    <div class="relative w-full max-w-2xl mx-auto">
                        <!-- Black Transparent Overlay -->
                        <div class="absolute inset-0 bg-black opacity-50 rounded-lg"></div>
                        <img src="../../images/celebratesustainingsuccessthisyearofthewooddragon.png"
                            class="w-full h-auto rounded-lg shadow-2xl">
                        <h2
                            class="absolute bottom-5 md:bottom-6 lg:bottom-7 left-5 font-cormorant text-white text-2xl md:text-3xl lg:text-4xl font-bold px-4 py-2 rounded-lg">
                            Celebrate Sustaining<br>Success This Year of The<br> Wood Dragon
                        </h2>
                    </div>
                    <div class="w-full h-fit px-4 py-4">
                        <h1 class="text-xl font-cormorant text-black text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </h1>
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
