<template>
  <header class="fixed top-0 left-0 w-full bg-black bg-opacity-40 text-white p-4 z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center px-4 md:px-6">
      <!-- Logo (Responsive) -->
      <img 
        src="../images/logo.png" 
        alt="MPDC Logo" 
        class="h-10 sm:h-10 md:h-10 lg:h-12 w-auto min-w-[60px] sm:min-w-[80px] md:min-w-[100px]" 
      />

      <!-- Desktop Navigation (Hidden at 768px) -->
      <nav class="hidden lg:flex space-x-2 sm:space-x-4 lg:space-x-6 xl:space-x-8 text-sm sm:text-base md:text-lg antialiased">
        <ul class="flex space-x-2 sm:space-x-4 lg:space-x-6 xl:space-x-8">

          <li>
            <a href="#" class="relative block px-4 py-2 transition-all duration-300 whitespace-nowrap">
              About us
            </a>
          </li>

          <!-- Citadines Southwoods Dropdown -->
          <li class="relative group">
            <a href="#" class="relative block px-4 py-2 transition-all duration-300 text-center">
              Citadines <br class="hidden sm:block" /> Southwoods
              <span class="inline-block text-xs transform transition-transform group-hover:rotate-180">▾</span>
            </a>

            <!-- Full-Width Dropdown Menu -->
            <ul class="absolute left-0 top-full w-full bg-black bg-opacity-40 shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 mt-4">
              <li><a href="#" class="block px-6 py-3 text-white text-xs sm:text-sm">Location</a></li>
              <li><a href="#" class="block px-6 py-3 text-white text-xs sm:text-sm">Amenities</a></li>
              <li><a href="#" class="block px-6 py-3 text-white text-xs sm:text-sm">Serviced Residences</a></li>
              <li><a href="#" class="block px-6 py-3 text-white text-xs sm:text-sm">Private Residences</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="relative block px-4 py-2 transition-all duration-300 text-center">
              News & <br class="hidden sm:block" /> Updates
            </a>
          </li>

          <li>
            <a href="#" class="relative block px-4 py-2 transition-all duration-300 text-center">
              For Partners <br class="hidden sm:block" /> and Brokers
            </a>
          </li>

          <li>
            <a href="#" class="relative block px-4 py-2 transition-all duration-300 whitespace-nowrap">
              Contact us
            </a>
          </li>

        </ul>
      </nav>

      <!-- Mobile Menu Button (Visible at 768px and below) -->
      <button class="block lg:hidden focus:outline-none text-3xl p-2" @click="toggleMenu">
        ☰
      </button>
    </div>
<!-- Mobile Dropdown (Visible when menu is open) -->
<transition name="slide">
  <nav v-if="isMenuOpen" class="absolute top-full left-0 w-full bg-black bg-opacity-80 text-white p-6 lg:hidden">
    <ul class="flex flex-col text-center antialiased text-lg space-y-4">
      
      <li class="relative">
        <a href="#" class="block py-3 hover:text-gray-300 transition-all duration-300">About us</a>
        <hr class="border-white opacity-30 w-4/5 mx-auto">
      </li>

      <li class="relative">
        <a href="#" class="block py-3 hover:text-gray-300 transition-all duration-300">Citadines Southwoods</a>
        <ul class="mt-2 space-y-2 text-base text-gray-300">
          <li><a href="#" class="block hover:text-white transition-all duration-300">Location</a></li>
          <li><a href="#" class="block hover:text-white transition-all duration-300">Amenities</a></li>
          <li><a href="#" class="block hover:text-white transition-all duration-300">Serviced Residences</a></li>
          <li><a href="#" class="block hover:text-white transition-all duration-300">Private Residences</a></li>
        </ul>
        <hr class="border-white opacity-30 w-4/5 mx-auto mt-3">
      </li>

      <li class="relative">
        <a href="#" class="block py-3 hover:text-gray-300 transition-all duration-300">News & Updates</a>
        <hr class="border-white opacity-30 w-4/5 mx-auto">
      </li>

      <li class="relative">
        <a href="#" class="block py-3 hover:text-gray-300 transition-all duration-300">For Partners and Brokers</a>
        <hr class="border-white opacity-30 w-4/5 mx-auto">
      </li>

      <li class="relative">
        <a href="#" class="block py-3 hover:text-gray-300 transition-all duration-300">Contact us</a>
      </li>

    </ul>
  </nav>
</transition>



  </header>
</template>

<script setup>
import { ref } from 'vue';

const isMenuOpen = ref(false);
const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};
</script>

<style>
/* Slide-down transition */
.slide-enter-active, .slide-leave-active {
  transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  max-height: 0;
  opacity: 0;
}
.slide-enter-to, .slide-leave-from {
  max-height: 500px;
  opacity: 1;
}
</style>
