<?php

namespace App\Filament\Resources\PageBannerResource\Pages;

use App\Filament\Resources\PageBannerResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePageBanner extends CreateRecord
{
    protected static string $resource = PageBannerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
