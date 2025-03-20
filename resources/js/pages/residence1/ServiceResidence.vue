<template>
  <AppLayout>
    <div class="flex flex-col min-h-screen bg-white">
      <!-- Hero Section with Responsive Background Image -->
      <div class="relative bg-white">
        <div
          class="w-full h-[50vh] sm:h-[65vh] md:h-[75vh] lg:h-[90vh] xl:h-screen bg-cover bg-center relative flex items-center justify-center"
          :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">

          <!-- Buttons Section with Fade Transition -->
          <transition name="fade-buttons" appear>
            <div class="absolute bottom-16 md:bottom-24 left-1/2 transform -translate-x-1/2
    flex flex-wrap justify-center gap-4 w-full px-4 min-[648px]:flex-row flex-col items-center">

              <button
                v-for="unit in unitOptions"
                :key="unit.name"
                @click="selectedButton = unit.name"
                class="text-white text-sm min-[492px]:text-base md:text-lg lg:text-xl
                px-8 min-[492px]:px-10 md:px-12 lg:px-16
                py-3 min-[492px]:py-4 md:py-5 lg:py-6
                rounded-full shadow-xl transition-all duration-300
                w-[80%] min-[648px]:w-auto max-w-[300px] md:max-w-[350px] lg:max-w-[400px]"
                :class="{
                  'bg-green-800 shadow-2xl scale-105': selectedButton === unit.name,
                  'bg-green-500 hover:shadow-2xl hover:scale-105 hover:bg-green-800': selectedButton !== unit.name
                }">
                {{ unit.name }}
              </button>
            </div>
          </transition>

          <!-- Overlay Section -->
          <div class="absolute left-0 right-0 top-[20%] bottom-[45%] bg-black bg-opacity-60 hidden min-[648px]:block">
          </div>

          <!-- Logo Images -->
          <div class="absolute top-[35%] md:top-[30%] left-1/2 transform -translate-x-1/2
          flex-row flex-wrap items-center justify-center gap-4 sm:gap-6
         md:gap-x-16 lg:gap-x-28 xl:gap-x-36 md:w-[90%] mx-auto hidden min-[648px]:flex">

            <transition name="fade-slide-up" appear>
              <img v-if="showImages" src="../../images/logo1.png" alt="Overlay Image 1"
                class="w-[50%] sm:w-[45%] md:w-[40%] lg:w-[35%] xl:w-[30%] max-w-[300px] md:max-w-[400px]" />
            </transition>

            <transition name="fade-slide-up" appear>
              <img v-if="showImages" src="../../images/logo2.png" alt="Overlay Image 2"
                class="w-[50%] sm:w-[45%] md:w-[40%] lg:w-[35%] xl:w-[30%] max-w-[300px] md:max-w-[400px]" />
            </transition>
          </div>
        </div>
      </div>

      <!-- Service Residence Section -->
      <div class="mt-4 px-4 md:px-4">
        <ServiceResidence1 v-if="selectedButton === 'SR Studio Unit' || selectedButton === null" />
        <ServiceResidence2 v-if="selectedButton === 'SR 1 Bedroom Unit'" />
        <ServiceResidence3 v-if="selectedButton === 'SR 2 Bedroom Unit'" />
      </div>

      <SRimage />
      <slideimages />
      <div class="mt-4 px-4 md:px-4">
        <SRForm />
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import heroImage from '../../images/ame8.jpg';
import AppLayout from '@/layouts/AppLayout.vue';
import ServiceResidence1 from './ServiceResidence1.vue';
import SRimage from './srimage.vue';
import slideimages from './slideimages.vue';
import SRForm from './SRForm.vue';
import ServiceResidence2 from './ServiceResidence2.vue';
import ServiceResidence3 from './ServiceResidence3.vue';

const showImages = ref(false);
// const selectedButton = ref<string | null>(null);
const selectedButton = ref<string>('SR Studio Unit'); // Default selection

const unitOptions = [
  { name: "SR Studio Unit" },
  { name: "SR 1 Bedroom Unit" },
  { name: "SR 2 Bedroom Unit" }
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
  /* Adjust delay as needed */
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
