{{-- resources/views/filament/widgets/trigger-github-action-widget.blade.php --}}

<x-filament-widgets::widget>
    <x-filament::card>
        <div class="flex flex-col gap-4">
            {{-- JUDUL RINGKAS --}}
            <h2 class="text-lg font-bold">Sinkronisasi Data & Perbarui Website</h2>

            {{-- DESKRIPSI RINGKAS --}}
            <p class="text-sm text-gray-500">
                Tombol ini memicu proses *build* (pembuatan ulang) website Astro untuk menarik dan menampilkan semua data terbaru dari API.
            </p>

            {{-- TOMBOL SESUAI PERMINTAAN --}}
            <x-filament::button
                wire:click="triggerAction"
                wire:confirm.title="Konfirmasi Sinkronisasi"
                wire:confirm.description="Proses ini akan membuat ulang (build) website Anda dan menarik data terbaru. Lanjutkan?"
                wire:loading.attr="disabled"
                color="primary"
                icon="heroicon-o-arrow-path" {{-- Ikon yang cocok untuk sinkronisasi --}}
                class="w-full sm:w-auto"
            >
                Update & Sync
            </x-filament::button>

            <span wire:loading wire:target="triggerAction" class="text-sm text-primary-500">
                Memulai proses sinkronisasi di GitHub...
            </span>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>