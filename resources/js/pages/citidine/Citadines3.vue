<template>
    <div class="w-full h-fit bg-white flex justify-center pb-8 px-2 md:px-3 lg:px-4">
        <div class="w-full h-fit bg-green-900 flex justify-center pt-4 lg:pt-8 px-3 md:px-4 lg:px-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
            :class="{ 'fade-in': isImageVisible }">

            <div class="relative w-full h-fit bg-[#1c2852] pb-12 -bottom-3">
                <h2 ref="textRef"
                    class="relative text-3xl md:text-4xl lg:text-5xl font-cormorant px-6 -top-4 lg:-top-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': isTextVisible }">
                    Contact Us
                </h2>

                <div class="flex items-center justify-center flex-col lg:flex-row">
                    <!-- Image Section -->
                    <div ref="imageRef"
                        class="px-4 md:px-6 lg:px-8 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                        :class="{ 'fade-in': isImageVisible }">
                        <img src="../../images/Cerise.png"
                            class="w-[300px] md:w-[450px] lg:w-[600px] h-[200px] md:h-[300px] lg:h-[400px] rounded-lg">
                    </div>

                    <!-- Form Section -->
                    <div>
                        <form
                            class="flex flex-col space-y-4 px-6 lg:px-10 py-8 lg:py-10 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                            :class="{ 'fade-in': isTextVisible }" @submit.prevent="saveContactUs()">

                            <!-- Name Field -->
                            <div>
                                <label class="text-white text-xl font-cormorant">Name</label>
                                <input type="text" v-model="form.name"
                                    class="w-full border border-gray-200 rounded-lg p-2 text-black"
                                    placeholder="Juan Dela Cruz jr.">
                                <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="text-white text-xl font-cormorant">Email</label>
                                <input type="email" v-model="form.email"
                                    class="w-full border border-gray-200 rounded-lg p-2 text-black"
                                    placeholder="example@gmail.com">
                                <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
                            </div>

                            <!-- Contact & Unit Type -->
                            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                                <!-- Contact Field -->
                                <div class="w-full md:w-1/2">
                                    <label class="text-white text-xl font-cormorant">Contact</label>
                                    <input type="text" v-model="form.cont_no"
                                        class="w-full border border-gray-200 rounded-lg p-2 text-black"
                                        placeholder="0987654321" maxlength="11" @input="formatContactNumber">
                                    <div v-if="form.errors.cont_no" class="text-red-500">{{ form.errors.cont_no }}</div>

                                </div>

                                <!-- Unit Type Dropdown -->
                                <div class="w-full md:w-1/2">
                                    <label class="text-white text-xl font-cormorant">Unit type</label>
                                    <select v-model="form.unit_type"
                                        class="w-full border border-gray-200 rounded-lg p-2 text-black">
                                        <option value="" selected disabled hidden>Select a unit type</option>
                                        <option value="penthouse">Penthouse</option>
                                        <option value="apartment">Apartment</option>
                                        <option value="condo">Condo</option>
                                    </select>
                                    <div v-if="form.errors.unit_type" class="text-red-500">{{ form.errors.unit_type }}
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" :disabled="form.processing"
                                class="w-full bg-[#A69379] text-white text-lg font-semibold py-2 rounded-lg hover:bg-opacity-80 transition">
                                <span v-if="form.processing">Please wait to submit...</span>
                                <span v-else>Submit</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import ame2 from '../../images/ame3.jpg';

defineProps({
    errors: Object
})

const form = useForm({
    name: '',
    email: '',
    cont_no: '',
    unit_type: '',
});

const formatContactNumber = () => {
    // Remove all non-numeric characters
    form.cont_no = form.cont_no.replace(/\D/g, '');

    // If input is empty, leave it blank
    if (form.cont_no === '') return;

    // If user starts with "0", keep it
    if (form.cont_no.startsWith('0')) {
        form.cont_no = form.cont_no.slice(0, 11); // Limit to 11 digits
    } else {
        // If user starts with another digit, prepend "0"
        form.cont_no = '0' + form.cont_no.slice(0, 10);
    }
};



const saveContactUs = async () => {
    await form.post(route('contact_us.store'), {
        onSuccess: () => {
            form.reset();

            // Show SweetAlert2 notification
            Swal.fire({
                title: 'Success!',
                text: 'Your message has been sent successfully.',
                icon: 'success',
                confirmButtonColor: '#A69379',
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Something went wrong',
                text: 'Please check and correct your information below',
                imageUrl: ame2,
                imageWidth: 80,
                imageHeight: 80,
                background: '#f4f4f4',
                confirmButtonText: 'Back',
                confirmButtonColor: '#A69379',
            });
        }
    });
};


// Intersection Observer for Animations
const isImageVisible = ref(false);
const isTextVisible = ref(false);
const imageRef = ref<HTMLElement | null>(null);
const textRef = ref<HTMLElement | null>(null);

const handleIntersection = (entries: IntersectionObserverEntry[]) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            if (entry.target === imageRef.value) {
                isImageVisible.value = true;
            }
            if (entry.target === textRef.value) {
                isTextVisible.value = true;
            }
        }
    });
};

onMounted(() => {
    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.3 });

    if (imageRef.value) observer.observe(imageRef.value);
    if (textRef.value) observer.observe(textRef.value);
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
