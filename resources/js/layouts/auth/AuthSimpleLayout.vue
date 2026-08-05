<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import logo from '../../images/logo.png';
import heroImage from '../../images/homepage.jpg';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh">
        <!-- Left side - Background Image (hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <img :src="heroImage" alt="Malveda Properties" class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-br from-[#1f2455]/80 to-[#060e29]/90"></div>
            <div class="relative z-10 flex flex-col justify-between p-12 text-white">
                <div>
                    <Link :href="route('home')">
                        <img :src="logo" alt="MPDC Logo" class="h-12 w-auto" />
                    </Link>
                </div>
                <div class="text-sm text-white/50 font-montserrat">
                    &copy; {{ new Date().getFullYear() }} Malveda Properties. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right side - Form -->
        <div class="flex w-full lg:w-1/2 flex-col items-center justify-center bg-gradient-to-br from-[#0d1535] to-[#060e29] p-6 md:p-10 relative">
            <!-- Mobile logo -->
            <div class="lg:hidden mb-8">
                <Link :href="route('home')">
                    <img :src="logo" alt="MPDC Logo" class="h-14 w-auto mx-auto" />
                </Link>
            </div>

            <div class="w-full max-w-md">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 md:p-10 shadow-2xl">
                    <div class="flex flex-col items-center gap-2 mb-8">
                        <!-- Desktop logo inside card -->
                        <div class="hidden lg:block mb-2">
                            <Link :href="route('home')">
                                <img :src="logo" alt="MPDC Logo" class="h-10 w-auto" />
                            </Link>
                        </div>
                        <div class="space-y-2 text-center">
                            <h1 class="text-2xl font-bold text-white font-cormorant">{{ title }}</h1>
                            <p class="text-sm text-white/60 font-montserrat">{{ description }}</p>
                        </div>
                    </div>
                    <slot />
                </div>

                <!-- Back to home link -->
                <div class="mt-6 text-center">
                    <Link :href="route('home')" class="text-sm text-white/40 hover:text-white/70 transition-colors font-montserrat">
                        &larr; Back to website
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
}

.font-montserrat {
    font-family: 'Montserrat', sans-serif;
}
</style>
