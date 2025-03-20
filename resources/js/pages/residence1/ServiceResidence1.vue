<template>
    <div class="bg-[#8B7355] flex flex-col md:flex-row items-center justify-center min-h-screen p-2 lg:p-6">

        <!-- Left Section: Heading & Image -->
        <div class="flex flex-col items-center md:items-start">
            <transition name="slide-up-text" appear>
                <h2 class="text-4xl sm:text-5xl font-serif mb-12 text-center md:text-left text-white">
                    Serviced Residence <br />
                    Studio Unit
                </h2>
            </transition>

            <transition name="slide-up-image" appear>
                <div class="w-full md:w-auto flex justify-center">
                    <img src="../../images/SRunit1.jpg" alt="Studio Floor Plan"
                        class="shadow-2xl drop-shadow-lg w-[80%] sm:w-[70%] md:w-auto max-w-[250px] sm:max-w-[300px] md:max-w-none mt-0 sm:mt-12">
                </div>
            </transition>
        </div>


        <!-- Information Section with Slide-Up Transition -->
        <transition name="slide-up-text" appear>
            <div class="w-full md:w-2/3 text-white md:pl-10 py-10 text-center md:text-right">
                <table class="border-4 border-black w-full text-left font-cormorant mb-6 text-sm sm:text-base">
                    <tbody>
                        <tr class="border border-black">
                            <td class="p-2 sm:p-3 border border-black w-1/3 text-2xl">Size Range</td>
                            <td class="p-2 sm:p-3 text-center text-2xl">24.85 – 32.5 sqm</td>
                        </tr>
                        <tr class="border border-black">
                            <td class="p-2 sm:p-3 border border-black w-1/3 text-2xl">Price Range</td>
                            <td class="p-2 sm:p-3 text-center text-2xl">6.9M – 9M</td>
                        </tr>
                    </tbody>
                </table>
                <div class="overflow-x-auto">
                    <table
                        class="border-4 border-black w-full text-left font-cormorant mb-6 text-xs sm:text-sm md:text-base">
                        <thead>
                            <tr class="border border-black text-white">
                                <th colspan="4" class="pl-2 text-xl md:text-2xl lg:text-3xl p-3">Unit Deliverables</th>
                            </tr>
                            <tr class="border border-black text-center h-10 md:h-12 lg:h-16">
                                <th class="text-base md:text-lg lg:text-2xl border border-black"></th>
                                <th class="text-base md:text-lg lg:text-2xl border border-black">Floor</th>
                                <th class="text-base md:text-lg lg:text-2xl border border-black">Wall</th>
                                <th class="text-base md:text-lg lg:text-2xl border border-black">Ceiling</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr class="border border-black text-sm sm:text-base md:text-lg">
                                <td class="p-2 sm:p-3 border border-black font-semibold">Living / Dining</td>
                                <td class="p-2 border border-black">Laminated Flooring</td>
                                <td class="p-2 border border-black">Painted</td>
                                <td class="p-2 border border-black">Painted</td>
                            </tr>
                            <tr class="border border-black text-sm sm:text-base md:text-lg">
                                <td class="p-2 sm:p-3 border border-black font-semibold">Kitchen</td>
                                <td class="p-2 border border-black">Homogeneous Tile</td>
                                <td class="p-2 border border-black">Quartz <br>(Natural Stone)</td>
                                <td class="p-2 border border-black">Painted</td>
                            </tr>
                            <tr class="border border-black text-sm sm:text-base md:text-lg">
                                <td class="p-2 sm:p-3 border border-black font-semibold">Bedrooms</td>
                                <td class="p-2 border border-black">Laminated Flooring</td>
                                <td class="p-2 border border-black">Painted</td>
                                <td class="p-2 border border-black">Painted</td>
                            </tr>
                            <tr class="border border-black text-sm sm:text-base md:text-lg">
                                <td class="p-2 sm:p-3 border border-black font-semibold">Toilet & Bath</td>
                                <td class="p-2 border border-black">Homogeneous Tile</td>
                                <td class="p-2 border border-black">Homogeneous Tile<br>Subway Tile</td>
                                <td class="p-2 border border-black">Painted</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </transition>
    </div>
</template>

<script lang="ts">
export default {
    name: "ServiceResidence",
};
</script>

<style scoped>
/* Extra Custom Shadow for More Depth */
img {
    filter: drop-shadow(10px 10px 20px rgba(0, 0, 0, 0.5));
}

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
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
