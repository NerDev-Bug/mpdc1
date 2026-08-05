<template>
    <div class="relative w-full h-fit py-12 px-6 md:px-16"
        :style="{ backgroundImage: `url(${heroImage})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
        <!-- Title -->
        <h2 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold font-montserrat mb-6 text-left">
            Our partners
        </h2>
        <!-- Partner Logos -->
        <div class="flex flex-col items-center space-y-6">
            <div class="flex flex-wrap justify-center items-center gap-20">
                <img src="../../images/logos5.png" alt="The Ascott Limited" width="2000" height="2000"
                    loading="lazy" decoding="async" class="w-64 h-85 object-contain">
                <img src="../../images/logo.png" alt="Malveda Properties and Development Corporation" width="1830"
                    height="436" loading="lazy" decoding="async" class="w-64 h-32 object-contain">
            </div>
        </div>


        <!-- Two-Column Content (Tightly Packed) -->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 mt-6">
            <!-- Left: Text Section (No Gap) -->
            <div class="bg-[#1E3A5F] bg-opacity-40 text-white p-4 md:p-6 flex items-center">
                <p class="text-xl md:text-xl leading-tight">
                    Malveda Properties and Development Corporation has established a strategic partnership with a leading
                    global hotel operator.

                    Our collaboration with The Ascott Limited, a highly respected name in the real estate and hospitality
                    industries, underscores our steadfast commitment to delivering exceptional service standards and
                    providing incomparable experiences for our clients.

                    This collaboration reflects our dedication to excellence and positions us as a key player in
                    providing premium property investment.
                </p>
            </div>

            <!-- Right: Image Section (No Gap) -->
            <div class="w-full">
                <img src="../../images/mate1.jpg"
                    alt="MPDC and The Ascott Limited representatives formalizing their partnership" width="638"
                    height="359" loading="lazy" decoding="async" class="w-full object-cover h-full">
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import heroImage from '../../images/bgwave.jpg';
</script>

<style scoped>
.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}
</style>
