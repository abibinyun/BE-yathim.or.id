<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ArticleResource;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $this->record->slug = Str::slug($this->record->title);
        $this->record->save();
        return $this->getResource()::getUrl('index');
    }
}
