<template>
  <AppLayout>
    <SeoHead
      title="Malveda Properties and Development Corporation"
      description="Discover MPDC and The Cerise Tower's serviced and private residences in Southwoods City, Biñan, Laguna."
      canonical-path="/"
      :image="heroImage"
      image-alt="The Cerise Tower by Malveda Properties and Development Corporation"
      :structured-data="{
        '@type': 'Organization',
        name: 'Malveda Properties and Development Corporation',
        alternateName: 'MPDC',
        logo: '/icon.png',
        email: 'inquiries@malvedaproperties.com',
        telephone: '+63 917 515 0123',
        sameAs: [
          'https://www.facebook.com/cerisetower/',
          'https://www.instagram.com/thecerisetower/',
        ],
      }"
    />
    <div class="flex flex-col min-h-screen bg-white">
      <!-- Hero Section -->
      <main class="relative bg-white">
        <h1 class="sr-only">Malveda Properties and Development Corporation</h1>
<div
  class="
    w-full
    h-[26vh] sm:h-[60vh] md:h-[80vh] lg:h-[90vh] xl:h-screen
    bg-no-repeat
    bg-center
    bg-cover          /* use cover instead of contain */
    relative flex items-center
    mt-[60px] sm:mt-0
  "
  :style="{ backgroundImage: `url(${heroImage})` }"
>
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
          </div>
        <div class="w-full h-min-screen">
          <img :src="awardBanner"
            alt="Citadines Southwoods Biñan at The Cerise Tower, Best Serviced Apartment at the 2025 Dot Property Philippines Awards"
            width="1920" height="989" loading="lazy" decoding="async" class="h-auto w-full">
        </div>

        <!-- Imported White Section -->
        <Banner />

        <!-- Latest News & Updates Section -->
        <News :slides="newsSlides" />
      </main>
    </div>
  </AppLayout>
</template>

<script lang="ts">
import heroImage from '../images/homepage.jpg';
import awardBanner from '../images/award.jpg';
import Banner from '../pages/Banner.vue';
import News from '../pages/News.vue';
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';

interface SlideData {
  id: number;
  title: string;
  description: string;
  src: string;
  alt: string;
}

export default {
  components: {
    Banner,
    News,
    SeoHead,
    AppLayout
  },
  props: {
    newsSlides: {
      type: Array as () => SlideData[],
      default: () => [],
    },
  },
  setup() {
    return {
      heroImage,
      awardBanner,
    };
  }
};
</script>

<style>
/* Import Custom Font */
.font-montserrat {
  font-family: 'Montserrat', sans-serif;
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
