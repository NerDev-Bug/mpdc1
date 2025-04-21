<template>
    <div class="relative min-h-screen flex items-center justify-center px-4">
        <!-- Background Image Container -->
        <div class="absolute inset-0 bg-cover bg-center backdrop-blur-2xl"
            :style="{ backgroundImage: `url(${bgImage})` }"></div>

        <!-- Separate Black Overlay -->
        <div class="absolute inset-0"></div>

        <!-- Form Container -->
        <div
            class="relative bg-white w-full max-w-sm md:max-w-2xl lg:max-w-4xl rounded-2xl shadow-xl overflow-hidden z-20">
            <div class="bg-gray-900 px-6 md:px-10 py-6 md:py-12 text-center">
                <h2 ref="textSection"
                    class="text-white text-xl md:text-2xl font-montserrat font-bold mb-4 md:mb-6 opacity-0 translate-y-10 transition-all duration-700 ease-out"
                    :class="{ 'fade-in': textVisible }">
                    For accreditation assistance, book a private call with us!
                </h2>
            </div>
            <div class="p-6 md:p-8">
                <form class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6" @submit.prevent="submitForm">
                    <!-- Left Section -->
                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1" for="first_name">First
                                Name</label>
                            <input id="first_name" v-model="form.first_name" type="text" placeholder="Juan"
                                class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md transition"
                                @input="form.first_name = capitalizeFirstLetter(form.first_name)"
                                @keydown="preventNumbers"
                                required />
                            <div v-if="form.errors.first_name" class="text-red-400 mt-1 text-xs">{{
                                form.errors.first_name }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1" for="last_name">Last
                                Name</label>
                            <input id="last_name" v-model="form.last_name" type="text" placeholder="Dela Cruz"
                                class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md transition"
                                @input="form.last_name = capitalizeFirstLetter(form.last_name)"
                                @keydown="preventNumbers"
                                required  />
                            <div v-if="form.errors.last_name" class="text-red-400 mt-1 text-xs">{{ form.errors.last_name
                                }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1" for="email">Email</label>
                            <input id="email" v-model="form.email" type="email" placeholder="example@gmail.com"
                                class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md transition"
                                required  />
                            <div v-if="form.errors.email" class="text-red-400 mt-1 text-xs">{{ form.errors.email }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1" for="contact">Contact
                                Number</label>
                            <input id="contact" v-model="form.contact_number" inputmode="numeric" type="text" placeholder="+63"
                                class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md transition"
                                maxlength="11" @input="formatContactNumber"
                                required />
                            <div v-if="form.errors.contact_number" class="text-red-400 mt-1 text-xs">{{
                                form.errors.contact_number }}</div>
                        </div>
                    </div>
                    <!-- Right Section -->
                    <div class="space-y-4 md:space-y-6">
                        <div class="relative">
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Pick a Date</label>
                            <Datepicker v-model="selectedDate" :min-date="today" placeholder="Select a date"
                                :enable-time-picker="false" :auto-apply="true" teleport="body"
                                class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md transition"
                                required />
                            <div v-if="form.errors.date" class="text-red-400 mt-1 text-xs">{{ form.errors.date }}</div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Pick a Time</label>
                            <input type="time" v-model="selectedTime"
                                class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-md transition"
                                required />
                            <div v-if="form.errors.time" class="text-red-400 mt-1 text-xs">{{ form.errors.time }}</div>
                        </div>
                        <div class="pt-2">
                            <button type="submit" :disabled="form.processing"
                                :style="{ backgroundImage: `url(${goldbutton})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
                                class="text-xl w-full text-black font-montserrat font-semibold py-2 rounded-lg shadow-md shadow-black/50 transition-transform transform hover:scale-105">
                                <span v-if="form.processing">Please wait to submit...</span>
                                <span v-else>Book a Call!</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>



<script setup lang="ts">
import bgImage from '../../images/goldbg_fpb.jpg';
import { ref, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import goldbutton from '../../images/goldbutton34.jpg';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    contact_number: '',
    date: '',
    time: '',
    errors: {
        first_name: '',
        last_name: '',
        email: '',
        contact_number: '',
        date: '',
        time: ''
    }
});

const capitalizeFirstLetter = (text: string) => {
    return text.replace(/\b\w/g, char => char.toUpperCase());
};


const selectedDate = ref<Date | null>(null);
const selectedTime = ref('');
const today = new Date();

watch(selectedDate, (newDate) => {
    if (newDate) {
        form.date = newDate.toISOString().split("T")[0];
        form.errors.date = '';
    }
});

watch(selectedTime, (newTime) => {
    if (newTime) {
        form.time = newTime.length === 5 ? `${newTime}:00` : newTime;
        form.errors.time = '';
    }
});

const formatContactNumber = () => {
    let number = form.contact_number.replace(/\D/g, '').slice(0, 11);
    if (number && number[0] !== '0') {
        number = '0' + number;
    }
    form.contact_number = number;
    form.errors.contact_number = '';
};

watch(() => form.first_name, (newValue) => {
    if (newValue) form.errors.first_name = '';
});

watch(() => form.last_name, (newValue) => {
    if (newValue) form.errors.last_name = '';
});

watch(() => form.email, (newValue) => {
    if (newValue) form.errors.email = '';
});

watch(() => form.contact_number, (newValue) => {
    if (newValue) form.errors.contact_number = '';
});

const validateForm = () => {
    let isValid = true;

    if (!form.first_name) {
        form.errors.first_name = 'First name is required';
        isValid = false;
    }
    if (!form.last_name) {
        form.errors.last_name = 'Last name is required';
        isValid = false;
    }
    if (!form.email) {
        form.errors.email = 'Email is required';
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        form.errors.email = 'Invalid email format';
        isValid = false;
    }
    if (!form.contact_number) {
        form.errors.contact_number = 'Contact number is required';
        isValid = false;
    } else if (!/^\d{10,}$/.test(form.contact_number)) {
        form.errors.contact_number = 'Invalid contact number';
        isValid = false;
    }
    if (!form.date) {
        form.errors.date = 'Please select a date';
        isValid = false;
    }
    if (!form.time) {
        form.errors.time = 'Please select a time';
        isValid = false;
    }
    return isValid;
};


const submitForm = async () => {
    if (!validateForm()) return;
    await form.post(route("table_booking.store"), {
        onSuccess: () => {
            form.reset();
            selectedDate.value = null;
            selectedTime.value = '';
            Swal.fire({ title: "Success!", text: "Your request has been submitted.", icon: "success" });
        },
        onError: () => {
            Swal.fire({ title: "Error", text: "Check your information.", icon: "error" });
        },
    });
};

const textVisible = ref(false);
const imageVisible = ref(false);
const textSection = ref(null);
const imageSection = ref(null);

onMounted(() => {
    const observerOptions = { threshold: 0.5 };
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target === textSection.value) textVisible.value = true;
                else if (entry.target === imageSection.value) imageVisible.value = true;
            }
        });
    }, observerOptions);
    if (textSection.value) observer.observe(textSection.value);
    if (imageSection.value) observer.observe(imageSection.value);
});
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

.opacity-0 {
    opacity: 0;
    transform: translateY(20px);
}

.fade-in {
    opacity: 1;
    transform: translateY(0);
}

nav {
    z-index: 1050 !important;
    position: relative;
}

::v-deep(.dp__outer_menu_wrap) {
    z-index: 9999 !important;
}
</style>
