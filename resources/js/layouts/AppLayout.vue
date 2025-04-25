<template>
  <div>
    <Navbar />

    <!-- Loading Overlay with Logo (Black Background) -->
    <!-- <transition name="loading-fade" mode="out-in">
      <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <img src="../images/logo.png" alt="Loading Logo" class="h-20 w-auto animate-pulse" />
      </div>
    </transition> -->

    <!-- Page Transition -->
    <transition name="fade" mode="out-in">
      <slot />
    </transition>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { ref, watchEffect } from "vue";
import Navbar from "../pages/components/Navbar.vue";
import Footer from "../pages/components/Footer.vue";

const loading = ref(false);


// Trigger loading on route change
watchEffect(() => {
  loading.value = true;
  setTimeout(() => {
    loading.value = false;
  }, 800); // Smooth and subtle loading effect
});

</script>

<style>
/* Smooth Fade-in for Pages */
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s ease-in-out;
}

.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

/* Loading Screen Fade Effect */
.loading-fade-enter-active, .loading-fade-leave-active {
  transition: opacity 0.4s ease-in-out;
}

.loading-fade-enter-from, .loading-fade-leave-to {
  opacity: 0;
}
</style>
