<template>
    <AppLayout>
        <div>
            <!-- Hero Image -->
            <div class="w-full h-fit px-4 bg-cover bg-center relative"
                :style="{ backgroundImage: `url(${heroImage})` }">
                <!-- Add an overlay if needed -->
                <!-- <div class="absolute inset-0 bg-black/30"></div> -->
                <div class="w-full h-fit py-12 flex items-center justify-center flex-col">
                    <div class="mt-24">
                        <h2 class="text-[#1C2852] text-4xl font-montserrat font-semibold">Contact Us</h2>
                    </div>
                    <div class="w-full h-fit py-4 px-4 lg:px-12 mt-4 flex flex-col lg:flex-row justify-center gap-6">
                        <div class="w-full h-fit flex items-center justify-center">
                            <img src="../../images/lobbypic1.jpg" alt="Selfie" class="max-w-full h-fit rounded-3xl">
                        </div>
                        <div class="w-full h-fit">
                            <form @submit.prevent="submitForm" class="space-y-4">
                                <!-- Inquiry Type -->
                                <div>
                                    <label class="block text-[#1C2852] text-[20px] font-medium">Inquiry Type</label>
                                    <select v-model="form.inquiry_type"
                                        class="w-full border border-black p-2 rounded focus:ring focus:ring-blue-300 text-black"
                                        required>
                                        <option value="" selected disabled class="text-gray-500">— Please choose an
                                            option —</option>
                                        <option>Individual</option>
                                        <option>Business</option>
                                    </select>
                                </div>

                                <!-- Name Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[#1C2852] text-[20px] font-medium">First Name</label>
                                        <input v-model="form.first_name" type="text"
                                            class="w-full border border-black p-2 rounded focus:ring focus:ring-blue-300 text-black"
                                            placeholder="Juan"
                                            @input="form.first_name = capitalizeFirstLetter(form.first_name)"
                                            @keydown="preventNumbers"
                                            required />
                                        <p v-if="errors.firstName" class="text-red-500 text-sm">{{ errors.firstName }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-[#1C2852] text-[20px] font-medium">Last Name</label>
                                        <input v-model="form.last_name" type="text"
                                            class="w-full border border-black p-2 rounded focus:ring focus:ring-blue-300 text-black"
                                            placeholder="Dela Cruz"
                                            @input="form.last_name = capitalizeFirstLetter(form.last_name)"
                                            @keydown="preventNumbers"
                                            required />
                                        <p v-if="errors.lastName" class="text-red-500 text-sm">{{ errors.lastName }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Email -->
                                    <div>
                                        <label class="block text-[#1C2852] text-[20px] font-medium">Email</label>
                                        <input v-model="form.email" type="email"
                                            class="w-full border border-black p-2 rounded focus:ring focus:ring-blue-300 text-black"
                                            placeholder="example@gmail.com" required />
                                        <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</p>
                                    </div>

                                    <!-- Mobile Number with Country Code -->
                                    <div>
                                        <label class="block text-[#1C2852] text-[20px] font-medium">Mobile
                                            Number</label>
                                        <div
                                            class="flex items-center border border-black rounded focus-within:ring focus-within:ring-blue-300">
                                            <select v-model="form.country_code"
                                                class="bg-gray-100 p-2 border text-black" required>
                                                <option value="+63">+63 (PH)</option>
                                                <option value="+1">+1 (USA)</option>
                                                <option value="+44">+44 (UK)</option>
                                                <option value="+91">+91 (IN)</option>
                                                <option value="+81">+81 (JP)</option>
                                                <option value="+33">+33 (FR)</option>
                                                <option value="+49">+49 (DE)</option>

                                            </select>
                                            <input v-model="form.mobile" type="text"
                                                class="w-full p-2 border-black text-black"
                                                :placeholder="!hasTyped ? form.country_code : ''"
                                                @focus="if (!hasTyped) { form.mobile = ''; hasTyped = true; }"
                                                @input="validateMobileNumber()" required />

                                        </div>
                                    </div>
                                </div>

                                <!-- Project Inquiry -->
                                <div>
                                    <label class="block text-[#1C2852] text-[20px] font-medium">Project Inquired</label>
                                    <select v-model="form.project"
                                        class="w-full border border-black p-2 rounded focus:ring focus:ring-blue-300 text-black"
                                        required>
                                        <option value="" selected disabled class="text-gray-500">— Please choose an
                                            option —</option>
                                        <option value="Serviced Residences">Serviced Residences</option>
                                        <option value="Private Residences">Private Residences</option>
                                    </select>
                                    <p v-if="errors.project" class="text-red-500 text-sm">{{ errors.project }}</p>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-[#1C2852] text-[20px] font-medium">Description</label>
                                    <textarea v-model="form.description"
                                        class="w-full border border-black p-2 rounded focus:ring focus:ring-blue-300 text-black"
                                        rows="3" placeholder="Provide a brief description" required></textarea>
                                    <p v-if="errors.description" class="text-red-500 text-sm">{{ errors.description }}
                                    </p>
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" v-model="form.agree_terms" class="w-4 h-4" required />
                                    <label class="text-[#1C2852] text-[20px]">
                                        I agree to the <a href="#" class="text-blue-500">Terms and Conditions</a> and <a
                                            href="#" class="text-blue-500">Privacy Notice</a>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" :disabled="!form.agree_terms || form.processing"
                                        class="py-2 px-6 rounded-lg font-semibold transition duration-200" :class="{
                                            'bg-[#1C2852] hover:bg-[#1C2852] text-white': form.agree_terms && !form.processing,
                                            'bg-[#1C2852] cursor-not-allowed': !form.agree_terms
                                        }">
                                        <span v-if="form.processing">Please wait to submit...</span>
                                        <span v-else>Submit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add margin or padding to separate from the image -->
            <!-- <div class="bg-white">
        <ContactUs1 />

      </div> -->
        </div>
    </AppLayout>
</template>



<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import heroImage from '../../images/cs_mainlobby.jpg';
// import ContactUs1 from './ContactUs1.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const isImageVisible = ref(false);
const isTextVisible = ref(false);
const imageContainer = ref<HTMLElement | null>(null);
const textContainer = ref<HTMLElement | null>(null);

// Intersection Observer for smooth fade-in when scrolling
const handleIntersection = (entries: IntersectionObserverEntry[]) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            if (entry.target === imageContainer.value) {
                isImageVisible.value = true;
            }
            if (entry.target === textContainer.value) {
                isTextVisible.value = true;
            }
        }
    });
};

onMounted(() => {
    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.3 });

    if (imageContainer.value) observer.observe(imageContainer.value);
    if (textContainer.value) observer.observe(textContainer.value);
});

const capitalizeFirstLetter = (text: string) => {
    return text.replace(/\b\w/g, char => char.toUpperCase());
};


const form = useForm({
    inquiry_type: '',
    first_name: '',
    last_name: '',
    email: '',
    country_code: '+63',
    mobile: '',
    project: '',
    description: '',
    agree_terms: false,
});

const errors = ref<Record<string, string>>({});

const maxLengths: Record<string, number> = {
    '+63': 11, '+1': 11, '+44': 11, '+91': 11, '+81': 11, '+33': 10, '+49': 11
};

// Track whether the user has started typing
const hasTyped = ref(false);

// Validate and format mobile number
const validateMobileNumber = () => {
    // Remove non-numeric characters
    form.mobile = form.mobile.replace(/\D/g, '');

    const maxLength = maxLengths[form.country_code] || 10;

    // Ensure leading zero rule:
    if (form.mobile.length > 0 && form.mobile[0] !== '0') {
        form.mobile = '0' + form.mobile;
    }

    // Limit length based on country code
    form.mobile = form.mobile.slice(0, maxLength);

    // Ensure mobile number is at least 10 digits long
    if (form.mobile.length < 10) {
        errors.value.mobile = "Mobile number must be at least 10 digits.";
    } else {
        errors.value.mobile = ""; // Clear error if valid
    }
};

// Watch for country code changes
watch(() => form.country_code, (newCode, oldCode) => {
    if (!hasTyped.value || form.mobile === oldCode) {
        form.mobile = newCode; // Set initial country code as placeholder
        hasTyped.value = false; // Reset typing flag
    }
});

const validateForm = () => {
    errors.value = {};
    if (!form.first_name) errors.value.firstName = "First name is required.";
    if (!form.last_name) errors.value.lastName = "Last name is required.";
    if (!form.email || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(form.email)) errors.value.email = "Valid email is required.";
    if (!form.mobile || form.mobile === form.country_code) errors.value.mobile = "Mobile number is required.";
    if (!form.project) errors.value.project = "Please select a project.";
    if (!form.description) errors.value.description = "Description is required.";
    return Object.keys(errors.value).length === 0;
};

const submitForm = () => {
    if (!validateForm()) return; // Stop if validation fails

    form.post(route('contacts.store'), {
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Your inquiry has been submitted successfully.',
                icon: 'success',
                confirmButtonColor: '#A69379'
            });
            form.reset(); // Reset all form fields
            hasTyped.value = false; // Reset mobile input flag
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to submit inquiry.',
                icon: 'error',
                confirmButtonColor: '#A69379'
            });
        }
    });
};
const preventNumbers = (event: KeyboardEvent) => {
    const allowedKeys = [
        'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', 'Home', 'End'
    ];

    // Allow control keys
    if (allowedKeys.includes(event.key)) return;

    // Allow only letters and spaces
    if (!/^[a-zA-Z\s]$/.test(event.key)) {
        event.preventDefault();
    }
};
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
