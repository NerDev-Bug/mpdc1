<template>
    <div class="relative w-full min-h-screen bg-white overflow-hidden">
        <!-- Background Image Wrapper -->
        <div class="absolute inset-x-0 top-3 bottom-3 w-full h-auto">
            <!-- Background Image -->
            <img src="../../images/ame6.jpg" alt="Community View" class="w-full h-full object-cover" />
            
            <!-- Overlay -->
            <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-6 md:p-12 bg-black bg-opacity-60">
                
                <!-- Mission & Vision Title -->
                <h2 ref="missionTitle" class="text-white text-3xl sm:text-4xl md:text-6xl font-bold font-cormorant mt-7 md:mt-4 opacity-0 translate-y-10 transition-all duration-1000 ease-out">
                    Our Mission & Vision
                </h2>

                <!-- Increase Text Size -->
                <div ref="missionText" class="max-w-4xl mt-4 md:mt-6 opacity-0 translate-y-10 transition-all duration-1000 ease-out"> 
                    <h3 class="text-white text-2xl md:text-2xl font-semibold font-cormorant">
                        Homemakers and Builders of the Future
                    </h3>
                    <p class="text-white text-xl md:text-xl mt-4 md:mt-5 font-cormorant">
                        We are committed to crafting spaces focused on value and purpose, geared to enrich communities.
                    </p>
                </div>

                <!-- Adjust spacing below text -->
                <div class="pt-12 md:pt-16"></div>

                <!-- Grid Container for Vision Items -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-14 pt-8 md:pt-12 text-center w-full max-w-5xl">
                    <div ref="visionItem1" class="group flex flex-col items-center opacity-0 translate-y-10 transition-all duration-1000 ease-out">
                        <img src="../../images/vision1.png" alt="Increase in sales" class="w-24 h-24 md:w-30 md:h-30 object-contain">
                        <p class="text-white text-xl md:text-2xl font-cormorant">Increase in sales and real estate market</p>
                    </div>
                    <div ref="visionItem2" class="group flex flex-col items-center opacity-0 translate-y-10 transition-all duration-1000 ease-out">
                        <img src="../../images/vision2.png" alt="Community growth" class="w-24 h-24 md:w-30 md:h-30 object-contain">
                        <p class="text-white text-xl md:text-2xl font-cormorant">A thriving community for everyone</p>
                    </div>
                    <div ref="visionItem3" class="group flex flex-col items-center opacity-0 translate-y-10 transition-all duration-1000 ease-out">
                        <img src="../../images/vision3.png" alt="Lifestyle place" class="w-28 h-28 md:w-30 md:h-30 object-contain">
                        <p class="text-white text-xl md:text-2xl font-cormorant">A new lifestyle place for residents and business owners</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// Refs for scroll animations
const missionTitle = ref(null);
const missionText = ref(null);
const visionItem1 = ref(null);
const visionItem2 = ref(null);
const visionItem3 = ref(null);

onMounted(() => {
    const observerOptions = {
        root: null,
        threshold: 0.2, // Triggers when 20% is visible
    };

    const handleIntersect = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                observer.unobserve(entry.target); // Ensure animation runs only once
            }
        });
    };

    const observer = new IntersectionObserver(handleIntersect, observerOptions);

    if (missionTitle.value) observer.observe(missionTitle.value);
    if (missionText.value) observer.observe(missionText.value);
    if (visionItem1.value) observer.observe(visionItem1.value);
    if (visionItem2.value) observer.observe(visionItem2.value);
    if (visionItem3.value) observer.observe(visionItem3.value);
});
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
}

/* Scroll Animation Initial State */
.opacity-0 {
    opacity: 0;
}
.opacity-100 {
    opacity: 1;
}
.translate-y-10 {
    transform: translateY(40px);
}
.translate-y-0 {
    transform: translateY(0);
}
</style>
