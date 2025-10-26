<div class="container mx-auto p-6">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">{{ $category->name }}</h1>
    
    <!-- Slider Container -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($campaigns as $campaign)
                <div class="swiper-slide bg-white p-4 rounded shadow">
                    <img src="{{ url('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-40 object-cover rounded mb-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $campaign->title }}</h2>
                    <p>{{ Str::limit($campaign->description, 100) }}</p>
                </div>
            @endforeach
        </div>
        
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<!-- Include Swiper JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            }
        });
    });
</script>
