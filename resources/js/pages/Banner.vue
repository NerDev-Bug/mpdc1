<template>
  <div class="bg-white py-12 px-8 md:px-32 flex justify-center relative">
    
    <div class="w-full max-w-screen-xl flex flex-col md:flex-row items-start">
      
      <!-- Image Container (Taller) -->
      <div class="w-full md:w-1/2 flex relative">
        <img 
          src="../pages/images/ame2.jpg" 
          alt="Community View" 
          class="w-full h-auto md:h-[850px] object-cover rounded-lg"
        />

        <!-- Semi-Transparent Overlay Box -->
        <div class="absolute inset-0 bg-black bg-opacity-20 rounded-lg"></div>
      </div>

      <!-- Outer Text Box Container (Shorter) -->
      <div class="w-full md:w-1/2 flex self-start relative">
        <div class="bg-gray-300 p-8 md:p-16 rounded-lg shadow-lg w-full md:min-h-[650px] flex flex-col justify-between">
          
          <!-- Title -->
          <h4 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-semibold font-cormorant text-blue-900 mb-6 md:mb-8">
            Who we are
          </h4>

          <!-- Text Content -->
          <div class="flex-grow">
            <p class="text-black text-lg md:text-xl leading-relaxed font-cormorant">
              Malveda Holdings Corporation (MHC), a conglomerate dedicated to enhancing the lives of Filipino farmers, has leveraged its diverse portfolio of agricultural companies to embark on a new business endeavor. Riding on the success of its subsidiary, <i>LEADS Agri</i>, MHC has expanded into the real estate sector. After nearly three decades in agribusiness, MHC founded <i>Malveda Properties and Development Corporation (MPDC)</i> in 2020.
            </p>
          </div>

        </div>
      </div>

    </div>

  </div>
</template>

<style>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

/* Apply Font */
.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}
</style>
