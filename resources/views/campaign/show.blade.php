@extends('layouts.layout')

@section('title', 'Campaigns')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mx-auto py-8">
    <div class="mx-auto max-w-[50rem]">
        <div class="bg-white rounded-lg shadow-md overflow-hidden w-full">
            @if($campaign->image)
            <div class="h-[20rem] overflow-hidden">
                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
            </div>
            @else
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <p class="text-gray-500">Gambar tidak tersedia</p>
            </div>
            @endif
            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2">{{ $campaign->title }}</h3>
                @php
                    $percentage = ($campaign->amount_raised / $campaign->goal) * 100;
                @endphp

                <div class="mb-4">
                    <p class="font-semibold">Rp{{ number_format($campaign->amount_raised, 0, ',', '.') }}</p>
                    <p class="font-semibold">Terkumpul dari: Rp{{ number_format($campaign->goal, 0, ',', '.') }}</p>
                    
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-green-500 h-4 rounded-full" style="width: {{ $percentage }}%;"></div>
                    </div>
                </div>

                <p class="text-gray-700 mb-4">{{ \Illuminate\Support\Str::limit($campaign->description, 100) }}</p>
            </div>
        </div>
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('donation.create', $campaign->id) }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold text-lg rounded-full shadow-lg hover:bg-blue-700 transform hover:-translate-y-1 hover:scale-110 transition duration-300 ease-in-out">
            Donasi Sekarang
        </a>        
    </div>    

    @foreach($donations as $donation)
        <div class="donation-history">
            <p><strong>Donatur:</strong> {{ $donation->user->name ?? 'Anonim' }}</p>
            <p><strong>Jumlah:</strong> {{ number_format($donation->amount, 0, ',', '.') }}</p>
            <p><strong>Tanggal:</strong> {{ $donation->created_at->format('d M Y H:i') }}</p>
            <hr>
        </div>
    @endforeach

    <div class="container">
        <h2>Pesan dari Donatur</h2>
        @foreach ($donations as $donation)
            <div class="donation-message">
                <p>{{ $donation->notes }}</p>
                <small>Donasi oleh: {{ $donation->user->name ?? 'Anonim' }}</small>
            </div>
        @endforeach
    </div>
    
</div>
@endsection
