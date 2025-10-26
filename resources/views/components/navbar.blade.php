<nav class="xl:block hidden bg-white border-b border-gray-200 fixed z-30 w-full">
  <div class="container mx-auto px-4 md:px-8 lg:px-16">
      <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
              <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">Logo</a>
          </div>
          <div class="hidden md:flex items-center space-x-4">
              <a href="/" class="text-gray-700 hover:text-gray-900">Home</a>
              <a href="/campaign" class="text-gray-700 hover:text-gray-900">Campaigns</a>
              <a href="#" class="text-gray-700 hover:text-gray-900">About</a>
              <a href="#" class="text-gray-700 hover:text-gray-900">Contact</a>
          </div>
          <div class="md:hidden">
              <button id="mobile-menu-button" class="text-gray-700 hover:text-gray-900 focus:outline-none">
                  <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"></path>
                  </svg>
              </button>
          </div>
      </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
      <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
      <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Campaigns</a>
      <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About</a>
      <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Contact</a>
  </div>
</nav>

<script>
  document.getElementById('mobile-menu-button').onclick = function () {
      var menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
  };
</script>
