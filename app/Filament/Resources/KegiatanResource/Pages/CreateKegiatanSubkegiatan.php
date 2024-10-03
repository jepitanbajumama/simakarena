<?php

namespace App\Filament\Resources\KegiatanResource\Pages;

use App\Filament\Resources\KegiatanResource;
use App\Filament\Resources\SubkegiatanResource;
use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Pages\CreateRelatedRecord;

class CreateKegiatanSubkegiatan extends CreateRelatedRecord
{
    use NestedPage;

    protected static string $resource = KegiatanResource::class;

    // This page also needs to know the ancestor relationship used (just like relation managers):
    protected static string $relationship = 'subkegiatans';

    // We can usually guess the nested resource, but if your app has multiple resources for this
    // model, you will need to explicitly define it
    public static string $nestedResource = SubkegiatanResource::class;
}