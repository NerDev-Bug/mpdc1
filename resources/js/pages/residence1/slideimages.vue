<template>
    <div class="w-full h-fit text-white py-12 px-4 md:px-12"
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
                    class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-500 transform group-hover:scale-105" />
                </template>
              </transition>
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-40"></div>

            <!-- Text Content (Only for images) -->
            <div v-if="filteredSlides[currentIndex].type === 'image'" ref="textContainer" class="absolute top-[50%] left-[10%] text-white font-montserrat px-4 sm:px-6 max-w-[80%] sm:max-w-[60%] opacity-0 transform translate-y-10 transition-all duration-700 ease-out"
              :class="{ 'fade-in': isTextVisible }">
              <h3 class="text-2xl sm:text-3xl md:text-5xl font-bold leading-tight">
                {{ filteredSlides[currentIndex].title }}
              </h3>
              <p class="mt-3 text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
                {{ filteredSlides[currentIndex].description }}
              </p>
            </div>

            <!-- Progress Bar (Only for images) -->
            <div v-if="filteredSlides[currentIndex].type === 'image'" class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[40%]">
              <div class="h-[4px] bg-opacity-50">
                <div class="h-full transition-all duration-[3000ms]" :style="{ width: progressBarWidth }">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-10">
          <SRForm />
        </div>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted, onUnmounted, defineProps, computed } from 'vue';
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
    alt?: string;
    title?: string;
    description?: string;
  }

  // Define the selected unit passed from the parent component
  const props = defineProps({
    selectedButton: String
  });

  const slides = ref<Slide[]>([
    // Studio Unit Slides
    { type: 'image', src: SR1, alt: '', title: 'Studio Unit', description: 'Serviced Residences' },
    { type: 'image', src: SR2, alt: '', title: 'Studio Unit', description: 'Serviced Residences' },
    { type: 'image', src: SR3, alt: '', title: 'Studio Unit', description: 'Serviced Residences' },

    // 1-Bedroom Unit Slides
    { type: 'image', src: SR1B, alt: '', title: '1-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR2B, alt: '', title: '1-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR3B, alt: '', title: '1-Bedroom', description: 'Serviced Residences' },

    // 2-Bedroom Unit Slides
    { type: 'image', src: SR1D, alt: '', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR2D, alt: '', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR3D, alt: '', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR4D, alt: '', title: '2-Bedroom', description: 'Serviced Residences' },
    { type: 'image', src: SR5D, alt: '', title: '2-Bedroom', description: 'Serviced Residences' },
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
        return [];
    }
  });

  const currentIndex = ref<number>(0);
  const progressBarWidth = ref<string>('0%');
  let autoSlideInterval: NodeJS.Timeout;
  const isTextVisible = ref<boolean>(false);
  const textContainer = ref<HTMLElement | null>(null);

  // Show next slide
  const nextImage = (): void => {
    currentIndex.value = (currentIndex.value + 1) % filteredSlides.value.length;
    resetProgress();
  };

  // Auto-slide only images
  const startAutoSlide = (): void => {
    autoSlideInterval = setInterval(() => {
      if (filteredSlides.value[currentIndex.value].type === 'image') {
        nextImage();
      }
    }, 4000);
  };

  // Reset progress bar for images only
  const resetProgress = (): void => {
    if (filteredSlides.value[currentIndex.value].type === 'image') {
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
    startAutoSlide();
    resetProgress();

    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.6 });
    if (textContainer.value) observer.observe(textContainer.value);
  });

  onUnmounted(() => {
    clearInterval(autoSlideInterval);
  });
  </script>

  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

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
