<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Donation;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\DonationResource\Pages;
use Illuminate\Support\Facades\Auth;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ]),
                TextInput::make('amount')->required(),
                TextInput::make('payment_method')->disabled(),
                TextInput::make('transaction_id')->disabled(),
                Textarea::make('notes')->disabled(),
                TextInput::make('bank_account')->disabled(),
                FileUpload::make('payment_proof')
                    ->image()
                    ->openable()
                    ->downloadable()
                    ->deleteUploadedFileUsing(function ($file, $record) {
                        if ($record && $record->payment_proof) {
                            Storage::disk('public')->delete($record->payment_proof);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('campaign.title')->label('Campaign'),
                TextColumn::make('amount')->label('Jumlah Donasi'),
                TextColumn::make('payment_method')->label('Metode Pembayaran'),
                TextColumn::make('bank_account')->label('Akun Bank'),
                TextColumn::make('transaction_id')->label('ID Transaksi'),
                TextColumn::make('status')->label('Status'),
                ImageColumn::make('payment_proof')
                    ->simpleLightbox(),
                TextColumn::make('notes')->label('Catatan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->payment_proof) {
                                    Storage::disk('public')->delete($record->payment_proof);
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return 'Donasi';
    }

    public static function getNavigationBadge(): ?string
    {
        return null;
    }

    public static function getNavigationGroups(): array
    {
        return [
            'Donasi' => [
                self::class,
            ],
        ];
    }

    // public static function canCreate(): bool
    // {
    //     return false;
    // }

    public static function getNavigationVisibility(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('view_donasi');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('create_donasi');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->can('update_donasi');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->can('delete_donasi');
    }

    public static function canBulkDelete(): bool
    {
        return Auth::user()->can('delete_donasi');
    }
}
