<template>
    <AppLayout>
        <div class="flex flex-col min-h-screen bg-white">
            <!-- Hero Section -->
            <main class="relative bg-white">
                <transition name="fade" appear>
                    <div class="w-full h-[40vh] sm:h-[55vh] md:h-[65vh] lg:h-[80vh] xl:h-[90vh] bg-cover bg-center relative"
                        :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
                        <div class="absolute inset-0 bg-black bg-opacity-30"></div>

                        <div ref="heroText"
                            class="absolute bottom-24 sm:bottom-32 left-4 sm:left-8 md:left-16 lg:left-32 text-white text-left font-cormorant px-4 sm:px-6 transition-all duration-700 ease-out"
                            :class="{ 'opacity-100 translate-y-0': heroTextVisible, 'opacity-0 translate-y-10': !heroTextVisible }">
                            <h2
                                class="text-4xl sm:text-[4rem] md:text-[4.5rem] lg:text-[5rem] xl:text-[5.5rem] font-bold leading-tight">
                                Latest News & <br /> Updates
                            </h2>
                        </div>
                    </div>
                </transition>
                <NewsUpdate1 />
                <MarketTrends />
                <Articles />
            </main>
        </div>
    </AppLayout>
</template>


<script setup lang="ts">
import { ref, onMounted } from "vue";
import heroImage from '../../images/amey2.jpg';
import AppLayout from '@/layouts/AppLayout.vue';
import NewsUpdate1 from "./NewsUpdate1.vue";
import MarketTrends from "./MarketTrends.vue";
import Articles from "./Articles.vue";

const heroTextVisible = ref<boolean>(true);
onMounted(() => {
    setTimeout(() => {
        heroTextVisible.value = true;
    }, 500); // Add a small delay for a smooth transition
});
</script>

<style scoped>
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
