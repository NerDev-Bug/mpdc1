<template>
    <div class="relative w-full min-h-screen bg-black flex flex-col justify-center items-center px-2 py-4 md:py-12">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="../../images/ame7.jpg" alt="Milestone Background" class="w-full h-full object-cover">
        </div>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <!-- Overlay Wrapping the Milestone Section -->
        <div
            class="flex flex-col justify-center items-center text-center px-2 py-8 md:py-12">
            <div class="w-full h-fit flex flex-col justify-center items-center text-center mt-16">
                <!-- Milestone Title (Centered & Fades in) -->
                <h2 ref="milestoneTitle"
                    class="text-white text-3xl sm:text-5xl md:text-6xl font-bold font-montserrat drop-shadow-lg opacity-0 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': titleVisible }">
                    Milestone
                </h2>

                <!-- Timeline Section -->
                <div ref="milestoneContainer" class="relative w-full max-w-6xl px-4 md:px-16 lg:px-32 py-12 text-white">
                    <div class="relative grid grid-cols-1 md:grid-cols-5 gap-x-10 gap-y-4 md:gap-y-10">
                        <!-- Timeline Events (Fade in together on Scroll) -->
                        <div v-for="(event, index) in milestones" :key="index"
                            class="relative flex flex-col items-center text-center opacity-0 translate-y-10 transition-all duration-700 ease-out"
                            :class="{ 'fade-in': event.visible }">
                            <p class="text-3xl md:text-4xl font-montserrat">{{ event.year }}</p>
                            <div class="w-12 md:w-16 border-t border-white mt-2 mb-2 md:mb-4"></div>
                            <p class="text-[15px] md:text-base" v-for="(desc, i) in event.descriptions" :key="i"
                                :class="{ 'mb-5': i === 0 }">
                                {{ desc }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";

const titleVisible = ref<boolean>(false);
const milestoneTitle = ref<HTMLElement | null>(null);
const milestoneContainer = ref<HTMLElement | null>(null);

const milestones = ref([
    { year: "2019", descriptions: ["The birth of Malveda Properties and Development Corporation"], visible: false },
    {
        year: "2020", descriptions: [
            "MPDC and The Ascott Limited contract signing for Citadines Southwoods Biñan",
            "Groundbreaking ceremony and blessing of MPDC’s Citadines Southwoods Biñan"
        ], visible: false
    },
    { year: "2021", descriptions: ["MPDC and PMI Contract Signing"], visible: false },
    {
        year: "2022", descriptions: [
            "MPDC and The Ascott Limited contract signing for Citadines Southwoods Biñan",
            "Groundbreaking ceremony and blessing of MPDC’s Citadines Southwoods Biñan"
        ], visible: false
    },
    { year: "2024", descriptions: ["Citadines Southwoods Biñan at The Cerise Tower’s Topping Off Ceremony"], visible: false }
]);

onMounted(() => {
    // Observe the entire milestone section
    const observerOptions: IntersectionObserverInit = { threshold: 0.2 };
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            milestones.value.forEach(m => m.visible = true);
        }
    }, observerOptions);

    if (milestoneContainer.value) {
        observer.observe(milestoneContainer.value);
    }

    // Observe the title separately
    const titleObserverOptions: IntersectionObserverInit = { threshold: 0.5 };
    const titleObserver = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            titleVisible.value = true;
        }
    }, titleObserverOptions);

    if (milestoneTitle.value) {
        titleObserver.observe(milestoneTitle.value);
    }
});
</script>

<style scoped>
/* Import Custom Font */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
    font-family: 'Montserrat', sans-serif;
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
