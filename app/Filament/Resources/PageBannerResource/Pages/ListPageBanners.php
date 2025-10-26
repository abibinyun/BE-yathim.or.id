<?php

namespace App\Filament\Resources\PageBannerResource\Pages;

use App\Filament\Resources\PageBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageBanners extends ListRecords
{
    protected static string $resource = PageBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
