<template>
    <section class="w-full h-fit text-white py-12 px-4 md:px-12" aria-label="Serviced residence interior gallery"
      :style="{ backgroundImage: `url(${SRbg})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
      <div class="max-w-screen-4xl mx-auto w-[95%]">
        <!-- News Container -->
        <div class="relative w-full overflow-hidden">
          <div class="relative group">
            <!-- Responsive Wrapper with Aspect Ratio -->
            <div class="relative aspect-[16/9] sm:aspect-[16/9] md:aspect-[21/9] lg:aspect-[21/9] w-full overflow-hidden">
              <!-- Image or Video Display -->
              <transition name="fade" mode="out-in">
                <template v-if="filteredSlides[currentIndex].type === 'image'">
                  <img :key="currentIndex" :src="filteredSlides[currentIndex].src" :alt="filteredSlides[currentIndex].alt"
                    width="1161" height="653" loading="lazy" decoding="async"
                    class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-500 transform group-hover:scale-105" />
                </template>
              </transition>
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-40"></div>

            <!-- Text Content (Only for images) -->
            <div v-if="filteredSlides[currentIndex].type === 'image'" ref="textContainer" aria-live="polite" class="absolute top-[50%] left-[10%] text-white font-montserrat px-4 sm:px-6 max-w-[80%] sm:max-w-[60%] opacity-0 transform translate-y-10 transition-all duration-700 ease-out"
              :class="{ 'fade-in': isTextVisible }">
              <h3 class="text-2xl sm:text-3xl md:text-5xl font-bold leading-tight">
                {{ filteredSlides[currentIndex].title }}
              </h3>
              <p class="mt-3 text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
                {{ filteredSlides[currentIndex].description }}
              </p>
            </div>

            <button type="button" aria-label="Show previous serviced residence image"
              class="absolute left-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/60 px-4 py-3 text-2xl hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
              @click="previousImage">
              <span aria-hidden="true">‹</span>
            </button>
            <button type="button" aria-label="Show next serviced residence image"
              class="absolute right-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/60 px-4 py-3 text-2xl hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
              @click="nextImage">
              <span aria-hidden="true">›</span>
            </button>
            <button type="button" :aria-label="isPaused ? 'Play serviced residence gallery' : 'Pause serviced residence gallery'"
              class="absolute right-3 top-3 z-10 rounded bg-black/60 px-3 py-2 text-sm hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-white"
              @click="toggleAutoplay">
              {{ isPaused ? 'Play' : 'Pause' }}
            </button>

            <!-- Progress Bar (Only for images) -->
            <div v-if="filteredSlides[currentIndex].type === 'image'" class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[40%]">
              <div class="h-[4px] bg-opacity-50">
                <div class="h-full transition-all"
                  :style="{ width: progressBarWidth, transitionDuration: '3000ms' }">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-10">
          <SRForm />
        </div>
      </div>
    </section>
  </template>

  <script setup lang="ts">
  import { ref, onMounted, onUnmounted, defineProps, computed, watch } from 'vue';
  import SRForm from './SRForm.vue';
  import SRbg from '../../images/SR-bg.png';

  // Images for each unit type
  import SR1 from '../../images/SRst (1).jpg';
  import SR2 from '../../images/SRst (2).jpg';
  import SR3 from '../../images/SRst (3).jpg';
  import SR1B from '../../images/SR1b (1).jpg';
  import SR2B from '../../images/SR1b (2).jpg';
  import SR3B from '../../images/SR1b (3).jpg';
  import SR1D from '../../images/SR2d (1).jpg';
  import SR2D from '../../images/SR2d (2).jpg';
  import SR3D from '../../images/SR2d (3).jpg';
  import SR4D from '../../images/SR2d (4).jpg';
  import SR5D from '../../images/SR2d (5).jpg';

  // Interface for slide data
  interface Slide {
    type: 'image';
    src: string;
    alt: string;
    title: string;
    description: string;
  }

  // Define the selected unit passed from the parent component
  const props = defineProps({
    selectedButton: String
  });

  const slides = ref<Slide[]>([
    // Studio Unit Slides
    { type: 'image', src: SR1, alt: 'Serviced residence studio unit interior, view 1', title: 'Studio Unit', description: 'Serviced Residences' },
    { type: 'image', src: SR2, alt: 'Serviced residence studio unit interior, view 2', title: 'Studio Unit', description: 'Serviced Residences' },
    { type: 'image', src: SR3, alt: 'Serviced residence studio unit interior, view 3', title: 'Studio Unit', description: 'Serviced Residences' },

    // 1-Bedroom Unit Slides
    { type: 'image', src: SR1B, alt: 'Serviced residence one-bedroom unit interior, view 1', title: '1-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR2B, alt: 'Serviced residence one-bedroom unit interior, view 2', title: '1-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR3B, alt: 'Serviced residence one-bedroom unit interior, view 3', title: '1-Bedroom', description: 'Serviced Residences' },

    // 2-Bedroom Unit Slides
    { type: 'image', src: SR1D, alt: 'Serviced residence two-bedroom unit interior, view 1', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR2D, alt: 'Serviced residence two-bedroom unit interior, view 2', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR3D, alt: 'Serviced residence two-bedroom unit interior, view 3', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR4D, alt: 'Serviced residence two-bedroom unit interior, view 4', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR5D, alt: 'Serviced residence two-bedroom unit interior, view 5', title: '2-Bedroom', description: 'Serviced Residences' },
  ]);

  // Filter slides based on the selected unit type
  const filteredSlides = computed(() => {
    switch (props.selectedButton) {
      case 'SR Studio Unit':
        return slides.value.slice(0, 3); // Studio Unit
      case 'SR 1 Bedroom Unit':
        return slides.value.slice(3, 6); // 1-Bedroom Unit
      case 'SR 2 Bedroom Unit':
        return slides.value.slice(6, 11); // 2-Bedroom Unit
      default:
        return slides.value.slice(0, 3);
    }
  });

  const currentIndex = ref<number>(0);
  const progressBarWidth = ref<string>('0%');
  const isPaused = ref<boolean>(false);
  let autoSlideInterval: ReturnType<typeof setInterval> | undefined;
  const isTextVisible = ref<boolean>(false);
  const textContainer = ref<HTMLElement | null>(null);

  // Show next slide
  const nextImage = (): void => {
    if (!filteredSlides.value.length) return;
    currentIndex.value = (currentIndex.value + 1) % filteredSlides.value.length;
    resetProgress();
  };

  const previousImage = (): void => {
    if (!filteredSlides.value.length) return;
    currentIndex.value = (currentIndex.value - 1 + filteredSlides.value.length) % filteredSlides.value.length;
    resetProgress();
  };

  // Auto-slide only images
  const startAutoSlide = (): void => {
    if (autoSlideInterval) clearInterval(autoSlideInterval);
    if (isPaused.value || filteredSlides.value.length < 2) return;

    autoSlideInterval = setInterval(() => {
      if (filteredSlides.value[currentIndex.value]?.type === 'image') {
        nextImage();
      }
    }, 4000);
  };

  const toggleAutoplay = (): void => {
    isPaused.value = !isPaused.value;
    startAutoSlide();
  };

  // Reset progress bar for images only
  const resetProgress = (): void => {
    if (filteredSlides.value[currentIndex.value]?.type === 'image') {
      progressBarWidth.value = '0%';
      setTimeout(() => {
        progressBarWidth.value = '100%';
      }, 50);
    } else {
      progressBarWidth.value = '0%';
    }
  };

  // Observer to trigger text animation
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

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.8s ease-in-out;
  }

  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }

  .opacity-0 {
    opacity: 0;
    transform: translateY(20px);
  }

  .fade-in {
    opacity: 1;
    transform: translateY(0);
  }
  </style>
