<template>
  <div class="flex flex-col min-h-screen bg-white">
    <Navbar />

    <!-- Hero Section with Responsive Background Image -->
    <main class="relative bg-white">
      <div 
        class="w-full h-[60vh] sm:h-[70vh] md:h-screen bg-cover bg-center relative"
        :style="{ backgroundImage: `url(${heroImage})` }"
      >
        <!-- Responsive Positioned Text -->
        <div class="absolute top-1/4 md:top-[30%] right-4 sm:right-8 md:right-16 lg:right-32 text-white text-right font-cormorant px-4 sm:px-6">
          <h2 class="text-4xl sm:text-[3.5rem] md:text-[4rem] lg:text-[4.5rem] font-bold leading-tight">
  Purposeful Living <br /> Redefined
</h2>

        </div>
      </div>

      <!-- Imported White Section -->
      <Banner />

      <!-- Latest News & Updates Section -->
      <News />
      
    </main>

    <Footer />
  </div>
</template>

<script setup>
import heroImage from '../pages/images/ame1.jpg';
import Navbar from '../pages/components/Navbar.vue';
import Footer from '../pages/components/Footer.vue';
import Banner from '../pages/Banner.vue';
import News from '../pages/News.vue';
</script>

<style>
/* Add Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}
</style>
