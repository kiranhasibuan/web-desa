<?php

namespace App\Filament\Resources\ProdukUnggulanResource\Pages;

use App\Filament\Resources\ProdukUnggulanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdukUnggulans extends ListRecords
{
    protected static string $resource = ProdukUnggulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
