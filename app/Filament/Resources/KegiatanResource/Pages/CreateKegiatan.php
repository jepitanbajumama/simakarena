<?php

namespace App\Filament\Resources\KegiatanResource\Pages;

use App\Filament\Resources\KegiatanResource;
// use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class CreateKegiatan extends CreateRecord
{
    // use HasParentResource;
    use NestedPage;
    
    protected static string $resource = KegiatanResource::class;
    protected static ?string $title = 'Tambah Kegiatan';

    // protected function getRedirectUrl(): string
    // {
    //     return $this->previousUrl ?? static::getParentResource()::getUrl('kegiatans.index', [
    //         'parent' => $this->parent,
    //     ]);
    // }

    // // This can be moved to Trait, but we are keeping it here
    // //   to avoid confusion in case you mutate the data yourself
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Set the parent relationship key to the parent resource's ID.
    //     $data[$this->getParentRelationshipKey()] = $this->parent->id;
 
    //     return $data;
    // }
}
