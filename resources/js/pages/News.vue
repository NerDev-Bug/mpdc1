<template>
    <div class="bg-gray-900 text-white py-12 px-8 md:px-32">
      <div class="max-w-screen-xl mx-auto">
        <!-- Section Title -->
        <h2 class="text-[2.75rem] md:text-[3.25rem] font-cormorant font-semibold mb-8">
  Latest News & Updates
</h2>

        <!-- News Container -->
        <div class="relative w-full">
          <div class="relative">
            <!-- Background Image -->
            <img 
              src="../pages/images/ame2.jpg" 
              alt="News" 
              class="w-full h-auto md:h-[500px] object-cover rounded-lg"
            />
  
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-50 rounded-lg"></div>
  
            <!-- News Content -->
            <div class="absolute top-1/4 left-6 sm:left-12 md:left-20 lg:left-40 text-white font-cormorant px-6">
              <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                The Cerise Tower Topping Off Celebration
              </h3>
              <p class="mt-4 text-lg md:text-xl leading-relaxed">
                Build 500 affordable residential units within 5 years. Develop a residential area 
                just off the city center. Tailor the project to the needs of professionals and young families.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  </script>
  
  <style scoped>
  /* Add Custom Font */
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');
  
  .font-cormorant {
    font-family: 'Cormorant Garamond', serif;
  }
  </style>
  