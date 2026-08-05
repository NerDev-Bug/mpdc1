<template>
    <AppLayout>
        <SeoHead
            title="Private Residences at The Cerise Tower"
            description="Explore studio, one-bedroom, and two-bedroom private residence options at The Cerise Tower in Southwoods City, Biñan."
            canonical-path="/private-residence"
            :image="heroImage"
            image-alt="Private Residences at The Cerise Tower"
            :structured-data="{
                '@type': 'WebPage',
                name: 'Private Residences at The Cerise Tower',
            }"
        />
        <div class="flex flex-col min-h-screen bg-white">
            <!-- Hero Section -->
            <div class="relative bg-white">
                <div class="w-full h-[50vh] sm:h-[100vh] md:h-[90vh] lg:h-[90vh] xl:h-screen bg-cover bg-center relative flex flex-col md:flex-row items-center justify-center"
                    :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">

                    <!-- Separate Black Overlay -->
                    <div class="absolute inset-0 bg-blue-900/70"></div>

                    <!-- Center the heading both vertically and horizontally, with a slight upward shift on smaller screens -->
                    <div class="absolute inset-0 flex items-center justify-center text-center font-montserrat w-full px-4 md:px-8"
                        style="top: -20%;">
                        <h1
                            class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-7xl xl:text-8xl font-bold leading-tight pt-12">
                            Private <br>
                            Residences
                        </h1>
                    </div>

                    <!-- Buttons Section -->
                    <div
                        role="tablist"
                        aria-label="Private residence unit types"
                        class="residence-buttons-appear absolute bottom-4 md:bottom-[26px] left-1/2 transform -translate-x-1/2 flex flex-wrap justify-center gap-4 w-full px-4 min-[648px]:flex-row flex-col items-center">
                            <button v-for="unit in unitOptions" :key="unit.name" :id="unit.tabId" type="button"
                                role="tab" :aria-controls="unit.panelId" :aria-selected="selectedButton === unit.name"
                                @click="selectedButton = unit.name"
                                class="font-montserrat font-semibold text-xs sm:text-sm md:text-base lg:text-xl xl:text-2xl
                       px-6 sm:px-8 md:px-10 lg:px-12 xl:px-16 py-2 sm:py-3 md:py-4 lg:py-5 xl:py-6
                       rounded-full shadow-xl transition-all duration-300
                       w-[90%] sm:w-[80%] md:w-auto max-w-[250px] sm:max-w-[280px] md:max-w-[300px] lg:max-w-[350px] xl:max-w-[400px]"
                                :class="{
                                    'shadow-2xl scale-105': selectedButton === unit.name,
                                    'hover:shadow-2xl hover:scale-105': selectedButton !== unit.name,
                                    'text-white': selectedButton === unit.name,
                                    'text-black': selectedButton !== unit.name
                                }" :style="{
                                    backgroundImage: selectedButton === unit.name
                                        ? `url(${goldbutton})`
                                        : `url(${defaultbutton})`,
                                    backgroundSize: 'cover',
                                    backgroundPosition: 'center'
                                }">
                                {{ unit.name }}
                            </button>
                    </div>

                </div>
            </div>

            <!-- Service Residence Section -->
            <div class="">
                <PrivateResidence1 id="private-studio-panel" role="tabpanel" aria-labelledby="private-studio-tab"
                    tabindex="0" v-show="selectedButton === 'PR Studio Unit' || selectedButton === null" />
                <PrivateResidence2 id="private-one-bedroom-panel" role="tabpanel"
                    aria-labelledby="private-one-bedroom-tab" tabindex="0"
                    v-show="selectedButton === 'PR 1 Bedroom Unit'" />
                <PrivateResidence3 id="private-two-bedroom-panel" role="tabpanel"
                    aria-labelledby="private-two-bedroom-tab" tabindex="0"
                    v-show="selectedButton === 'PR 2 Bedroom Unit'" />
            </div>

            <slideimages :selectedButton="selectedButton"/>

            <!-- <div class="bg-gray-900">
        <PRForm />
      </div> -->
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, provide} from 'vue';
import heroImage from '../../images/contactimage12.jpg';
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PrivateResidence1 from './PrivateResidence1.vue';
import slideimages from './slideimages1.vue';
import PrivateResidence3 from './PrivateResidence3.vue';
// import PRForm from './PRForm.vue';
import PrivateResidence2 from './PrivateResidence2.vue';
import defaultbutton from '../../images/goldbutton34.jpg';
import goldbutton from '../../images/goldbuttondefault.jpg';

const showImages = ref(false);
const selectedButton = ref<string>('PR Studio Unit'); // Default selection
// Provide the selected unit to child components
provide('selectedUnit', selectedButton);

const unitOptions = [
    { name: "PR Studio Unit", tabId: 'private-studio-tab', panelId: 'private-studio-panel' },
    { name: "PR 1 Bedroom Unit", tabId: 'private-one-bedroom-tab', panelId: 'private-one-bedroom-panel' },
    { name: "PR 2 Bedroom Unit", tabId: 'private-two-bedroom-tab', panelId: 'private-two-bedroom-panel' }
];

onMounted(() => {
    setTimeout(() => {
        showImages.value = true;
    }, 300); // Slight delay for smooth transition
});

onMounted(() => {
    window.addEventListener('modal-opened', () => {
        document.body.style.overflow = 'hidden';
    });

    window.addEventListener('modal-closed', () => {
        document.body.style.overflow = '';
    });
});

onUnmounted(() => {
    window.removeEventListener('modal-opened', () => {
        document.body.style.overflow = 'hidden';
    });

    window.removeEventListener('modal-closed', () => {
        document.body.style.overflow = '';
    });
});


</script>

<style scoped>
/* Import Custom Font */
.font-montserrat {
    font-family: 'Montserrat', sans-serif;
}

/* Smooth Fade & Slide-Up Effect */
.fade-slide-up-enter-active,
.fade-slide-up-appear-active {
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.fade-slide-up-enter-from,
.fade-slide-up-appear-from {
    opacity: 0;
    transform: translateY(20px);
}

/* Preserve the former appear effect without an SSR-inert Transition wrapper. */
.residence-buttons-appear {
    animation: residence-buttons-appear 1s ease-in-out 0.4s both;
}

@keyframes residence-buttons-appear {
    from { opacity: 0; }
    to { opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
    .residence-buttons-appear {
        animation: none;
    }
}
</style>
