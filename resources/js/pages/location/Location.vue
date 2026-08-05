<template>
    <AppLayout>
      <SeoHead
        title="The Cerise Tower Location in Southwoods City"
        description="View the location of Citadines Southwoods Biñan at The Cerise Tower, near techno-industrial parks and approximately 10 kilometers from Alabang."
        canonical-path="/location"
        :image="heroImage"
        image-alt="The Cerise Tower location in Southwoods City, Biñan"
        :structured-data="{
          '@type': 'WebPage',
          name: 'The Cerise Tower Location in Southwoods City',
        }"
      />
      <div class="flex flex-col min-h-screen bg-white">
        <!-- Hero Section with Responsive Background Image -->
        <main class="relative bg-white">
            <div class="w-full h-[40vh] sm:h-[100vh] md:h-[65vh] lg:h-[80vh] xl:h-[90vh] bg-cover bg-center relative"
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
  import SeoHead from '@/components/SeoHead.vue';
  import AppLayout from '@/layouts/AppLayout.vue';
  import Location1 from '../location/Location1.vue';
  import UnitsAmenities1 from './UnitsAmenities1.vue';
  </script>

  <style>
  /* Add Custom Font */
  .font-cormorant {
    font-family: 'Cormorant Garamond', serif;
  }
  </style>
