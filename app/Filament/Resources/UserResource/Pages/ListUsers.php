<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    /**
     * Tentukan siapa yang boleh melihat halaman ini.
     */
    protected function canViewAny(): bool
    {
        return auth()->user()?->can('view_user') ?? false;
    }

    /**
     * Tindakan header seperti tombol Create.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => auth()->user()?->can('create_user')), // hanya tampil kalau punya izin
        ];
    }
}
