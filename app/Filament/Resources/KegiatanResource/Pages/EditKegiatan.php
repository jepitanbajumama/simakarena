<?php

namespace App\Filament\Resources\KegiatanResource\Pages;

use App\Filament\Resources\KegiatanResource;
// use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class EditKegiatan extends EditRecord
{
    // use HasParentResource;
    use NestedPage;
    
    protected static string $resource = KegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->previousUrl ?? static::getParentResource()::getUrl('kegiatans.index', [
    //         'parent' => $this->parent,
    //     ]);
    // }

    // protected function configureDeleteAction(Actions\DeleteAction $action): void
    // {
    //     $resource = static::getResource();
 
    //     $action->authorize($resource::canDelete($this->getRecord()))
    //         ->successRedirectUrl(static::getParentResource()::getUrl('kegiatans.index', [
    //             'parent' => $this->parent,
    //         ]));
    // }
}
