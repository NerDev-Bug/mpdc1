<template>
  <header class="fixed top-0 left-0 w-full bg-black bg-opacity-50 text-white p-4 z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center px-4 md:px-6">
      <a href="/" class="block">
        <img
          src="../../images/logo.png"
          alt="MPDC Logo"
          class="h-10 sm:h-10 md:h-10 lg:h-12 w-auto min-w-[60px] sm:min-w-[80px] md:min-w-[100px] cursor-pointer"
        />
      </a>

      <nav class="hidden lg:flex space-x-2 sm:space-x-4 lg:space-x-6 xl:space-x-8 text-sm sm:text-base md:text-lg antialiased">
        <ul class="flex space-x-2 sm:space-x-4 lg:space-x-6 xl:space-x-8">
          <li>
            <a href="/about" class="relative block px-4 py-2 transition-all duration-300 underline-effect">
              About us
            </a>
          </li>

          <li class="relative dropdown-container"
              @mouseenter="isDropdownOpen = true"
              @mouseleave="closeDropdown"
              @click="toggleDropdown">
            <a
              href="/citadines"
              class="relative block px-4 py-2 transition-all duration-300 text-center underline-effect focus:outline-none"
            >
              Citadines <br class="hidden sm:block" /> Southwoods
              <span class="inline-block text-xs transform transition-transform" :class="{'rotate-180': isDropdownOpen}">▾</span>
            </a>

            <!-- Dropdown Menu -->
            <ul
              v-show="isDropdownOpen"
              class="absolute left-0 top-full w-48 bg-black bg-opacity-50 shadow-lg transition-all duration-300 mt-4"
              @mouseenter="isDropdownOpen = true"
              @mouseleave="closeDropdown"
            >
              <li><a href="/location" class="block px-6 py-3 text-white text-xs sm:text-sm underline-effect">Location</a></li>
              <li><a href="/amenities" class="block px-6 py-3 text-white text-xs sm:text-sm underline-effect">Amenities</a></li>
              <li><a href="/service-residence" class="block px-6 py-3 text-white text-xs sm:text-sm underline-effect">Serviced Residences</a></li>
              <li><a href="/private-residence" class="block px-6 py-3 text-white text-xs sm:text-sm underline-effect">Private Residences</a></li>
            </ul>
          </li>

          <li>
            <a href="/for-partners-and-brokers" class="relative block px-4 py-2 transition-all duration-300 text-center underline-effect">
              For Partners <br class="hidden sm:block" /> and Brokers
            </a>
          </li>

          <li>
            <a href="/contact-us" class="relative block px-4 py-2 transition-all duration-300 whitespace-nowrap underline-effect">
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
      <nav v-if="isMenuOpen" class="absolute top-full left-0 w-full bg-black bg-opacity-20 sm:backdrop-blur-sm text-white p-6 lg:hidden blur-fallback">
        <ul class="flex flex-col text-center antialiased text-lg space-y-4">
          <!-- About Us -->
          <li>
            <a href="/about" class="block px-4 py-2 transition-all duration-300" @click="closeMenu">
              About us
            </a>
            <hr class="border-white opacity-30 w-full mx-auto mt-2">
          </li>

          <!-- Citadines Southwoods -->
          <li class="relative">
            <a href="/citadines" class="block py-3 hover:text-gray-300 transition-all duration-300" @click="closeMenu">Citadines Southwoods</a>
            <hr class="border-white opacity-30 w-full mx-auto mt-2">
          </li>

          <!-- For Partners and Brokers -->
          <li>
            <a href="/for-partners-and-brokers" class="block py-3 hover:text-gray-300 transition-all duration-300" @click="closeMenu">For Partners and Brokers</a>
            <hr class="border-white opacity-30 w-full mx-auto mt-2">
          </li>

          <!-- Contact Us -->
          <li>
            <a href="/contact-us" class="block py-3 hover:text-gray-300 transition-all duration-300" @click="closeMenu">Contact us</a>
          </li>
        </ul>
      </nav>
    </transition>
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const isMenuOpen = ref<boolean>(false);
const isDropdownOpen = ref<boolean>(false);

const toggleMenu = (): void => {
  isMenuOpen.value = !isMenuOpen.value;
};

const toggleDropdown = (): void => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

// Close the dropdown menu when the user scrolls
const closeDropdownOnScroll = (): void => {
  if (isDropdownOpen.value) {
    isDropdownOpen.value = false;
  }
};

// Close dropdown when clicking outside
const closeDropdown = (event: MouseEvent): void => {
  const target = event.target as Element;
  if (target && !target.closest('.dropdown-container')) {
    isDropdownOpen.value = false;
  }
};

// Close menu (you need this method if you're calling closeMenu)
const closeMenu = (): void => {
  isMenuOpen.value = false;
};

// Attach and remove event listeners
onMounted(() => {
  window.addEventListener('click', closeDropdown);
  window.addEventListener('scroll', closeDropdownOnScroll);
});

onUnmounted(() => {
  window.removeEventListener('click', closeDropdown);
  window.removeEventListener('scroll', closeDropdownOnScroll);
});
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

/* Ensure backdrop blur works on all devices */
.blur-fallback::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(1px);
  -webkit-backdrop-filter: blur(1px); /* Safari support */
  z-index: -1;
}

.underline-effect {
  position: relative;
}

.underline-effect::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 100%;
  height: 2px;
  background-color: white;
  transform: scaleX(0);
  transition: transform 0.3s ease-in-out;
}

.underline-effect:hover::after {
  transform: scaleX(1);
}
</style>
