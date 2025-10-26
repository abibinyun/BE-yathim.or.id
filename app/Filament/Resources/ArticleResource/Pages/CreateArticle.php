<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ArticleResource;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function afterCreate(): void
    {
        // Set slug dulu
        $this->record->slug = Str::slug($this->record->title);
        $this->record->save();

    }

    protected function getRedirectUrl(): string
    {
        $this->record->slug = Str::slug($this->record->title);
        $this->record->save();
        return $this->getResource()::getUrl('index');
    }
}
