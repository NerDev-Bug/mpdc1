<template>
    <section class="text-white py-12 px-4 md:px-12" aria-label="Private residence interior gallery"
      :style="{ backgroundImage: `url(${SRbg})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
      <div class="max-w-screen-4xl mx-auto w-[95%]">

        <!-- News Container -->
        <div class="relative w-full overflow-hidden">
          <div class="relative group">
            <!-- Responsive Wrapper with Aspect Ratio -->
            <div class="relative aspect-[16/9] sm:aspect-[16/9] md:aspect-[21/9] lg:aspect-[21/9] w-full overflow-hidden">
              <!-- Image or Video Display -->
              <transition name="fade" mode="out-in">
                <template v-if="currentImage">
                    <img :key="currentIndex" :src="currentImage.src" :alt="currentImage.alt" width="1920"
                    height="1080" loading="lazy" decoding="async"
                    class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-500 transform group-hover:scale-105" />
                </template>
              </transition>
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-40"></div>

            <!-- Transition for News Content (Fade-in + Slide-up) -->
            <div ref="textContainer" aria-live="polite" class="absolute top-[50%] left-[10%] text-white font-montserrat px-4 sm:px-6 max-w-[80%] sm:max-w-[60%]
              opacity-0 transform translate-y-10 transition-all duration-700 ease-out"
              :class="{ 'fade-in': isTextVisible }">
              <h3 class="text-2xl sm:text-3xl md:text-5xl font-bold leading-tight">
                {{ currentImage.title }}
              </h3>
              <p class="mt-3 text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
                {{ currentImage.description }}
              </p>
            </div>

            <button type="button" aria-label="Show previous private residence image"
              class="absolute left-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/60 px-4 py-3 text-2xl hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
              @click="previousImage">
              <span aria-hidden="true">‹</span>
            </button>
            <button type="button" aria-label="Show next private residence image"
              class="absolute right-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/60 px-4 py-3 text-2xl hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
              @click="nextImage">
              <span aria-hidden="true">›</span>
            </button>
            <button type="button" :aria-label="isPaused ? 'Play private residence gallery' : 'Pause private residence gallery'"
              class="absolute right-3 top-3 z-10 rounded bg-black/60 px-3 py-2 text-sm hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
              @click="toggleAutoplay">
              {{ isPaused ? 'Play' : 'Pause' }}
            </button>

            <!-- Auto-Play Progress Bar -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[40%]">
              <div class="transition-all"
                :style="{ width: progressBarWidth, transitionDuration: '3000ms' }"></div>
            </div>

          </div>
        </div>

      </div>
      <div class="mt-12">
        <PRForm />
      </div>
    </section>
  </template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import SRbg from '../../images/SR-bg.png';

// ✅ Import images properly
import PR1 from '../../images/PRst (1).jpg';
import PR2 from '../../images/PRst (2).jpg';
import PR3 from '../../images/PRst (3).jpg';
import PR4 from '../../images/PRst (4).jpg';
import PR5 from '../../images/PRst (5).jpg';
import PR6 from '../../images/PRst (6).jpg';
import PR1B from '../../images/PR1b (1).jpg';
import PR2B from '../../images/PR1b (2).jpg';
import PR3B from '../../images/PR1b (3).jpg';
import PR4B from '../../images/PR1b (4).jpg';
import PR5B from '../../images/PR1b (5).jpg';
import PR6B from '../../images/PR1b (6).jpg';
import PR7B from '../../images/PR1b (7).jpg';
import PR8B from '../../images/PR1b (8).jpg';
import PR9B from '../../images/PR1b (9).jpg';
import PR10B from '../../images/PR1b (10).jpg';
import PR1D from '../../images/PR2d (1).jpg';
import PR2D from '../../images/PR2d (2).jpg';
import PR3D from '../../images/PR2d (3).jpg';
import PR4D from '../../images/PR2d (4).jpg';
import PR5D from '../../images/PR2d (5).jpg';
import PR6D from '../../images/PR2d (6).jpg';
import PR7D from '../../images/PR2d (7).jpg';
import PR8D from '../../images/PR2d (8).jpg';
import PRForm from './PRForm.vue';

// Define prop for selectedButton from parent
const props = defineProps({
  selectedButton: String,
});

// Array of images with correct paths and proper types
interface Image {
  src: string;
  alt: string;
  title: string;
  description: string;
}

const createImages = (sources: string[], title: string): Image[] => sources.map((src, index) => ({
  src,
  alt: `Private residence ${title.toLowerCase()} interior, view ${index + 1}`,
  title,
  description: 'Private Residences',
}));

const allImages = ref<Image[]>([
  ...createImages([PR1, PR2, PR3, PR4, PR5, PR6], 'Studio Unit'),
  ...createImages([PR1B, PR2B, PR3B, PR4B, PR5B, PR6B, PR7B, PR8B, PR9B, PR10B], '1-Bedroom'),
  ...createImages([PR1D, PR2D, PR3D, PR4D, PR5D, PR6D, PR7D, PR8D], '2-Bedroom'),
]);

// Filter images based on selectedButton
const filteredImages = computed(() => {
  switch (props.selectedButton) {
    case 'PR Studio Unit':
      return allImages.value.slice(0, 6); // First 6 images are for Studio
    case 'PR 1 Bedroom Unit':
      return allImages.value.slice(6, 16); // 1-Bedroom images
    case 'PR 2 Bedroom Unit':
      return allImages.value.slice(16, 24); // 2-Bedroom images
    default:
      return allImages.value.slice(0, 6);
  }
});

const currentIndex = ref<number>(0);
const currentImage = computed(() => filteredImages.value[currentIndex.value] ?? allImages.value[0]);
const progressBarWidth = ref<string>('0%');
const isPaused = ref<boolean>(false);
let autoSlideInterval: ReturnType<typeof setInterval> | undefined;
const isTextVisible = ref<boolean>(false);
const textContainer = ref<HTMLElement | null>(null);

// Function to navigate to the next image
const nextImage = (): void => {
  if (!filteredImages.value.length) return;
  currentIndex.value = (currentIndex.value + 1) % filteredImages.value.length;
  resetProgress();
};

const previousImage = (): void => {
  if (!filteredImages.value.length) return;
  currentIndex.value = (currentIndex.value - 1 + filteredImages.value.length) % filteredImages.value.length;
  resetProgress();
};

// Auto-slide every 3 seconds
const startAutoSlide = (): void => {
  if (autoSlideInterval) clearInterval(autoSlideInterval);
  if (isPaused.value || filteredImages.value.length < 2) return;

  autoSlideInterval = setInterval(() => {
    nextImage();
  }, 4000);
};

const toggleAutoplay = (): void => {
  isPaused.value = !isPaused.value;
  startAutoSlide();
};

// Reset progress bar
const resetProgress = (): void => {
  progressBarWidth.value = '0%';
  setTimeout(() => {
    progressBarWidth.value = '100%';
  }, 50);
};

// Scroll-based fade-in effects for text
const handleIntersection = (entries: IntersectionObserverEntry[]): void => {
  entries.forEach((entry) => {
    if (entry.target === textContainer.value && entry.isIntersecting) {
      isTextVisible.value = true;
    }
  });
};

onMounted(() => {
  isPaused.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  startAutoSlide();
  resetProgress();

  const observer = new IntersectionObserver(handleIntersection, { threshold: 0.6 });
  if (textContainer.value) observer.observe(textContainer.value);
});

onUnmounted(() => {
  if (autoSlideInterval) clearInterval(autoSlideInterval);
});

watch(() => props.selectedButton, () => {
  currentIndex.value = 0;
  resetProgress();
  startAutoSlide();
});
</script>

  <style scoped>
  .font-montserrat {
    font-family: 'Montserrat', sans-serif;
  }

  /* Smooth Fade-in Effect */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.8s ease-in-out;
  }

  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }

  /* Scroll-based Text Animation */
  .opacity-0 {
    opacity: 0;
    transform: translateY(20px);
  }

  .fade-in {
    opacity: 1;
    transform: translateY(0);
  }

  img {
    object-position: center center;
  }

  div.absolute.inset-0.bg-black.opacity-40 {
    height: 100%;
    width: 100%;
  }
  </style>
