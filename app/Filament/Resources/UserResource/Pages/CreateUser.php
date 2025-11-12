<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Hash password sebelum disimpan ke database
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika tidak diisi, set default password
        if (empty($data['password'])) {
            $data['password'] = Hash::make('password123');
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    /**
     * Sinkronisasi role setelah user dibuat
     */
    protected function afterCreate(): void
    {
        $user = $this->record;
        $roles = $this->form->getState()['roles'] ?? [];

        if (!empty($roles)) {
            $user->syncRoles($roles);
        }
    }

    protected function afterSave(): void
    {
        $user = $this->record;
        $roles = $this->form->getState()['roles'] ?? [];
        $user->syncRoles($roles);
    }

}
