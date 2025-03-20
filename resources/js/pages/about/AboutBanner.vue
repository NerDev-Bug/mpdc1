<template>
  <div class="relative w-full bg-[#D9D9D9] py-12 px-6 md:px-16">
    <!-- Title -->
    <h2 class="text-gray-700 text-3xl sm:text-4xl md:text-5xl font-bold font-cormorant mb-6 text-left">
      Our partners
    </h2>
<!-- Partner Logos -->
<div class="flex flex-col items-center space-y-6">
  <div class="flex flex-wrap justify-center items-center gap-20">
    <img src="../../images/logos5.png" alt="Ascott Limited" class="w-64 h-85 object-contain">
    <img src="../../images/logo.png" alt="MPDC" class="w-64 h-32 object-contain">
  </div>
</div>


    <!-- Two-Column Content (Tightly Packed) -->
    <div class="grid grid-cols-1 md:grid-cols-2 mt-6">
      <!-- Left: Text Section (No Gap) -->
      <div class="bg-[#1E3A5F] text-white p-4 md:p-6 flex items-center">
        <p class="text-xl md:text-xl leading-tight">
          MPDC aims to partner with world-class operators and respected partnership with
          The Ascott Limited is proof of our commitment to provide excellent service.
        </p>
      </div>

      <!-- Right: Image Section (No Gap) -->
      <div class="w-full">
        <img src="../../images/mate1.jpg" class="w-full object-cover h-full">
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}
</style>
