<div class="relative overflow-hidden w-full">
    @if ($banners)
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide flex items-center justify-center">
                        <img src="{{ asset('storage/' . $banner) }}" alt="Banner Image" class="object-cover w-full h-auto max-w-full max-h-full">
                    </div>
                @endforeach
            </div>
            <!-- Jika perlu, tambahkan pagination -->
            <div class="swiper-pagination"></div>
            <!-- Jika perlu, tambahkan tombol navigasi -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    @endif
</div>

{{-- <style>
    .hero {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100vh;
        color: white;
        position: relative;
    }

    .hero-slider {
        width: 100%;
        overflow: hidden;
    }

    .slider {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        box-sizing: border-box;
    }

    .slide img {
        width: 100%;
        height: auto;
    }
</style> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.querySelector('.slider');
        let index = 0;

        function showSlide(n) {
            const slides = document.querySelectorAll('.slide');
            if (n >= slides.length) index = 0;
            if (n < 0) index = slides.length - 1;
            slider.style.transform = 'translateX(' + (-index * 100) + '%)';
        }

        function nextSlide() {
            index++;
            showSlide(index);
        }

        function prevSlide() {
            index--;
            showSlide(index);
        }

        setInterval(nextSlide, 5000); // Ganti slide setiap 5 detik

        // Optional: Add prev/next buttons or other controls here
    });
</script>
