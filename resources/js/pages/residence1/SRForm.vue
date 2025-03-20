<template>
    <div class="w-full flex justify-center py-8">
        <!-- Button to open modal -->
        <button @click="openModal"
            class="bg-[#A69379] text-white text-lg font-semibold py-3 px-6 rounded-lg hover:bg-opacity-80 transition">
            REQUEST COMPUTATION
        </button>
    </div>

    <!-- Modal Overlay -->
    <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <!-- Modal Box -->
        <div class="bg-white w-[90%] md:w-[600px] p-6 rounded-lg shadow-lg relative" @click.stop>
            <!-- Close Button -->
            <button
                class="absolute top-2 right-2 text-gray-700 text-3xl w-12 h-12 flex items-center justify-center rounded-full hover:text-black hover:bg-gray-200 transition"
                @click="closeModal">
                &times;
            </button>


            <!-- Modal Title -->
            <h2 class="text-2xl font-semibold text-center mb-4">Request for a Sample Computation</h2>

            <!-- Form -->
            <form @submit.prevent="submitForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-700">First Name*</label>
                        <input v-model="form.firstName" type="text"
                            class="w-full border border-gray-300 rounded-lg p-2 text-gray-900 bg-white"
                            placeholder="Juan" required>
                    </div>
                    <div>
                        <label class="text-gray-700">Last Name*</label>
                        <input v-model="form.lastName" type="text"
                            class="w-full border border-gray-300 rounded-lg p-2 text-gray-900 bg-white"
                            placeholder="Dela Cruz" required>
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
                        class="w-full border border-gray-300 rounded-lg p-2 text-gray-900 bg-white"
                        placeholder="0987654321" required>
                </div>


                <div class="mt-4">
                    <label class="text-gray-700 font-semibold">Unit Type*</label>
                    <select v-model="form.unitType"
                        class="w-full border border-gray-400 rounded-lg p-3 text-gray-900 bg-white focus:ring-2 focus:ring-black focus:outline-none"
                        required>
                        <option value="" selected disabled class="text-gray-500">— Please choose an option —</option>
                        <option value="penthouse">Penthouse</option>
                        <option value="apartment">Apartment</option>
                        <option value="condo">Condo</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="text-gray-700">Message*</label>
                    <textarea v-model="form.message"
                        class="w-full border border-gray-300 rounded-lg p-2 h-20 text-gray-900 bg-white"
                        placeholder="Enter your message"></textarea>
                </div>

                <div class="mt-4 flex items-start">
                    <input v-model="form.agreeToPrivacy" type="checkbox" id="privacyPolicy" class="mr-2" required>
                    <label for="privacyPolicy" class="text-sm text-gray-600">
                        I agree to receive communications and have read the
                        <a href="https://privacy.gov.ph/data-privacy-act/" target="_blank"
                            class="text-blue-600 underline">Data Privacy Policy</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-[#A69379] text-white text-lg font-semibold py-3 rounded-lg hover:bg-opacity-80 transition">
                        SUBMIT
                    </button>
                </div>
            </form>

        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const isModalOpen = ref(false);

// Form state
const form = ref({
    firstName: '',
    lastName: '',
    email: '',
    contact: '',
    unitType: '',
    message: '',
    agreeToPrivacy: false,
});

// Function to open the modal
const openModal = () => {
    isModalOpen.value = true;
};

// Function to close the modal and clear form fields
const closeModal = () => {
    isModalOpen.value = false;
    resetForm();
};

// Function to reset the form
const resetForm = () => {
    form.value = {
        firstName: '',
        lastName: '',
        email: '',
        contact: '',
        unitType: '',
        message: '',
        agreeToPrivacy: false,
    };
};

// Function to validate contact number input
const validateContact = () => {
    let contact = form.value.contact.replace(/[^0-9]/g, ''); // Remove non-numeric characters

    // If the first digit is not '0' and there is at least one digit, prepend '0'
    if (contact.length > 0 && contact[0] !== '0') {
        contact = '0' + contact;
    }

    form.value.contact = contact.slice(0, 12); // Limit to 12 digits
};

// Function to handle form submission
const submitForm = () => {
    alert("Form submitted!"); // Replace with actual logic
    closeModal();
};

</script>

<style scoped>
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
