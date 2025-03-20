<template>
  <AppLayout>
    <div class="flex flex-col min-h-screen bg-white">
      <!-- Hero Section -->
      <div class="relative bg-white">
        <div
          class="w-full h-[50vh] sm:h-[65vh] md:h-[75vh] lg:h-[90vh] xl:h-screen bg-cover bg-center relative flex flex-col md:flex-row items-center justify-center"
          :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">

          <!-- Center the heading both vertically and horizontally, with a slight upward shift on smaller screens -->
          <div class="absolute inset-0 flex items-center justify-center text-center font-cormorant w-full px-4 md:px-8"
            style="top: -20%;">
            <h2 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold leading-tight">
              Private <br>
              Residences
            </h2>
          </div>

          <!-- Buttons Section -->
          <transition name="fade-buttons" appear>
            <div
              class="absolute bottom-12 md:bottom-20 left-1/2 transform -translate-x-1/2 flex flex-wrap justify-center gap-4 w-full px-4 min-[648px]:flex-row flex-col items-center">
              <button v-for="unit in unitOptions" :key="unit.name" @click="selectedButton = unit.name"
                class="text-white text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl
                       px-6 sm:px-8 md:px-10 lg:px-12 xl:px-16 py-2 sm:py-3 md:py-4 lg:py-5 xl:py-6
                       rounded-full shadow-xl transition-all duration-300
                       w-[90%] sm:w-[80%] md:w-auto max-w-[250px] sm:max-w-[280px] md:max-w-[300px] lg:max-w-[350px] xl:max-w-[400px]" :class="{
                        'bg-green-800 shadow-2xl scale-105': selectedButton === unit.name,
                        'bg-green-500 hover:shadow-2xl hover:scale-105 hover:bg-green-800': selectedButton !== unit.name
                      }">
                {{ unit.name }}
              </button>
            </div>
          </transition>

        </div>
      </div>

      <!-- Service Residence Section -->
      <div class="mt-8 px-4 md:px-6">
        <PrivateResidence1 v-if="selectedButton === 'PR Studio Unit' || selectedButton === null" />
        <PrivateResidence2 v-if="selectedButton === 'PR 1 Bedroom Unit'" />
        <PrivateResidence3 v-if="selectedButton === 'PR 2 Bedroom Unit'" />
      </div>

      <SRimage />
      <slideimages />

      <div class="mt-8 px-4 md:px-6">
        <PRForm />
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import heroImage from '../../images/ame8.jpg';
import AppLayout from '@/layouts/AppLayout.vue';
import PrivateResidence1 from './PrivateResidence1.vue';
import SRimage from './primage.vue';
import slideimages from './slideimages1.vue';
import PrivateResidence3 from './PrivateResidence3.vue';
import PRForm from '../residence1/SRForm.vue';
import PrivateResidence2 from './PrivateResidence2.vue';

const showImages = ref(false);
const selectedButton = ref<string | null>(null);

const unitOptions = [
  { name: "PR Studio Unit" },
  { name: "PR 1 Bedroom Unit" },
  { name: "PR 2 Bedroom Unit" }
];

onMounted(() => {
  setTimeout(() => {
    showImages.value = true;
  }, 300); // Slight delay for smooth transition
});
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}

/* Smooth Fade & Slide-Up Effect */
.fade-slide-up-enter-active,
.fade-slide-up-appear-active {
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.fade-slide-up-enter-from,
.fade-slide-up-appear-from {
  opacity: 0;
  transform: translateY(20px);
}

/* Fade-In Animation for Buttons */
.fade-buttons-enter-active,
.fade-buttons-appear-active {
  transition: opacity 1s ease-in-out;
  transition-delay: 0.4s;
}

.fade-buttons-enter-from,
.fade-buttons-appear-from {
  opacity: 0;
}

.fade-buttons-enter-to,
.fade-buttons-appear-to {
  opacity: 1;
}
</style>
