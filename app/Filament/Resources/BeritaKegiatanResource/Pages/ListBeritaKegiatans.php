<?php

namespace App\Filament\Resources\BeritaKegiatanResource\Pages;

use App\Filament\Resources\BeritaKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBeritaKegiatans extends ListRecords
{
    protected static string $resource = BeritaKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
