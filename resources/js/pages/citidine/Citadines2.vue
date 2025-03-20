<template>
    <div
        class="bg-white w-full h-fit flex flex-col lg:flex-row items-center justify-center px-10 md:px-12 lg:px-12 py-12">
<video autoplay loop muted
    ref="videoElement"
    class="w-full max-w-[100%] h-[12rem] md:h-[25rem] lg:h-[28rem] opacity-0 translate-y-10 transition-all duration-700 ease-out"
    :class="{ 'fade-in': isImageVisible }"
    @mouseover="playVideo"
    @mouseleave="pauseVideo">
    <source src="../../images/videos/vid1.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>


        <div ref="imageContainer"
            class="bg-[#98b9da] w-full max-w-[100%] h-[20rem] md:h-[25rem] lg:h-[26.5rem] -mt-1 md:-mt-3 lg:mt-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': isImageVisible }">
            <div
                class="flex items-center justify-center bg-[#7995b0] w-full max-w-[100%] h-[90%] md:h-[93%] lg:h-[95%] px-8 md:px-6 py-8">
                <div class="w-full h-fit px-4 lg:px-10 py-4">
                    <p class="text-2xl md:text-3xl lg:text-[40px] text-left">
                        Enjoy the revenues of owning hotel <br class="hidden md:display-block">with ease
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

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

// Explicitly define the video ref type
const videoElement = ref<HTMLVideoElement | null>(null);

const playVideo = () => {
    videoElement.value?.play(); // Use optional chaining to avoid null errors
};

const pauseVideo = () => {
    videoElement.value?.pause();
};

// Ensure the video element is assigned when mounted
onMounted(() => {
    if (videoElement.value) {
        videoElement.value.load(); // Reloads the video if needed
    }
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
