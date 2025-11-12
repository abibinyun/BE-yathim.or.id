<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'User Management';
    protected static ?string $pluralModelLabel = 'Users';
    protected static ?string $modelLabel = 'User';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 4;

    // Query dengan eager load roles
    public static function query(): Builder
    {
        return parent::query()->with('roles');
    }

    // Form untuk Create & Edit
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique(User::class, 'email', ignoreRecord: true),

                TextInput::make('password')
                    ->password()
                    ->placeholder('default: password123')
                    ->required(fn ($record) => !$record)
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => $state ?: null),

                Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->options(Role::pluck('name', 'name'))
                    ->required()
                    ->preload()
                    ->afterStateHydrated(fn ($set, ?User $record) => 
                        $set('roles', $record?->roles?->pluck('name')->toArray() ?? [])
                    )
            ]);
    }

    // Tabel tampilan User
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('roles')
                    ->label('Roles')
                    ->formatStateUsing(fn ($record) => $record->roles->pluck('name')->implode(', '))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // Halaman (index, create, edit)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // Menangani penyimpanan role setelah save
    public static function save(Forms\Form $form, $record)
    {
        $data = $form->getState();

        if (isset($data['roles'])) {
            $record->syncRoles($data['roles']);
        }

        return parent::save($form, $record);
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('view_user');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('create_user');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->can('update_user');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->can('delete_user');
    }

    public static function canBulkDelete(): bool
    {
        return Auth::user()->can('delete_user');
    }
}