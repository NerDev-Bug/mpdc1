<template>
  <div class="bg-white text-white py-12 px-4 sm:px-8 md:px-32">
    <div class="max-w-screen-4xl mx-auto w-[85%]">

      <!-- News Container -->
      <div class="relative w-full overflow-hidden">
        <div class="relative group">

          <transition name="fade" mode="out-in">
            <img :key="currentIndex" :src="images[currentIndex].src"
              class="w-full h-full object-contain transition-transform duration-500" />
          </transition>

          <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[40%]">
            <div class="transition-all duration-[3000ms]" :style="{ width: progressBarWidth }"></div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>


<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

// ✅ Import images properly
import temu1 from '../images/temu1.jpg';
import temu2 from '../images/temu2.jpg';
import temu3 from '../images/temu3.jpg';

// Array of images with correct paths and proper types
interface Image {
  src: string;
}

const images = ref<Image[]>([
  {
    src: temu1,
  },
  {
    src: temu2,
  },
  {
    src: temu3,
  }
]);

const currentIndex = ref<number>(0);
const progressBarWidth = ref<string>('0%');
let autoSlideInterval: NodeJS.Timeout;
const isTextVisible = ref<boolean>(false);
const isTitleVisible = ref<boolean>(false);
const textContainer = ref<HTMLElement | null>(null);
const titleContainer = ref<HTMLElement | null>(null);

// Function to navigate to the next image
const nextImage = (): void => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length;
  resetProgress();
};

// Auto-slide every 3 seconds
const startAutoSlide = (): void => {
  autoSlideInterval = setInterval(() => {
    nextImage();
  }, 9000);
};

// Reset progress bar
const resetProgress = (): void => {
  progressBarWidth.value = '0%';
  setTimeout(() => {
    progressBarWidth.value = '100%';
  }, 50);
};

// Scroll-based fade-in effects for text & title
const handleIntersection = (entries: IntersectionObserverEntry[]): void => {
  entries.forEach((entry) => {
    if (entry.target === textContainer.value && entry.isIntersecting) {
      isTextVisible.value = true;
    }
    if (entry.target === titleContainer.value && entry.isIntersecting) {
      isTitleVisible.value = true;
    }
  });
};

onMounted(() => {
  startAutoSlide();
  resetProgress();

  const observer = new IntersectionObserver(handleIntersection, { threshold: 0.3 });
  if (textContainer.value) observer.observe(textContainer.value);
  if (titleContainer.value) observer.observe(titleContainer.value);
});

onUnmounted(() => {
  clearInterval(autoSlideInterval);
});
</script>


<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
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

/* Title Scroll Animation (Slide Down + Fade-in) */
.fade-down {
  opacity: 1;
  transform: translateY(0);
}
</style>
