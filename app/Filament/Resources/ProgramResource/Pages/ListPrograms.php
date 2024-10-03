<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use App\Filament\Resources\ProgramResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class ListPrograms extends ListRecords
{
    use NestedPage;
    
    protected static string $resource = ProgramResource::class;
    protected static ?string $title = 'Daftar Program';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Program'),
        ];
    }
}
