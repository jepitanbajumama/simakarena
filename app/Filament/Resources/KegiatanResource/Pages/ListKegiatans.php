<?php

namespace App\Filament\Resources\KegiatanResource\Pages;

use App\Filament\Resources\KegiatanResource;
// use App\Filament\Resources\ProgramResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class ListKegiatans extends ListRecords
{
    // use HasParentResource;
    use NestedPage;

    protected static string $resource = KegiatanResource::class;
    protected static ?string $title = 'Daftar Kegiatan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Kegiatan'),
            // Actions\CreateAction::make()
            //     ->url(
            //         fn (): string => static::getParentResource()::getUrl('kegiatans.create', [
            //             'parent' => $this->parent,
            //         ])
            //     )
            //     ->label('Tambah Kegiatan'),
        ];
    }
}
