<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CampaignResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateCampaign extends CreateRecord
{
    protected static string $resource = CampaignResource::class;

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
