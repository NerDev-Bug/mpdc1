<template>
    <div class="w-full h-fit py-12 px-0 sm:px-4 md:px-4"
        :style="{ backgroundImage: `url(${fpbbg})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <div class="flex flex-col min-[935px]:flex-row items-center justify-center min-h-screen px-0 lg:px-6 py-8">

            <!-- Left Section: Heading & Image -->
            <div class="flex flex-col items-center md:items-start pl-0 md:pl-8 lg:pl-12">
                <transition name="slide-up-text" appear>
                    <h2 class="font-montserrat text-4xl sm:text-5xl font-serif mb-12 text-center md:text-left text-white">
                        1-Bedroom
                    </h2>
                </transition>

                <transition name="slide-up-image" appear>
                    <div class="w-full md:w-auto flex justify-center">
                        <img src="../../images/SRunit2.jpg" alt="Studio Floor Plan"
                            class="shadow-2xl drop-shadow-lg w-[80%] sm:w-[70%] md:w-auto max-w-[250px] sm:max-w-[300px] md:max-w-none mt-0 sm:mt-12">
                    </div>
                </transition>
            </div>


            <!-- Information Section with Slide-Up Transition -->
            <transition name="slide-up-text" appear>
                <div class="w-full text-white px-6 md:px-8 lg:px-12 py-10 text-center md:text-right">
                    <table class="border-4 border-[#967524] w-full text-left font-montserrat mb-6 text-sm sm:text-base">
                        <tbody>
                            <tr class="border border-[#967524]">
                                <td class="p-2 sm:p-3 border border-[#967524] w-1/3 text-2xl">Size Range</td>
                                <td class="p-2 sm:p-3 text-center text-2xl">41.85 – 52 sqm</td>
                            </tr>
                            <tr class="border border-[#967524]">
                                <td class="p-2 sm:p-3 border border-[#967524] w-1/3 text-2xl">Price Range</td>
                                <td class="p-2 sm:p-3 text-center text-2xl">11.7M – 14.6M</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="overflow-x-auto">
                        <table
                            class="border-4 border-[#967524] w-full text-left font-montserrat mb-6 text-xs sm:text-sm md:text-base">
                            <thead>
                                <tr class="border border-[#967524] text-white">
                                    <th colspan="4" class="pl-2 text-xl md:text-2xl lg:text-3xl p-3">Unit Deliverables
                                    </th>
                                </tr>
                                <tr class="border border-[#967524] text-center h-10 md:h-12 lg:h-16">
                                    <th class="text-base md:text-lg lg:text-2xl border border-[#967524]"></th>
                                    <th class="text-base md:text-lg lg:text-2xl border border-[#967524]">Floor</th>
                                    <th class="text-base md:text-lg lg:text-2xl border border-[#967524]">Wall</th>
                                    <th class="text-base md:text-lg lg:text-2xl border border-[#967524]">Ceiling</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="border border-[#967524] text-[12px] sm:text-base md:text-lg">
                                    <td class="p-2 sm:p-3 border border-[#967524] font-semibold">Living / Dining</td>
                                    <td class="p-2 border border-[#967524]">Laminated Flooring</td>
                                    <td class="p-2 border border-[#967524]">Painted</td>
                                    <td class="p-2 border border-[#967524]">Painted</td>
                                </tr>
                                <tr class="border border-[#967524] text-[12px] sm:text-base md:text-lg">
                                    <td class="p-2 sm:p-3 border border-[#967524] font-semibold">Kitchen</td>
                                    <td class="p-2 border border-[#967524]">Homogeneous Tile</td>
                                    <td class="p-2 border border-[#967524]">Quartz <br>(Natural Stone)</td>
                                    <td class="p-2 border border-[#967524]">Painted</td>
                                </tr>
                                <tr class="border border-[#967524] text-[12px] sm:text-base md:text-lg">
                                    <td class="p-2 sm:p-3 border border-[#967524] font-semibold">Bedrooms</td>
                                    <td class="p-2 border border-[#967524]">Laminated Flooring</td>
                                    <td class="p-2 border border-[#967524]">Painted</td>
                                    <td class="p-2 border border-[#967524]">Painted</td>
                                </tr>
                                <tr class="border border-[#967524] text-[12px] sm:text-base md:text-lg">
                                    <td class="p-2 sm:p-3 border border-[#967524] font-semibold">Toilet & Bath</td>
                                    <td class="p-2 border border-[#967524]">Homogeneous Tile</td>
                                    <td class="p-2 border border-[#967524]">Homogeneous Tile<br>Subway Tile</td>
                                    <td class="p-2 border border-[#967524]">Painted</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    name: "ServiceResidence",
};
</script>

<script setup lang="ts">
import fpbbg from '../../images/fpb_bg_blue.jpg';
</script>

<style scoped>
/* Extra Custom Shadow for More Depth */
img {
    filter: drop-shadow(10px 10px 20px rgba(0, 0, 0, 0.5));
}

@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}

/* Slide-Up Animation for Image (Appears First) */
.slide-up-image-enter-active,
.slide-up-image-appear-active {
    transition: opacity 1s ease-out, transform 1s ease-out;
}

.slide-up-image-enter-from,
.slide-up-image-appear-from {
    opacity: 0;
    transform: translateY(80px);
}

.slide-up-image-enter-to,
.slide-up-image-appear-to {
    opacity: 1;
    transform: translateY(0);
}

/* Slide-Up Animation for Text (Delayed by 0.5s) */
.slide-up-text-enter-active,
.slide-up-text-appear-active {
    transition: opacity 1s ease-out, transform 1s ease-out;
    transition-delay: 0.5s;
    /* Staggered effect */
}

.slide-up-text-enter-from,
.slide-up-text-appear-from {
    opacity: 0;
    transform: translateY(80px);
}

.slide-up-text-enter-to,
.slide-up-text-appear-to {
    opacity: 1;
    transform: translateY(0);
}
</style>
