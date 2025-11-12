<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Actions;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Hash password jika diubah, atau biarkan kosong jika tidak diisi.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // jangan ubah password lama
        }

        return $data;
    }

    /**
     * Sinkronisasi roles setelah data user disimpan.
     */
    protected function afterSave(): void
    {
        $user = $this->record;
        $roles = $this->form->getState()['roles'] ?? [];

        $user->syncRoles($roles);
    }

    /**
     * Tindakan header — termasuk DeleteAction bawaan.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
