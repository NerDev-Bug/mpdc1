<template>
    <AppLayout>
        <div class="flex flex-col min-h-screen bg-white">
            <div class="w-full h-fit flex items-center justify-center px-4 pt-[100px] md:pt-[110px] lg:pt-32 py-8"
                :style="{ backgroundImage: `url(${heroImage})` }">
                <div class="bg-black bg-opacity-50 w-full max-w-9xl mx-auto p-3 sm:p-4 md:p-6 lg:p-8 rounded-lg">
                    <h2 ref="textContainer"
                        class="text-white text-3xl sm:text-4xl md:text-5xl font-cormorant font-semibold opacity-0 translate-y-10 transition-all duration-700 ease-out"
                        :class="{ 'fade-in': isTextVisible }">Contact Us</h2>

                    <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-8 mt-6">
                        <div ref="imageContainer"
                            class="w-full lg:w-1/2 flex justify-center opacity-0 translate-y-10 transition-all duration-700 ease-out"
                            :class="{ 'fade-in': isImageVisible }">
                            <img src="../../images/Cerise.png" class="max-w-full h-auto rounded-lg object-cover">
                        </div>

                        <form ref="textContainer" class="w-full lg:w-1/2 space-y-4 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                            :class="{ 'fade-in': isTextVisible }">
                            <!-- Name Field -->
                            <div>
                                <label class="text-white text-lg sm:text-xl font-cormorant">Name</label>
                                <input type="text" class="w-full border border-gray-200 rounded-lg p-2 text-black" placeholder="Juan Dela Cruz jr.">
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="text-white text-lg sm:text-xl font-cormorant">Email</label>
                                <input type="email" class="w-full border border-gray-200 rounded-lg p-2 text-black" placeholder="example@gmail.com">
                            </div>

                            <!-- Contact & Unit Type -->
                            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                                <!-- Contact Field -->
                                <div class="w-full sm:w-1/2">
                                    <label class="text-white text-lg sm:text-xl font-cormorant">Contact</label>
                                    <input type="text" class="w-full border border-gray-200 rounded-lg p-2 text-black" placeholder="0987654321">
                                </div>
                                <!-- Unit Type Dropdown -->
                                <div class="w-full sm:w-1/2">
                                    <label class="text-white text-lg sm:text-xl font-cormorant">Unit type</label>
                                    <select class="w-full border border-gray-200 rounded-lg p-2 text-black">
                                        <option value="" selected disabled hidden>Select a unit type</option>
                                        <option value="penthouse">Penthouse</option>
                                        <option value="apartment">Apartment</option>
                                        <option value="condo">Condo</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Message Field -->
                            <div>
                                <label class="text-white text-lg sm:text-xl font-cormorant">Inquiry</label>
                                <textarea class="w-full border border-gray-200 rounded-lg p-3 text-black resize-none h-32 focus:ring-2 focus:ring-[#A69379] focus:border-[#A69379]" placeholder="Write your message here..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button class="w-full bg-[#1C2852] text-white text-lg font-semibold py-2 rounded-lg hover:bg-slate-500 transition">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script setup lang="ts">
import { ref, onMounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import heroImage from '../../images/contactimage.png';

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
