<template>
    <AppLayout>
        <div class="flex flex-col min-h-screen bg-white">
            <div class="relative bg-white">
                <div class="w-full h-[40vh] sm:h-[55vh] md:h-[65vh] lg:h-[80vh] xl:h-[90vh] bg-cover bg-center relative"
                    :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
                </div>

                <div ref="textContainer"
                    class="absolute bottom-32 md:bottom-[200px] left-4 sm:left-8 md:left-16 lg:left-32 text-white text-left font-cormorant px-4 sm:px-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': isTextVisible }">
                    <h2
                        class="text-4xl sm:text-[4rem] md:text-[4.5rem] lg:text-[5rem] xl:text-[5.5rem] font-bold leading-tight">
                        For Partners <br> and Brokers
                    </h2>
                </div>
            </div>
            <ForPartnersandBrokers />
            <ForPartnersandBrokers1 />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import heroImage from '../../images/partner1.png';
import AppLayout from '@/layouts/AppLayout.vue';
import ForPartnersandBrokers from './ForPartnersandBrokers.vue';
import ForPartnersandBrokers1 from './ForPartnersandBrokers1.vue';

const isImageVisible = ref(false);
const isTextVisible = ref(false);
const imageContainer = ref<HTMLElement | null>(null);
const textContainer = ref<HTMLElement | null>(null);

// Intersection Observer for smooth fade-in when scrolling
const handleIntersection = (entries: IntersectionObserverEntry[]) => {
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

/* Fade-in on Scroll */
.fade-in {
    opacity: 1;
    transform: translateY(0);
}
</style>
