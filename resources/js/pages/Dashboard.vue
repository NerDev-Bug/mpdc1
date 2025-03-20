<template>
  <AppLayout>
    <div class="flex flex-col min-h-screen bg-white">
      <!-- Hero Section -->
      <main class="relative bg-white">
        <transition name="fade-out" appear>
          <div 
            class="w-full h-[50vh] sm:h-[65vh] md:h-[75vh] lg:h-[90vh] xl:h-screen bg-cover bg-center relative"
            :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
          >
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            
            <!-- Responsive Positioned Text with Scroll Animation -->
            <div ref="heroText"
              class="absolute top-1/4 md:top-[30%] right-4 sm:right-8 md:right-16 lg:right-32 text-white text-right font-cormorant px-4 sm:px-6 transition-all duration-700 ease-out"
              :class="{ 'opacity-100 translate-y-0': heroTextVisible, 'opacity-0 translate-y-10': !heroTextVisible }"
            >
              <h2 class="text-4xl sm:text-[4rem] md:text-[4.5rem] lg:text-[5rem] xl:text-[5.5rem] font-bold leading-tight">
                Enjoy the Revenue of <br>
                 owning a hotel unit <br>
                 with ease!
              </h2>
            </div>
          </div>
        </transition>

        <!-- Imported White Section -->
        <Banner />

        <!-- Latest News & Updates Section -->
        <News />
      </main>
    </div>
  </AppLayout>
</template>

<script lang="ts">
import { ref, onMounted } from "vue";
import heroImage from '../images/ame1.jpg';
import Banner from '../pages/Banner.vue';
import News from '../pages/News.vue';
import AppLayout from '@/layouts/AppLayout.vue';

export default {
  components: {
    Banner,
    News,
    AppLayout
  },
  setup() {
    const heroTextVisible = ref(false);
    const heroText = ref<HTMLElement | null>(null); // Ensure ref is correctly typed

    // Intersection Observer for Scroll Animation
    onMounted(() => {
      const observer = new IntersectionObserver(
        (entries) => {
          console.log("Observed:", entries[0].isIntersecting); // Debugging log
          if (entries[0].isIntersecting) {
            heroTextVisible.value = true;
            observer.disconnect(); // Ensures it only runs once
          }
        },
        { threshold: 0.2 } // Lowered threshold for quicker visibility
      );

      if (heroText.value) {
        observer.observe(heroText.value);
      }
    });

    return {
      heroImage,
      heroText,
      heroTextVisible,
    };
  }
};
</script>

<style>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}

/* Initial State */
.opacity-0 {
  opacity: 0;
  transform: translateY(20px);
}

/* Active State */
.opacity-100 {
  opacity: 1;
  transform: translateY(0);
}

/* Debugging Border (Remove after testing) */
.debug {
  border: 2px solid red;
}
</style>
