<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Campaign;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Category;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('description')->required(),
                        DateTimePicker::make('start_date')
                            ->required(),
                        DateTimePicker::make('end_date')
                            ->required(),
                        TextInput::make('goal')
                            ->required()
                            ->numeric()
                            ->maxLength(255)
                            ->afterStateHydrated(function ($state) {
                                return number_format($state, 0, '.', '');
                            }),
                        FileUpload::make('image')
                            ->label('Image')
                            ->directory('campaigns')
                            ->image()
                            ->resize(60)
                            ->optimize('webp')
                            ->deleteUploadedFileUsing(function ($file, $record) {
                                if ($record && $record->image) {
                                    Storage::disk('public')->delete($record->image);
                                }
                            }),
                        Select::make('featured')
                            ->options([
                                'primary' => 'Primary',
                                'hot' => 'Hot',
                                'none' => 'None',
                            ])
                            ->default('none')
                            ->required(),
                        ToggleButtons::make('is_active')
                            ->label('Active this post?')
                            ->boolean()
                            ->inline(),
                        Select::make('category_id')
                            ->label('Category')
                            ->options(Category::all()->pluck('name', 'id')) // Mengambil nama kategori untuk select
                            ->searchable()
                            ->required(),
						TextInput::make('facebook_pixel')
                            ->label('Facebook Pixel ID')
                            ->nullable()
                            ->maxLength(255)
                            ->placeholder('Optional, enter Facebook Pixel ID'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('is_active')->sortable(),
                TextColumn::make('title')->sortable(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('start_date')->dateTime(),
                TextColumn::make('end_date')->dateTime(),
                TextColumn::make('goal')->sortable(),
                TextColumn::make('image')->limit(50),
                TextColumn::make('category.name')->sortable(),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->dateTime()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => Auth::user()->can('update', $record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->image) {
                                    Storage::disk('public')->delete($record->image);
                                }
                            }
                        })
                        ->visible(fn () => Auth::user()->hasRole('super-admin') || Auth::user()->can('delete', Model::class)),
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
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('view_campaign');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('create_campaign');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->can('update_campaign');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->can('delete_campaign');
    }

    public static function canBulkDelete(): bool
    {
        return Auth::user()->can('delete_campaign');
    }
}
