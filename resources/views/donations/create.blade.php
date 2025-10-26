@extends('layouts.layout')

@section('title', 'Donasi untuk ' . $campaign->title)

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-4">Donasi untuk: {{ $campaign->title }}</h1>

    <form action="{{ route('donations.store', $campaign->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Jumlah Donasi -->
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Donasi</label>
            <input type="number" name="amount" id="amount" class="form-control mt-1" placeholder="Masukkan jumlah donasi" required>
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-4">
            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control mt-1" placeholder="Metode pembayaran" required>
        </div>

        <!-- Akun Bank -->
        <div class="mb-4">
            <label for="bank_account" class="block text-sm font-medium text-gray-700">Akun Bank</label>
            <select name="bank_account" id="bank_account" class="form-control mt-1" required>
                <option value="">Pilih Akun Bank</option>
                @foreach($bankAccounts as $bankAccount)
                    <option value="{{ $bankAccount->id }}" data-account-number="{{ $bankAccount->account_number }}">
                        {{ $bankAccount->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nomor Rekening -->
        <div id="account_number_display" class="mt-2 text-sm text-gray-700">
            <!-- Nomor rekening akan muncul di sini -->
        </div>


        <!-- ID Transaksi -->
        <div class="mb-4">
            <label for="transaction_id" class="block text-sm font-medium text-gray-700">ID Transaksi</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control mt-1" placeholder="ID transaksi (opsional)">
        </div>

        <!-- Bukti Pembayaran -->
        <div class="mb-4">
            <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
            <input type="file" name="payment_proof" id="payment_proof" class="form-control mt-1">
        </div>

        <!-- Catatan -->
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
            <textarea name="notes" id="notes" class="form-control mt-1" rows="3" placeholder="Catatan opsional"></textarea>
        </div>

        <!-- Status Anonim -->
        {{-- <div class="mb-4 flex items-center">
            <input type="checkbox" name="is_anonymous" id="is_anonymous" class="mr-2">
            <label for="is_anonymous" class="text-sm font-medium text-gray-700">Donasi secara anonim</label>
        </div> --}}

        <button type="submit" class="btn btn-primary">
            Konfirmasi Donasi
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('bank_account');
        const displayElement = document.getElementById('account_number_display');

        selectElement.addEventListener('change', function() {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const accountNumber = selectedOption.getAttribute('data-account-number');

            if (accountNumber) {
                displayElement.textContent = `Nomor Rekening: ${accountNumber}`;
            } else {
                displayElement.textContent = '';
            }
        });
    });
</script>

@endsection
