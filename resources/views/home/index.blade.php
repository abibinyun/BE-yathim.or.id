@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="container my-4">
        
        <x-hero-section />
        
        <x-categories />

        @foreach($categories as $category)
            <x-campaign-slider :categoryId="$category->id" />
        @endforeach

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/500x300" class="card-img-top" alt="Kampanye Terbaru">
                    <div class="card-body">
                        <h5 class="card-title">Kampanye Terbaru</h5>
                        <p class="card-text">Temukan kampanye donasi terbaru yang sedang berlangsung dan dukung mereka untuk mencapai tujuan mereka.</p>
                        <a href="/campaign" class="btn btn-primary">Lihat Kampanye</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/500x300" class="card-img-top" alt="Cara Berpartisipasi">
                    <div class="card-body">
                        <h5 class="card-title">Cara Berpartisipasi</h5>
                        <p class="card-text">Pelajari cara Anda dapat berpartisipasi dalam kampanye donasi dan memberikan dampak positif di komunitas Anda.</p>
                        <a href="#" class="btn btn-primary">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-4">
            <p>&copy; {{ date('Y') }} Website Donasi. Semua hak cipta dilindungi.</p>
        </footer>
    </div>
@endsection
