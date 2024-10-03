<?php

namespace App\Filament\Resources\SubkegiatanResource\Pages;

use App\Filament\Resources\SubkegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class EditSubkegiatan extends EditRecord
{
    use NestedPage;
    
    protected static string $resource = SubkegiatanResource::class;
    protected static ?string $title = 'Edit Sub Kegiatan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
