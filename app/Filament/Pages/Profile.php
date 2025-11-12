<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;

class Profile extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $navigationGroup = 'Settings';
    protected static string $view = 'filament.pages.profile';

    // ✅ Gunakan properti $formState atau $data agar Filament aware
    public ?array $data = [];

    public function mount(): void
    {
        // Ambil user dan isi $data — bukan langsung $this->form->fill()
        $user = Auth::user();

        $this->data = [
            'name'  => $user->name ?? '',
            'email' => $user->email ?? '',
            'role'  => $user->roles->pluck('name')->implode(', ')
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Account Information')
                ->schema([

                    Forms\Components\TextInput::make('name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('role')
                        ->label('Roles')
                        ->disabled()
                        ->default(fn () => Auth::user()->roles->pluck('name')->implode(', '))

                ]),

            Forms\Components\Section::make('Change Password')
                ->schema([
                    Forms\Components\TextInput::make('current_password')
                        ->password()
                        ->label('Current Password')
                        ->dehydrated(false),

                    Forms\Components\TextInput::make('new_password')
                        ->password()
                        ->label('New Password')
                        ->dehydrated(false),

                    Forms\Components\TextInput::make('new_password_confirmation')
                        ->password()
                        ->label('Confirm New Password')
                        ->dehydrated(false),
                ]),
        ];
    }

    // ✅ Beri tahu Filament kalau form ini pakai state dari $data
    protected function getFormStatePath(): string
    {
        return 'data';
    }

    // ✅ Pastikan model binding ada (tidak wajib, tapi bagus untuk type hint)
    protected function getFormModel(): Model|string|null
    {
        return Auth::user();
    }

    public function save(): void
    {
        $user = Auth::user();
        $data = $this->data; // karena kita pakai $data sebagai state

        // Update basic info
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Ganti password jika diisi
        if (!empty($data['current_password']) && !empty($data['new_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                // $this->addError('current_password', 'Current password is incorrect.');
                Notification::make()
                    ->title('Current password is incorrect!')
                    ->danger()
                    ->send();
                    
                return;
            }

            $user->update([
                'password' => Hash::make($data['new_password']),
            ]);
        }

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Save Changes')
                ->submit('save'),
        ];
    }
}
