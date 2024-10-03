<?php

namespace App\Filament\Resources\SubkegiatanResource\Pages;

use App\Filament\Resources\SubkegiatanResource;
use App\Filament\Resources\KegiatanResource;
// use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class ListSubkegiatans extends ListRecords
{
    // use HasParentResource;
    use NestedPage;

    protected static string $resource = SubkegiatanResource::class;
    protected static ?string $title = 'Daftar Sub Kegiatan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Sub Kegiatan'),
            // Actions\CreateAction::make()
            // ->url(
            //     fn (): string => static::getParentResource()::getUrl('subkegiatans.create', [
            //         'parent' => $this->parent,
            //     ])
            // )
            // ->label('Tambah Sub Kegiatan'),
        ];
    }
}
