<template>
    <AppLayout>
      <div class="flex flex-col min-h-screen bg-white">
        <!-- Hero Section with Responsive Background Image -->
        <main class="relative bg-white">
            <div class="w-full h-[40vh] sm:h-[55vh] md:h-[65vh] lg:h-[80vh] xl:h-[90vh] bg-cover bg-center relative"
    :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">

            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
          </div>
          <Location1/>
          <UnitsAmenities1/>
        </main>
      </div>
    </AppLayout>
  </template>

  <script setup lang="ts">
  import heroImage from '../../images/amey2.jpg';
  import AppLayout from '@/layouts/AppLayout.vue';
  import Location1 from '../location/Location1.vue';
  import UnitsAmenities1 from './UnitsAmenities1.vue';
  </script>

  <style>
  /* Add Custom Font */
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

  .font-cormorant {
    font-family: 'Cormorant Garamond', serif;
  }
  </style>
