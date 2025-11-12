<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Article;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\ArticleResource\Pages;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('content')
                    ->required()
                    ->columnSpan('full'),
                Textarea::make('excerpt')
                    ->nullable()
                    ->maxLength(500),
                Select::make('category')
                    ->options([
                        'news' => 'News',
                        'stories' => 'Stories',
                        'campaign' => 'Campaign',
                        'education' => 'Education',
                        'event' => 'Event',
                        'achievements' => 'Achievements',
                        'social' => 'Social',
                    ])
                    ->default('news')
                    ->required(),
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required(),
                Select::make('featured')
                    ->options([
                        'primary' => 'Primary',
                        'hot' => 'Hot',
                        'none' => 'None',
                    ])
                    ->default('none')
                    ->required(),
                FileUpload::make('image')
                    ->label('Image')
                    ->directory('articles')
                    ->image()
                    ->resize(60)
                    ->optimize('webp')
                    ->deleteUploadedFileUsing(function ($file, $record) {
                        if ($record && $record->image) {
                            Storage::disk('public')->delete($record->image);
                        }
                    }),
                DatePicker::make('published_at')
                    ->nullable()
                    ->label('Published At')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('category')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('featured')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('published_at')
                    ->date()
                    ->label('Published At')
                    ->sortable(),
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
                        ->visible(fn () => Auth::user()->hasRole('super-admin') || Auth::user()->can('delete', Model::class))
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('view_article');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('create_article');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->can('update_article');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->can('delete_article');
    }

    public static function canBulkDelete(): bool
    {
        return Auth::user()->can('delete_article');
    }
}
