<?php

namespace App\Filament\Resources\PageBannerResource\Pages;

use App\Filament\Resources\PageBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageBanner extends EditRecord
{
    protected static string $resource = PageBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
