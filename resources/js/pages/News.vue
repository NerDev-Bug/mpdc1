<template>
  <div class="bg-gray-900 text-white py-12 px-4 sm:px-8 md:px-32">
    <div class="max-w-screen-4xl mx-auto w-[95%]">
      
      <!-- News Container -->
      <div class="relative w-full overflow-hidden">
        <div class="relative group"> 
          
          <!-- Transition for Image -->
          <transition name="fade" mode="out-in">
            <img 
              :key="currentIndex"
              :src="images[currentIndex].src" 
              :alt="images[currentIndex].alt"
              class="w-full h-[50vh] sm:h-[60vh] md:h-[75vh] lg:h-[80vh] object-cover
                    transition-transform duration-500 transform group-hover:scale-105"
            />
          </transition>

          <!-- Overlay -->
          <div class="absolute inset-0 bg-black opacity-50"></div>

          <!-- Title with Animation -->
          <h2 ref="titleContainer"
              class="absolute top-6 left-6 text-4xl sm:text-5xl md:text-6xl font-cormorant font-semibold text-white px-4 py-2 rounded-md
                    opacity-0 transform -translate-y-6 transition-all duration-700 ease-out"
              :class="{ 'fade-down': isTitleVisible }">
            Latest News & Updates
          </h2>

          <!-- Transition for News Content (Fade-in + Slide-up) -->
          <div
            ref="textContainer"
            class="absolute top-[50%] left-[10%] text-white font-cormorant px-4 sm:px-6 max-w-[80%] sm:max-w-[60%]
                   opacity-0 transform translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': isTextVisible }"
          >
            <h3 class="text-2xl sm:text-3xl md:text-5xl font-bold leading-tight">
              {{ images[currentIndex].title }}
            </h3>
            <p class="mt-3 text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
              {{ images[currentIndex].description }}
            </p>
          </div>

          <!-- Auto-Play Progress Bar -->
          <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[40%]">
            <div 
              class="transition-all duration-[3000ms]" 
              :style="{ width: progressBarWidth }"
            ></div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// ✅ Import images properly
import ame2 from '../images/ame2.jpg';
import ame1 from '../images/ame1.jpg';
import img1 from '../images/img1.png';

// Array of images with correct paths
const images = ref([
  {
    src: ame2,
    alt: 'Cerise Tower',
    title: 'The Cerise Tower Topping Off Celebration',
    description: 'Build 500 affordable residential units within 5 years. Develop a residential area just off the city center.'
  },
  {
    src: ame1,
    alt: 'Skyline Expansion',
    title: 'New Urban Development Announced',
    description: 'A new urban area with mixed-use residential and commercial spaces is set to launch this year.'
  },
  {
    src: img1,
    alt: 'Modern Architecture',
    title: 'Revolutionizing City Skylines',
    description: 'Architects unveil cutting-edge designs for sustainable high-rise buildings.'
  }
]);

const currentIndex = ref(0);
const progressBarWidth = ref('0%');
let autoSlideInterval;
const isTextVisible = ref(false);
const isTitleVisible = ref(false);
const textContainer = ref(null);
const titleContainer = ref(null);

// Function to navigate to the next image
const nextImage = () => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length;
  resetProgress();
};

// Auto-slide every 3 seconds
const startAutoSlide = () => {
  autoSlideInterval = setInterval(() => {
    nextImage();
  }, 3000);
};

// Reset progress bar
const resetProgress = () => {
  progressBarWidth.value = '0%';
  setTimeout(() => {
    progressBarWidth.value = '100%';
  }, 50);
};

// Scroll-based fade-in effects for text & title
const handleIntersection = (entries, observer) => {
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
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.8s ease-in-out;
}
.fade-enter, .fade-leave-to {
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
