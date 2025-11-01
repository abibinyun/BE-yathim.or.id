<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BankAccount;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\BankAccountResource\Pages;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('account_number')
                    ->required(),
                Forms\Components\TextInput::make('account_holder')
                    ->required(),
                FileUpload::make('logo')
                    ->label('Image')
                    ->directory('bank_logos')
                    ->image()
                    ->resize(60)
                    ->optimize('webp')
                    ->deleteUploadedFileUsing(function ($file, $record) {
                        if ($record && $record->logo) {
                            Storage::disk('public')->delete($record->logo);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('account_number'),
                Tables\Columns\TextColumn::make('account_holder'),
                ImageColumn::make('logo')
                    ->disk('public')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->logo) {
                                    Storage::disk('public')->delete($record->logo);
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }
}
