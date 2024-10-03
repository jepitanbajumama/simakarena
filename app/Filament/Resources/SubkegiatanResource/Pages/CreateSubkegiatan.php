<?php

namespace App\Filament\Resources\SubkegiatanResource\Pages;

use App\Filament\Resources\SubkegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class CreateSubkegiatan extends CreateRecord
{
    use NestedPage;
    
    protected static string $resource = SubkegiatanResource::class;
    protected static ?string $title = 'Tambah Sub Kegiatan';
}
