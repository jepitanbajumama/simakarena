<?php

namespace App\Filament\Resources\KinerjaResource\Pages;

use App\Filament\Resources\KinerjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKinerja extends ViewRecord
{
    protected static string $resource = KinerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
