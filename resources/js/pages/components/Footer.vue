<template>
  <footer class="bg-[#1a2a56] text-white pt-9 pb-12 relative">
    <div class="max-w-screen-lg mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
      
      <!-- Section 1: Company Logos -->
      <div class="flex flex-col items-center">
        <!-- Large Centered Logo -->
        <div>
          <img src="../../images/logos1.png" alt="Main Logo" 
               class="w-40 sm:w-52 h-auto object-contain transition-transform duration-300 hover:scale-105 hover:brightness-110">
        </div>

        <!-- Responsive Logos -->
        <div class="flex xl:flex-row flex-col justify-center xl:space-x-6 space-y-6 xl:space-y-0">
          <img src="../../images/logos2.png" alt="Logo 2" 
               class="w-28 sm:w-32 h-auto object-contain transition duration-300 hover:scale-105 hover:brightness-110">
          <img src="../../images/logos3.png" alt="Logo 3" 
               class="w-28 sm:w-32 h-auto object-contain transition duration-300 hover:scale-105 hover:brightness-110">
          <img src="../../images/logos4.png" alt="Logo 4" 
               class="w-28 sm:w-32 h-auto object-contain transition duration-300 hover:scale-105 hover:brightness-110">
        </div>
      </div>

      <!-- Section 2: Site Map -->
      <div class="flex flex-col items-center">
        <h3 class="text-2xl font-semibold mb-4">Site Map</h3>
        <ul class="space-y-2">
          <li><a href="/" class="text-white hover:underline">Home</a></li>
          <li><a href="/about" class="text-white hover:underline">About Us</a></li>
          <li><a href="/citadines" class="text-white hover:underline">Citadines</a></li>
          <li><a href="/#" class="text-white hover:underline">Southwoods Binan</a></li>
          <li><a href="/contact" class="text-white hover:underline">Contact Us</a></li>
        </ul>
      </div>

      <!-- Section 3: Contact Us -->
      <div class="flex flex-col items-center">
        <h3 class="text-2xl font-semibold mb-4">Contact Us</h3>
        <p class="text-md">
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
          <a href="#" class="text-white text-2xl transition-colors duration-300 hover:text-[#E4405F]">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="text-white text-2xl transition-colors duration-300 hover:text-[#1877F2]">
            <i class="fab fa-facebook"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Messenger Chat Button -->
    <a href="https://m.me/yourpage" target="_blank"
      class="fixed bottom-6 right-6 bg-[#0084FF] text-white p-4 rounded-full shadow-lg transition-transform duration-300 hover:scale-110 hover:bg-[#006AFF]">
      <i class="fab fa-facebook-messenger text-3xl"></i>
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
