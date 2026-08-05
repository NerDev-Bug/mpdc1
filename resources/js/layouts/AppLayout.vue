<template>
  <div>
    <Navbar />

    <!-- Loading Overlay with Logo (Black Background) -->
    <!-- <transition name="loading-fade" mode="out-in">
      <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <img src="../images/logo.png" alt="Loading Logo" class="h-20 w-auto animate-pulse" />
      </div>
    </transition> -->

    <!-- Keep this as normal DOM: SeoHead plus page content makes the slot a
         fragment, which Vue Transition drops during client-only rendering. -->
    <slot />

    <Footer />
  </div>
</template>

<script setup lang="ts">
import Footer from "../pages/components/Footer.vue";
import Navbar from "../pages/components/Navbar.vue";
</script>
