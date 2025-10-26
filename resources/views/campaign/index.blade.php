@extends('layouts.layout')

@section('title', 'Campaigns')

@section('content')
<div class="container mx-auto ">
    <x-hero-section />
    <h1 class="text-3xl font-bold mb-8">Campaigns</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($campaigns as $campaign)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($campaign->image)
            <div class="h-48 overflow-hidden">
                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
            </div>
            @else
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <p class="text-gray-500">Gambar tidak tersedia</p>
            </div>
            @endif
            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2">{{ $campaign->title }}</h3>
                <p class="text-gray-700 mb-4">{{ \Illuminate\Support\Str::limit($campaign->description, 100) }}</p>
                <a href="{{ route('campaign.show', $campaign) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
