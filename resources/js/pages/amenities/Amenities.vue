<template>
  <AppLayout>
    <div class="flex flex-col min-h-screen bg-white">
      <!-- Hero Section with Responsive Background Image -->
      <main class="relative bg-white">
        <div
          class="w-full h-[50vh] sm:h-[65vh] md:h-[75vh] lg:h-[90vh] xl:h-screen bg-cover bg-center relative flex items-center justify-center"
          :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
        >
          <div class="absolute inset-0 bg-black bg-opacity-20"></div>

          <!-- Overlay Container for Images with Slide-Up Animation -->
          <div class="absolute inset-0 flex flex-col md:flex-row items-center justify-center gap-6 md:gap-0">
            <transition name="fade-slide-up">
              <img
                v-if="showImages"
                src="../../images/logo1.png"
                alt="Overlay Image 1"
                class="w-40 sm:w-52 md:w-64 lg:w-72 xl:w-80
                       md:absolute md:left-[25%] md:top-[35%]"
              />
            </transition>

            <transition name="fade-slide-up">
              <img
                v-if="showImages"
                src="../../images/logo2.png"
                alt="Overlay Image 2"
                class="w-40 sm:w-52 md:w-64 lg:w-72 xl:w-80
                       md:absolute md:right-[25%] md:top-[35%]"
              />
            </transition>
          </div>
        </div>
        <SlotsAmenities />

        <UnitsAmenities />
      </main>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import heroImage from '../../images/ame5.jpg';
import AppLayout from '@/layouts/AppLayout.vue';
import SlotsAmenities from './SlotsAmenities.vue';
import UnitsAmenities from './UnitsAmenities.vue';

const showImages = ref<boolean>(false);

onMounted(() => {
  setTimeout(() => {
    showImages.value = true;
  }, 300); // Slight delay for a smooth effect
});
</script>


<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}

/* Smooth Fade-In & Slide-Up Effect */
.fade-slide-up-enter-active {
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}
.fade-slide-up-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

/* Center stacked images on small screens */
@media (max-width: 768px) {
  .absolute img {
    position: static !important;
  }
}
</style>
