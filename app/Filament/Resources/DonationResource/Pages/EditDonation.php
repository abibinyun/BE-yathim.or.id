<?php

namespace App\Filament\Resources\DonationResource\Pages;

use Filament\Actions;
use App\Models\Campaign;
use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\DonationResource;

class EditDonation extends EditRecord
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        if ($this->record->status === 'success' && !$this->record->is_confrim) {

            $campaign = Campaign::find($this->record->campaign_id);

            if ($campaign) {
                $campaign->amount_raised += $this->record->amount;
                $campaign->save();

                $this->record->is_confrim = true;
                $this->record->save();
            }
        }

        return $this->getResource()::getUrl('index');
    }
}
