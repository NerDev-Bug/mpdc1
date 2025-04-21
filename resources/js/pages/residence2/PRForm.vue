<template>
    <div class="w-full flex justify-center">
        <!-- Button to open modal -->
        <button @click="openModal"
            class="text-black font-montserrat text-lg font-semibold py-3 px-6 rounded-lg hover:bg-opacity-80 transition"
            :style="{ backgroundImage: `url(${goldbutton})`, backgroundSize: 'cover', backgroundPosition: 'center' }">
            REQUEST COMPUTATIONS
        </button>
    </div>

    <!-- Modal Overlay -->
    <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <!-- Modal Box -->
<div
    class="bg-white w-[95%] sm:w-[90%] md:w-[500px] p-4 sm:p-6 rounded-lg shadow-lg relative max-h-[90vh] overflow-y-auto"
    @click.stop>

            <!-- Close Button -->
            <button
    class="absolute top-4 right-2 text-gray-700 text-4xl w-12 h-12 flex items-center justify-center rounded-full hover:text-black hover:bg-gray-200 transition"
    @click="closeModal">
    &times;
</button>

            <!-- Modal Title -->
            <h2 class="text-2xl font-semibold text-center mb-4">Request for an Computations</h2>

            <!-- Form -->
            <form @submit.prevent="saveInquiry()">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-700">First Name*</label>
                        <input v-model="form.first_name" type="text"
                            class="w-full border border-gray-300 rounded-lg p-2 text-gray-900 bg-white"
                            @input="form.first_name = capitalizeFirstLetter(form.first_name)" placeholder="Juan"
                            @keydown="preventNumbers"
                            required>
                    </div>
                    <div>
                        <label class="text-gray-700">Last Name*</label>
                        <input v-model="form.last_name" type="text"
                            class="w-full border border-gray-300 rounded-lg p-2 text-gray-900 bg-white"
                            @input="form.last_name = capitalizeFirstLetter(form.last_name)" placeholder="Dela Cruz"
                            @keydown="preventNumbers"
                            required>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-gray-700">Email*</label>
                    <input v-model="form.email" type="email"
                        class="w-full border border-gray-300 rounded-lg p-2 text-gray-900 bg-white"
                        placeholder="example@gmail.com" required>
                </div>

                <div class="mt-4">
                    <label class="text-gray-700">Contact No.*</label>
                    <input v-model="form.contact" type="text" @input="validateContact"
                        class="w-full border border-gray-300 rounded-lg p-2 text-gray-900 bg-white" placeholder="+63"
                        required>
                </div>

                <div class="mt-4">
                    <label class="text-gray-700 font-semibold">Unit Type*</label>
                    <select v-model="form.unit_type"
                        class="w-full border border-gray-400 rounded-lg p-3 text-gray-900 bg-white focus:ring-2 focus:ring-black focus:outline-none"
                        required>
                        <option value="" selected disabled class="text-gray-500">— Please choose an option —</option>
                        <option value="Studio Unit">Studio Unit</option>
                        <option value="1-Bedroom">1-Bedroom</option>
                        <option value="2-Bedroom">2-Bedroom</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="text-gray-700">Message*</label>
                    <textarea v-model="form.message"
                        class="w-full border border-gray-300 rounded-lg p-2 h-20 text-gray-900 bg-white"
                        placeholder="Enter your message"></textarea>
                </div>

                <div class="mt-4 flex items-start">
                    <input v-model="form.agree_to_privacy" type="checkbox" id="privacyPolicy" class="mr-2" required>
                    <label for="privacyPolicy" class="text-sm text-gray-600">
                        I agree to receive communications and have read the
                        <a href="https://privacy.gov.ph/data-privacy-act/" target="_blank"
                            class="text-blue-600 underline">Data Privacy Policy</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-[#5c503f] text-white text-lg font-semibold py-3 rounded-lg
           hover:opacity-100 hover:bg-[#4b4235] transition
           disabled:opacity-80 disabled:cursor-not-allowed" :disabled="!form.agree_to_privacy || form.processing">
                        <span v-if="form.processing">Please wait to submit...</span>
                        <span v-else>Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2'; // Import SweetAlert2
import goldbutton from '../../images/goldbutton34.jpg';

const capitalizeFirstLetter = (text: string) => {
    return text.replace(/\b\w/g, char => char.toUpperCase());
};


const isModalOpen = ref(false);

// Form state
const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    contact: '',
    unit_type: '',
    message: '',
    agree_to_privacy: false,
    processing: false
});

const openModal = () => {
    isModalOpen.value = true;
    window.dispatchEvent(new Event('modal-opened'));
};

const closeModal = () => {
    isModalOpen.value = false;
    window.dispatchEvent(new Event('modal-closed'));
    resetForm();
};


// Function to reset the form
const resetForm = () => {
    form.value = {
        first_name: '',
        last_name: '',
        email: '',
        contact: '',
        unit_type: '',
        message: '',
        agree_to_privacy: false,
        processing: false
    };
};

const errors = ref({
    first_name: '',
    last_name: '',
    email: '',
    contact: '',
    unit_type: '',
    message: ''
});

const hasErrors = computed(() => Object.values(errors.value).some(error => error));

const validateForm = () => {
    errors.value.first_name = form.value.first_name ? '' : 'First name is required.';
    errors.value.last_name = form.value.last_name ? '' : 'Last name is required.';
    errors.value.email = form.value.email && /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(form.value.email)
        ? ''
        : 'Valid email is required.';
    errors.value.contact = form.value.contact.length >= 10
        ? ''
        : 'Contact number must be at least 10 digits.';
    errors.value.unit_type = form.value.unit_type ? '' : 'Unit type is required.';
    errors.value.message = form.value.message ? '' : 'Message is required.';
};

const validateContact = () => {
    let contact = form.value.contact.replace(/[^0-9]/g, ''); // Remove non-numeric characters

    if (contact.length > 0 && contact[0] !== '0') contact = '0' + contact; // Ensure it starts with 0
    form.value.contact = contact.slice(0, 11); // Limit to 11 digits

    if (contact.length < 10) {
        errors.value.contact = 'Contact number must be at least 10 digits.';
    } else {
        errors.value.contact = '';
    }
};

const saveInquiry = async () => {
    validateForm();
    if (hasErrors.value) return;
    form.value.processing = true; // Set processing to true when submitting

    router.post(route('inquiry1s.store'), form.value, {
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Your inquiry has been submitted successfully.',
                icon: 'success',
                confirmButtonColor: '#A69379'
            });
            closeModal();
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
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}
/* Smooth fade-in animation */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>
