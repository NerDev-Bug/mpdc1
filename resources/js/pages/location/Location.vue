<template>
    <AppLayout>
      <div class="flex flex-col min-h-screen bg-white">
        <!-- Hero Section with Responsive Background Image -->
        <main class="relative bg-white">
          <div class="w-full h-[50vh] sm:h-[65vh] md:h-[75vh] lg:h-[90vh] xl:h-screen bg-cover bg-center relative"
            :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
          </div>
        </main>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import heroImage from '../../images/ame2.jpg';
  import AppLayout from '@/layouts/AppLayout.vue';
  </script>
  
  <style>
  /* Add Custom Font */
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');
  
  .font-cormorant {
    font-family: 'Cormorant Garamond', serif;
  }
  </style>
  