<template>
    <div class="w-full h-fit flex items-center justify-center py-12 px-0 lg:px-4"
        :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <div class="w-full h-fit px-2 py-2">
            <div class="flex items-center justify-center flex-col-reverse lg:flex-row w-full px-4">
                <div class="w-full h-fit py-4 lg:py-12 px-2">
                    <div class="px-12">
                        <h2
                            class="font-montserrat text-white text-[20px] md:text-3xl lg:text-[40px] text-center md:text-justify font-bold mb-4 sm:mb-6 md:mb-8">
                            Citadines Southwoods <br> Biñan at the Cerise Tower
                        </h2>
                    </div>
                    <div class="w-full h-fit px-4 mt-12 lg:mt-14">
                        <p class=" text-white text-sm sm:text-base md:text-lg lg:text-[24px] xl:text-[24px] text-justify">
                            The Cerise Tower is MPDC’s first project set to rise in Southwoods City, Biñan, Laguna.
                            Designed
                            for
                            business owners and corporate executives, MPDC and The Ascott Limited partnered to
                            create a
                            master-planned 22-floor mixed-use building equipped to offer a world-class
                            Live-Work-Play-Relax
                            lifestyle.
                        </p>
                    </div>
                    <!-- Navigation Links -->
                    <div class="flex flex-col items-center gap-6 mt-16 font-montserrat font-semibold">
                        <a class="text-[15px] xl:text-[18px] bg-cover bg-center border rounded-xl border-black w-60 text-center px-6 py-3 text-black hover:bg-white hover:text-black transition shadow-lg"
                            :style="{ backgroundImage: `url(${goldbutton})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
                            href="/amenities">
                            Amenities
                        </a>
                        <div class="flex flex-wrap lg:row justify-center gap-6 px-4">
                            <a class="text-[15px] xl:text-[17px] border rounded-xl border-black w-60 text-center px-6 py-3 text-black hover:bg-white hover:text-black transition shadow-lg"
                                :style="{ backgroundImage: `url(${goldbutton})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
                                href="/serviced-residence">
                                Serviced Residences
                            </a>
                            <a class="text-[15px] xl:text-[18px] border rounded-xl border-black w-60 text-center px-6 py-3 text-black hover:bg-white hover:text-black transition shadow-lg"
                                :style="{ backgroundImage: `url(${goldbutton})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
                                href="/private-residence">
                                Private Residences
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full h-fit py-2">
                    <div class="w-full h-fit flex items-center justify-center px-2">
                        <div
                            class="bg-[#0b1021] w-full max-w-lg sm:max-w-xl md:max-w-[550px] lg:max-w-1xl xl:max-w-[700px] p-4 sm:p-3 flex justify-center">
                            <img src="../../images/citadines_normal-view.jpg"
                                class="w-full h-auto shadow-lg object-cover rounded-lg translate-x-2 translate-y-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script setup lang="ts">
import { ref, onMounted } from "vue";
import heroImage from '../../images/pattern31.png';
import goldbutton from '../../images/goldbutton34.jpg'

const textVisible = ref<boolean>(false);
const imageVisible = ref<boolean>(false);
const textSection = ref<HTMLElement | null>(null);
const imageSection = ref<HTMLElement | null>(null);

// Intersection Observer for Scroll Animation
onMounted(() => {
    const observerOptions = { threshold: 0.5 };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target === textSection.value) {
                    textVisible.value = true;
                } else if (entry.target === imageSection.value) {
                    imageVisible.value = true;
                }
            }
        });
    }, observerOptions);

    if (textSection.value) observer.observe(textSection.value);
    if (imageSection.value) observer.observe(imageSection.value);
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
