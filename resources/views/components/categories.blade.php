<!-- resources/views/components/categories.blade.php -->
<!-- resources/views/components/categories.blade.php -->
<div class="container mx-auto p-6">
    <!-- Judul -->
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">Kategori Kami</h1>
    
    <!-- Grid Kategori -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($categories as $category)
            <div class="bg-white p-2 sm:p-4 rounded shadow flex items-center">
                <!-- Gambar Kategori -->
                <img src="{{ url('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-8 h-8 sm:w-12 sm:h-12 md:w-16 md:h-16 object-cover rounded-full mr-4">
                <!-- Nama Kategori -->
                <span class="text-xs sm:text-sm md:text-lg font-semibold">{{ $category->name }}</span>
            </div>
        @endforeach
    </div>
</div>
