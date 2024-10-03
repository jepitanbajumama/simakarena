<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Filament\Resources\RenjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRenja extends ViewRecord
{
    protected static string $resource = RenjaResource::class;

    protected static ?string $title = 'Rencana Kerja';
}
