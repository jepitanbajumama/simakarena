<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Filament\Resources\RenjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRenjas extends ListRecords
{
    protected static string $resource = RenjaResource::class;

    protected static ?string $title = 'Rencana Kerja';
}
