<template>
    <div class="p-8"
    :style="{ backgroundImage: `url(${locationbg})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <!-- Main Content Container -->
        <div class="flex flex-col md:flex-row items-end">

            <!-- Left Side: Header + Description -->
            <div class="md:w-1/2 flex flex-col">
                <!-- Floating Header with Transition -->
                <transition name="slide-up" appear>
                    <h2
                        class="font-montserrat text-white ml-16 py-5 text-3xl lg:text-5xl font-bold rounded-tl-lg inline-block w-auto">
                        Location Map
                    </h2>
                </transition>

                <!-- Description Section -->
                <div class="p-10 rounded-l-lg">
                    <div class="text-white font-montserrat">
                        <!-- Text Slides Up with Delay -->
                        <transition name="slide-up-delayed" appear>
                            <p class="text-xl leading-relaxed text-justify">
                                Situated within a thoughtfully planned estate, Citadines Southwoods Biñan offers a prime
                                location for both
                                short-term and extended stays. Designed with corporate guests in mind, including
                                expatriates working in
                                nearby techno-industrial parks, it ensures a comfortable and convenient living
                                experience. Additionally,
                                its strategic location places it merely 10 kilometers from the bustling business
                                district of Alabang.
                            </p>
                        </transition>
                    </div>
                </div>
            </div>

            <!-- Right Side: Google Map -->
            <div class="md:w-1/2 p-5 rounded-tl-lg rounded-r-lg">
                <iframe class="w-full h-[400px] rounded-md border border-gray-300 shadow-md"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15444.486654971224!2d121.0470548!3d14.3318747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d7161d84c1ad%3A0xf5273f824c22afda!2sCoral%20Center!5e0!3m2!1sen!2sph!4v1709800000000!5m2!1sen!2sph"
                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
        <div>

        </div>
    </div>
</template>
<script setup lang="ts">

import locationbg from '../../images/location_bg.png';

</script>
<style scoped>
/* Slide-Up Transition */
.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.8s ease-out;
}

.slide-up-enter-from,
.slide-up-leave-to {
    opacity: 0;
    transform: translateY(30px);
}

/* Slide-Up Transition with Delay */
.slide-up-delayed-enter-active {
    transition: all 0.8s ease-out;
    transition-delay: 300ms;
    /* 300ms delay */
}

.slide-up-delayed-enter-from {
    opacity: 0;
    transform: translateY(30px);
}

@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}
</style>
