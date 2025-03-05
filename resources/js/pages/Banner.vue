<template>
  <div class="bg-white py-12 px-8 md:px-32 flex justify-center relative">
    <div class="w-full max-w-screen-xl flex flex-col lg:flex-row items-start overflow-hidden">
      
      <!-- Image with Scroll-based Fade-in Effect -->
      <div ref="imageContainer" 
           class="w-full lg:w-1/2 flex relative order-1 lg:order-none opacity-0 translate-y-10 transition-all duration-700 ease-out"
           :class="{ 'fade-in': isImageVisible }">
        <img 
          src="../images/ame2.jpg" 
          alt="Community View" 
          class="w-full h-auto md:h-[600px] lg:h-[900px] object-cover rounded-l-lg rounded-br-lg"
        />
      </div>

      <!-- Text Box with Scroll-based Fade-in Effect -->
      <div ref="textContainer" 
           class="relative w-full lg:w-1/2 flex flex-col order-2 lg:order-none opacity-0 translate-y-10 transition-all duration-700 ease-out"
           :class="{ 'fade-in': isTextVisible }">
        
        <!-- Text Box -->
        <div class="bg-gray-300 p-8 md:p-16 w-full flex flex-col justify-between md:min-h-[450px] lg:min-h-[600px] relative z-10 rounded-tr-lg">
          
          <!-- Title -->
          <h4 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-semibold font-cormorant text-blue-900">
            Who we are
          </h4>

          <!-- Text Content -->
          <div class="flex-grow">
            <p class="text-black text-lg md:text-xl leading-relaxed font-cormorant">
              Malveda Holdings Corporation (MHC), a conglomerate dedicated to enhancing the lives of Filipino farmers, has leveraged its diverse portfolio of agricultural companies to embark on a new business endeavor.
            </p>
            <p class="text-black text-lg md:text-xl leading-relaxed font-cormorant mt-4">
              Riding on the success of its subsidiary, <i>LEADS Agri</i>, MHC has expanded into the real estate sector.
            </p>
            <p class="text-black text-lg md:text-xl leading-relaxed font-cormorant mt-4">
              After nearly three decades in agribusiness, MHC founded <i>Malveda Properties and Development Corporation (MPDC)</i> in 2020.
            </p>
          </div>

        </div>

        <!-- NEW Gray Background (SEAMLESS) -->
        <div class="w-full h-20 md:h-32 bg-gray-500 rounded-br-sm"></div>

      </div>

    </div>
  </div>
</template>

<script lang="ts">
import { ref, onMounted } from 'vue';

export default {
  setup() {
    const isImageVisible = ref(false);
    const isTextVisible = ref(false);
    const imageContainer = ref<HTMLElement | null>(null);
    const textContainer = ref<HTMLElement | null>(null);

    // Intersection Observer for smooth fade-in when scrolling
    const handleIntersection = (entries: IntersectionObserverEntry[], observer: IntersectionObserver) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          if (entry.target === imageContainer.value) {
            isImageVisible.value = true;
          }
          if (entry.target === textContainer.value) {
            isTextVisible.value = true;
          }
        }
      });
    };

    onMounted(() => {
      const observer = new IntersectionObserver(handleIntersection, { threshold: 0.3 });

      if (imageContainer.value) observer.observe(imageContainer.value);
      if (textContainer.value) observer.observe(textContainer.value);
    });

    return {
      isImageVisible,
      isTextVisible,
      imageContainer,
      textContainer,
    };
  }
};
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
  font-family: 'Cormorant Garamond', serif;
}

/* Scroll-based Fade-in */
.opacity-0 {
  opacity: 0;
  transform: translateY(20px);
}
.fade-in {
  opacity: 1;
  transform: translateY(0);
}
</style>
