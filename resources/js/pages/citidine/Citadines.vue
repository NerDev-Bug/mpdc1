<template>
  <AppLayout>
    <div class="flex flex-col min-h-screen bg-white">
      <!-- Hero Section with Responsive Background Image -->
      <main class="relative bg-white">
        <div 
          class="w-full h-[50vh] sm:h-[65vh] md:h-[75vh] lg:h-[90vh] xl:h-screen bg-cover bg-center relative"
          :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
        >
          <div class="absolute inset-0 bg-black bg-opacity-20"></div>

          <!-- Logo with Smooth Fade & Slide-up Effect -->
          <transition name="fade-slide">
            <div 
              v-if="showLogo"
              class="absolute top-[16%] sm:top-[15%] md:top-[18%] lg:top-[20%] left-[5vw] sm:left-[7vw] md:left-[10vw] lg:left-[12vw]"
            >
              <img 
                src="../../images/logo1.png" 
                alt="Logo" 
                class="h-28 sm:h-32 md:h-36 lg:h-40 xl:h-48 w-auto"
              />
            </div>
          </transition>
        </div>


        <!-- Citadines Section -->  
        <Citadines1 />
      </main>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import heroImage from '../../images/ame4.jpg';
import AppLayout from '@/layouts/AppLayout.vue';
import Citadines1 from './Citadines1.vue';

const showLogo = ref(false);

onMounted(() => {
  setTimeout(() => {
    showLogo.value = true;
  }, 300); // Delays the animation slightly for a smooth effect
});
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}

/* Smooth Fade-In & Slide-Up Effect */
.fade-slide-enter-active {
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}
.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(20px);
}
</style>
