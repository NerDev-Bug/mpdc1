<template>
    <footer class="bg-[#1a2a56] text-white pt-9 pb-12 relative">
        <div class="max-w-screen-lg mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-20 text-center">

            <!-- Section 1: Company and partner marks -->
            <div class="flex flex-col items-center mt-[-20px]">
                <p class="sr-only">Malveda Properties and Development Corporation and partner organizations</p>
                <div class="grid grid-cols-2 gap-6 max-w-[350px] mx-auto">
                    <img src="../../images/logos2.png" alt="" width="1080"
                        height="1080" loading="lazy" decoding="async"
                        class="w-28 sm:w-32 h-28 sm:h-32 object-contain transition duration-300 hover:scale-105 hover:brightness-110">
                    <img src="../../images/logos3.png" alt="Malveda Properties and Development Corporation" width="1830"
                        height="436" loading="lazy" decoding="async"
                        class="w-28 sm:w-32 h-28 sm:h-32 object-contain transition duration-300 hover:scale-105 hover:brightness-110">
                    <img src="../../images/logos4.png" alt="" width="2000"
                        height="2000" loading="lazy" decoding="async"
                        class="w-28 sm:w-32 h-28 sm:h-32 object-contain transition duration-300 hover:scale-105 hover:brightness-110">
                    <img src="../../images/logos1.png" alt="" width="6938"
                        height="2933" loading="lazy" decoding="async"
                        class="w-28 sm:w-32 h-28 sm:h-32 object-contain transition duration-300 hover:scale-105 hover:brightness-110">
                </div>
            </div>


            <!-- Section 2: Site Map -->
            <div class="flex flex-col items-center">
                <h3 class="text-2xl font-semibold mb-4">Site Map</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="text-white hover:underline">Home</a></li>
                    <li><a href="/about" class="text-white hover:underline">About Us</a></li>
                    <li><a href="/citadines" class="text-white hover:underline">Citadines Southwoods Biñan</a></li>
                    <li><a href="/location" class="text-white hover:underline">Location</a></li>
                    <li><a href="/amenities" class="text-white hover:underline">Amenities</a></li>
                    <li><a href="/serviced-residence" class="text-white hover:underline">Serviced Residences</a></li>
                    <li><a href="/private-residence" class="text-white hover:underline">Private Residences</a></li>
                    <li><a href="/for-partners-and-brokers" class="text-white hover:underline">Partners and Brokers</a></li>
                    <li><a href="/news" class="text-white hover:underline">News and Updates</a></li>
                    <li><a href="/contact-us" class="text-white hover:underline">Contact Us</a></li>
                    <li><a href="/data-privacy" class="text-white hover:underline">Data Privacy</a></li>
                </ul>
            </div>

            <!-- Section 3: Contact Us -->
            <div class="flex flex-col items-center">
                <h3 class="text-2xl font-semibold mb-4">Contact Us</h3>
                <p class="text-[14px]">
                    <a href="mailto:inquiries@malvedaproperties.com" class="text-white hover:underline">
                        inquiries@malvedaproperties.com
                    </a>
                </p>
                <p class="text-md">
                    <a href="tel:+639175150123" class="text-white hover:underline">
                        0917 – 515 – 0123
                    </a>
                </p>
                <div class="flex justify-center space-x-6 mt-4">
                    <a href="https://www.instagram.com/thecerisetower?igsh=MXgxc2c1NHk2MXg4bg==" target="_blank"
                        rel="noopener noreferrer"
                        aria-label="The Cerise Tower on Instagram"
                        class="text-white text-2xl transition-colors duration-300 hover:text-[#E4405F]">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.facebook.com/cerisetower/" target="_blank" rel="noopener noreferrer"
                        aria-label="The Cerise Tower on Facebook"
                        class="text-white text-2xl transition-colors duration-300 hover:text-[#1877F2]">
                        <i class="fab fa-facebook" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Messenger Chat Button -->
        <a href="https://m.me/686792135038592" target="_blank" rel="noopener noreferrer"
            aria-label="Chat with MPDC on Messenger"
            class="fixed bottom-6 right-6 bg-[#11385c] text-white p-4 rounded-full shadow-lg transition-transform duration-300 hover:scale-110 hover:bg-[#006AFF]">
            <i class="fab fa-facebook-messenger text-3xl" aria-hidden="true"></i>
        </a>
    </footer>
</template>

<style scoped>
/* Force stacking below 1060px */
@media (max-width: 1059px) {
    .logos-container {
        flex-direction: column !important;
        align-items: center;
    }

    .logos-container img {
        margin-bottom: 10px;
    }
}
</style>
