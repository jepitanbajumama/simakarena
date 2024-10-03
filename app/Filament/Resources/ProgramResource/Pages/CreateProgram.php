<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use App\Filament\Resources\ProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class CreateProgram extends CreateRecord
{
    use NestedPage;

    protected static string $resource = ProgramResource::class;
    protected static ?string $title = 'Tambah Program';
}
