<template>
    <div class="bg-white w-full h-fit mt-4">
        <div class="bg-[#D9D9D9] w-full h-fit px-4 py-4">
            <h2 ref="textSection"
                class="text-black text-3xl font-cormorant font-semibold px-4 ml-12 mb-4 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                :class="{ 'fade-in': textVisible }">
                For accreditation assistance, book a private call with us!
            </h2>
            <div class="bg-[#575757] w-full h-fit">
                <div ref="imageSection"
                    class="w-full h-fit px-4 py-4 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': imageVisible }">
                    <form class="flex items-center justify-between flex-col md:flex-row">
                        <div class="w-full h-fit px-4 py-4 space-y-4 ">
                            <div>
                                <label class="text-black font-cormorant text-3xl font-semibold" for="name">Name</label>
                                <input id="name" type="text" placeholder="Enter your name"
                                    class="w-full p-2 rounded text-black font-semibold" />
                            </div>
                            <div>
                                <label class="text-black font-cormorant text-3xl font-semibold"
                                    for="email">Email</label>
                                <input id="email" type="email" placeholder="Enter your email"
                                    class="w-full p-2 rounded text-black font-semibold" />
                            </div>
                            <div>
                                <label class="text-black font-cormorant text-3xl font-semibold" for="contact">Contact
                                    Number</label>
                                <input id="contact" type="text" placeholder="Enter your contact number"
                                    class="w-full p-2 rounded text-black font-semibold" />
                            </div>
                            <div class="text-right text-2xl font-semibold pt-4">
                                <button
                                    class="bg-gray-300 w-full lg:w-1/3 h-[50px] text-black font-cormorant px-4 py-2 rounded">Book
                                    a call!</button>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center px-4 mr-2">
                            <label
                                class="font-cormorant text-2xl lg:text-3xl text-black font-semibold text-center mb-2">Pick
                                a
                                time and
                                date</label>
                            <div class="w-full md:[250px] lg:w-[400px]">
                                <Datepicker v-model="selectedDate" inline auto-apply :enable-time-picker="false"
                                    class="flex items-center justify-center w-full p-4 rounded-lg" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const selectedDate = ref(null);

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
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
}

.opacity-0 {
    opacity: 0;
    transform: translateY(20px);
}

.fade-in {
    opacity: 1;
    transform: translateY(0);
}
</style>
