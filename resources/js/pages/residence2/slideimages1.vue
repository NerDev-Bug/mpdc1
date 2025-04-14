<template>
    <div class=" text-white py-12 px-4 md:px-12"
        :style="{ backgroundImage: `url(${SRbg})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <div class="max-w-screen-4xl mx-auto w-[95%]">

            <!-- News Container -->
            <div class="relative w-full overflow-hidden">
                <div class="relative group">

                                <!-- Responsive Wrapper with Aspect Ratio -->
<div class="relative aspect-[16/9] sm:aspect-[16/9] md:aspect-[21/9] lg:aspect-[21/9] w-full overflow-hidden">
    <!-- Image or Video Display -->
    <transition name="fade" mode="out-in">
        <template v-if="images[currentIndex]">
    <img :key="currentIndex" :src="images[currentIndex].src" :alt="images[currentIndex].alt"
        class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-500 transform group-hover:scale-105" />
</template>

    </transition>
</div>

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black opacity-40"></div>

                    <!-- Transition for News Content (Fade-in + Slide-up) -->
                    <div ref="textContainer" class="absolute top-[50%] left-[10%] text-white font-montserrat px-4 sm:px-6 max-w-[80%] sm:max-w-[60%]
                     opacity-0 transform translate-y-10 transition-all duration-700 ease-out"
                        :class="{ 'fade-in': isTextVisible }">
                        <h3 class="text-2xl sm:text-3xl md:text-5xl font-bold leading-tight">
                            {{ images[currentIndex].title }}
                        </h3>
                        <p class="mt-3 text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
                            {{ images[currentIndex].description }}
                        </p>
                    </div>

                    <!-- Auto-Play Progress Bar -->
                    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 w-[40%]">
                        <div class="transition-all duration-[3000ms]" :style="{ width: progressBarWidth }"></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="mt-12">
            <PRForm />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import SRbg from '../../images/SR-bg.png';


// ✅ Import images properly
import PR1 from '../../images/PRst (1).jpg';
import PR2 from '../../images/PRst (2).jpg';
import PR3 from '../../images/PRst (3).jpg';
import PR4 from '../../images/PRst (4).jpg';
import PR5 from '../../images/PRst (5).jpg';
import PR6 from '../../images/PRst (6).jpg';
import PR1B from '../../images/PR1b (1).jpg';
import PR2B from '../../images/PR1b (2).jpg';
import PR3B from '../../images/PR1b (3).jpg';
import PR4B from '../../images/PR1b (4).jpg';
import PR5B from '../../images/PR1b (5).jpg';
import PR6B from '../../images/PR1b (6).jpg';
import PR7B from '../../images/PR1b (7).jpg';
import PR8B from '../../images/PR1b (8).jpg';
import PR9B from '../../images/PR1b (9).jpg';
import PR10B from '../../images/PR1b (10).jpg';
import PR1D from '../../images/PR2d (1).jpg';
import PR2D from '../../images/PR2d (2).jpg';
import PR3D from '../../images/PR2d (3).jpg';
import PR4D from '../../images/PR2d (4).jpg';
import PR5D from '../../images/PR2d (5).jpg';
import PR6D from '../../images/PR2d (6).jpg';
import PR7D from '../../images/PR2d (7).jpg';
import PR8D from '../../images/PR2d (8).jpg';
import PRForm from './PRForm.vue';

// Array of images with correct paths and proper types
interface Image {
    src: string;
    alt: string;
    title: string;
    description: string;
}

const images = ref<Image[]>([
    {
        src: PR1,
        alt: '',
        title: 'Studio Unit',
        description: 'Private Residences'
    },
    {
        src: PR2,
        alt: '',
        title: 'Studio Unit',
        description: 'Private Residences'
    },
    {
        src: PR3,
        alt: '',
        title: 'Studio Unit',
        description: 'Private Residences'
    },
    {
        src: PR4,
        alt: '',
        title: 'Studio Unit',
        description: 'Private Residences'
    },
    {
        src: PR5,
        alt: '',
        title: 'Studio Unit',
        description: 'Private Residences'
    },
    {
        src: PR6,
        alt: '',
        title: 'Studio Unit',
        description: 'Private Residences'
    },
    {
        src: PR1B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR2B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR3B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR4B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR5B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR6B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR7B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR8B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR9B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR10B,
        alt: '',
        title: '1-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR1D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR2D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR3D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR4D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR5D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR6D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR7D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
    {
        src: PR8D,
        alt: '',
        title: '2-Bedroom',
        description: 'Private Residences'
    },
]);


const currentIndex = ref<number>(0);
const progressBarWidth = ref<string>('0%');
let autoSlideInterval: NodeJS.Timeout;
const isTextVisible = ref<boolean>(false);
const isTitleVisible = ref<boolean>(false);
const textContainer = ref<HTMLElement | null>(null);
const titleContainer = ref<HTMLElement | null>(null);

// Function to navigate to the next image
const nextImage = (): void => {
    currentIndex.value = (currentIndex.value + 1) % images.value.length;
    resetProgress();
};

// Auto-slide every 3 seconds
const startAutoSlide = (): void => {
    autoSlideInterval = setInterval(() => {
        nextImage();
    }, 4000);
};

// Reset progress bar
const resetProgress = (): void => {
    progressBarWidth.value = '0%';
    setTimeout(() => {
        progressBarWidth.value = '100%';
    }, 50);
};

// Scroll-based fade-in effects for text & title
const handleIntersection = (entries: IntersectionObserverEntry[]): void => {
    entries.forEach((entry) => {
        if (entry.target === textContainer.value && entry.isIntersecting) {
            isTextVisible.value = true;
        }
        if (entry.target === titleContainer.value && entry.isIntersecting) {
            isTitleVisible.value = true;
        }
    });
};

onMounted(() => {
    startAutoSlide();
    resetProgress();

    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.6 });
    if (textContainer.value) observer.observe(textContainer.value);
    if (titleContainer.value) observer.observe(titleContainer.value);
});

onUnmounted(() => {
    clearInterval(autoSlideInterval);
});
</script>


<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}

/* Smooth Fade-in Effect */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.8s ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

/* Scroll-based Text Animation */
.opacity-0 {
    opacity: 0;
    transform: translateY(20px);
}

.fade-in {
    opacity: 1;
    transform: translateY(0);
}

/* Title Scroll Animation (Slide Down + Fade-in) */
.fade-down {
    opacity: 1;
    transform: translateY(0);
}
/* Ensuring Images are Contained within Their Parent */
img {
    object-position: center center;
}
/* Ensure overlay takes full height and width */
div.absolute.inset-0.bg-black.opacity-40 {
    height: 100%;
    width: 100%;
}
</style>
