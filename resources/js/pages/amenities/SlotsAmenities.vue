<template>
    <!-- Responsive Amenities Section -->
    <div class="px-3">
        <div class="w-full h-auto bg-gray-300 mt-4 mb-4 p-6">
            <div ref="textContainer"
                class="relative w-full lg:w-1/2 flex flex-col order-2 lg:order-none opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': isTextVisible }">
                <h2
                    class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-semibold font-cormorant text-blue-900 px-4 sm:px-6 py-4">
                    Amenities
                </h2>
            </div>
            <!-- Grid Layout for Cards -->
            <div ref="imageContainer"
                class="grid grid-cols-1 sm:grid-cols-2 gap-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': isImageVisible }">

                <a href="#">
                    <!--Card 1-->
                    <div class="bg-[#8a7965] shadow-lg rounded-lg p-6">
                        <img src="../../images/amenities1.jpg" alt="Amenity 1"
                            class="w-full h-[285px] object-cover rounded-md">
                        <p class="text-2xl font-semibold font-cormorant text-white mt-3">Hotel Lobby</p>
                    </div>
                </a>

                <a href="#">
                    <!-- Card 2 -->
                    <div class="bg-[#8a7965] shadow-lg rounded-lg p-6">
                        <img src="../../images/amenities2.jpg" alt="Amenity 2"
                            class="w-full h-[285px] object-cover rounded-md">
                        <p class="text-2xl font-semibold font-cormorant text-white mt-3">Indoor Pool</p>
                    </div>
                </a>

                <a href="#">
                    <!-- Card 3 -->
                    <div class="bg-[#8a7965] shadow-lg rounded-lg p-6">
                        <img src="../../images/amenities3.jpg" alt="Amenity 3"
                            class="w-full h-[285px] object-cover rounded-md">
                        <p class="text-2xl font-semibold font-cormorant text-white mt-3">Gym</p>
                    </div>
                </a>

                <a href="#">
                    <!-- Card 4 -->
                    <div class="bg-[#8a7965] shadow-lg rounded-lg p-6">
                        <img src="../../images/amenities4.jpg" alt="Amenity 4"
                            class="w-full h-[285px] object-cover rounded-md">
                        <p class="text-2xl font-semibold font-cormorant text-white mt-3">Function Room</p>
                    </div>
                </a>

                <a href="#">
                    <!-- Card 5 -->
                    <div class="bg-[#8a7965] shadow-lg rounded-lg p-6">
                        <img src="../../images/amenities5.jpg" alt="Amenity 5"
                            class="w-full h-[285px] object-cover rounded-md">
                        <p class="text-2xl font-semibold font-cormorant text-white mt-3">Roof Deck Bar</p>
                    </div>
                </a>

                <a href="#">
                    <!-- Card 6 -->
                    <div class="bg-[#8a7965] shadow-lg rounded-lg p-6">
                        <img src="../../images/amenities6.jpg" alt="Amenity 6"
                            class="w-full h-[285px] object-cover rounded-md">
                        <p class="text-2xl font-semibold font-cormorant text-white mt-3">Roof Deck Pool</p>
                    </div>
                </a>
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
