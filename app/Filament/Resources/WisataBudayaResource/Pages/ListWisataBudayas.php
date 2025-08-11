<?php

namespace App\Filament\Resources\WisataBudayaResource\Pages;

use App\Filament\Resources\WisataBudayaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWisataBudayas extends ListRecords
{
    protected static string $resource = WisataBudayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
