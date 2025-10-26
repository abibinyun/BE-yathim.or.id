<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\PageBanner;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\PageBannerResource\Pages;
use Closure;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Toggle;
use Illuminate\Validation\Rule;
use Filament\Forms\Get;

use function Laravel\Prompts\text;

class PageBannerResource extends Resource
{
    protected static ?string $model = PageBanner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('page_identifier')
                    ->label('Page Identifier')
                    ->options([
                        'none' => 'None',
                        'home' => 'Home',
                        'campaign' => 'Campaign',
                        'gallery' => 'Gallery',
                        'article' => 'Article',
                        'about' => 'About',
                    ])
                    ->default('none')
                    ->reactive()
                    ->required()
                    ->unique(ignoreRecord: true),
                Split::make([
                    Fieldset::make('')
                        ->schema([
                            Toggle::make('isButton')
                                ->label('show Button')
                                ->reactive()
                                ->visible(fn(Get $get) => $get('page_identifier') === 'home')
                                ->default(false),
                            Toggle::make('isVideo')
                                ->label('show video')
                                ->reactive()
                                ->visible(fn(Get $get) => $get('page_identifier') === 'home')
                                ->default(false),
                        ])
                        ->columns(1),
                ])
                    ->grow(false)
                    ->hidden(fn(Get $get) => $get('page_identifier') !== 'home'),
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                TextInput::make('subtitle')
                    ->label('Subtitle')
                    ->required()
                    ->nullable(fn(Get $get) => $get('page_identifier') === 'none'),
                FileUpload::make('banner_image')
                    ->label('Image')
                    ->directory('banner_image')
                    ->image()
                    ->resize(80)
                    ->optimize('webp')
                    ->deleteUploadedFileUsing(function ($file, $record) {
                        if ($record && $record->banner_image) {
                            Storage::disk('public')->delete($record->banner_image);
                        }
                    }),
                TextInput::make('video')
                    ->label('Link Video')
                    ->visible(fn(Get $get) => in_array($get('isVideo'), ['home']) && $get('isVideo') === true)
                    ->nullable(fn(Get $get) => $get('isVideo') === false),
                TextInput::make('button_text')
                    ->label('Button Text')
                    ->visible(fn(Get $get) => in_array($get('page_identifier'), ['home']) && $get('isButton') === true)
                    ->nullable(fn(Get $get) => $get('isButton') === false),
                TextInput::make('button_link')
                    ->label('Button Link')
                    ->visible(fn(Get $get) => in_array($get('page_identifier'), ['home']) && $get('isButton') === true)
                    ->nullable(fn(Get $get) => $get('isButton') === false),

                //video link
                Repeater::make('video_slides')
                    ->schema([
                        TextInput::make('link')
                            ->label('Video Link')
                            ->required(),
                        TextInput::make('title')
                            ->label('Video Title')
                            ->required(),
                        TextInput::make('desc')
                            ->label('Video Description')
                            ->required(),
                    ])
                    ->columns(2)
                    ->default([
                        [
                            'link' => '',
                            'title' => '',
                            'desc' => '',
                        ]
                    ])
                    ->visible(fn(Get $get) => in_array($get('page_identifier'), ['home']))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('banner_image'),
                TextColumn::make('page_identifier')
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
                                if ($record->banner_image) {
                                    Storage::disk('public')->delete($record->banner_image);
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
            'index' => Pages\ListPageBanners::route('/'),
            'create' => Pages\CreatePageBanner::route('/create'),
            'edit' => Pages\EditPageBanner::route('/{record}/edit'),
        ];
    }
}
