<template>
    <div :style="{ backgroundImage: `url(${bgsilk})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <!-- Responsive Amenities Section -->
        <div class="px-3">
            <div class="w-full h-auto p-6">
                <div ref="textContainer"
                    class="relative w-full lg:w-1/2 flex flex-col order-2 lg:order-none opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': isTextVisible }">
                    <h1
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-semibold font-montserrat text-white px-4 sm:px-6 py-4 mb-4">
                        Amenities
                    </h1>
                </div>
                <!-- Grid Layout for Cards -->
                <div ref="imageContainer"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': isImageVisible }">

                    <button v-for="amenity in amenities" :key="amenity.title" type="button" aria-haspopup="dialog"
                        :aria-label="`View a larger photo of the ${amenity.title}`"
                        class="w-full text-left" @click="openPreview(amenity)">
                        <div class="bg-[#8a7965] shadow-lg rounded-lg p-6 cursor-pointer">
                            <img :src="amenity.image" :alt="`${amenity.title} at The Cerise Tower`"
                                :width="amenity.width" :height="amenity.height" loading="lazy" decoding="async"
                                class="w-full h-[285px] object-cover rounded-md">
                            <p class="text-2xl font-semibold font-montserrat text-white mt-3">{{ amenity.title }}</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div v-if="showPreview" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 z-50"
            @click.self="closePreview">
            <div role="dialog" aria-modal="true" :aria-label="`${previewTitle} image preview`"
                class="relative bg-white rounded-lg p-8 max-w-5xl w-11/12 shadow-lg">
                <!-- Close Button -->
                <button type="button" aria-label="Close image preview"
                    class="absolute top-1 right-2 text-gray-700 text-3xl font-bold hover:text-gray-900 transition-transform transform hover:scale-110"
                    @click="closePreview">
                    &times;
                </button>


                <!-- Image & Title -->
                <img :src="previewImage" :alt="`${previewTitle} at The Cerise Tower`" :width="previewWidth"
                    :height="previewHeight" decoding="async"
                    class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
                <h2 class="text-center text-2xl font-semibold text-gray-900 mt-6">{{ previewTitle }}</h2>
            </div>
        </div>
        <div>
            <UnitsAmenities />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import UnitsAmenities from './UnitsAmenities.vue';
import bgsilk from '../../images/bg silk1.jpg';

// Import images correctly from assets
import amenities1 from '../../images/amenities1.jpg';
import amenities2 from '../../images/amenities2.jpg';
import amenities3 from '../../images/amenities3.jpg';
import amenities4 from '../../images/amenities4.jpg';
import amenities5 from '../../images/amenities5.jpg';
import amenities6 from '../../images/amenities6.jpg';

const isImageVisible = ref(false);
const isTextVisible = ref(false);
const imageContainer = ref<HTMLElement | null>(null);
const textContainer = ref<HTMLElement | null>(null);

// Image Preview State
const showPreview = ref(false);
const previewImage = ref('');
const previewTitle = ref('');
const previewWidth = ref(0);
const previewHeight = ref(0);

interface Amenity {
    image: string;
    title: string;
    width: number;
    height: number;
}

// Amenity Data
const amenities = ref<Amenity[]>([
    { image: amenities1, title: 'Hotel Lobby', width: 1920, height: 979 },
    { image: amenities2, title: 'Indoor Pool', width: 1920, height: 973 },
    { image: amenities3, title: 'Gym', width: 1920, height: 973 },
    { image: amenities4, title: 'Function Room', width: 1920, height: 979 },
    { image: amenities5, title: 'Roof Deck Bar', width: 1920, height: 985 },
    { image: amenities6, title: 'Roof Deck Pool', width: 1920, height: 967 },
]);

// Open Image Preview
const openPreview = (amenity: Amenity) => {
    previewImage.value = amenity.image;
    previewTitle.value = amenity.title;
    previewWidth.value = amenity.width;
    previewHeight.value = amenity.height;
    showPreview.value = true;
    document.body.style.overflow = 'hidden';
};

// Close Image Preview
const closePreview = () => {
    showPreview.value = false;
    document.body.style.overflow = '';
};

// Close Modal on ESC Key
const handleKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Escape') {
        closePreview();
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);

    // Intersection Observer for smooth fade-in when scrolling
    const observer = new IntersectionObserver((entries) => {
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
    }, { threshold: 0.3 });

    if (imageContainer.value) observer.observe(imageContainer.value);
    if (textContainer.value) observer.observe(textContainer.value);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.body.style.overflow = '';
});
</script>

<style scoped>
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
