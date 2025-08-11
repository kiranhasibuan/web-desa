<?php

namespace App\Filament\Resources\ProdukUnggulanResource\Pages;

use App\Filament\Resources\ProdukUnggulanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProdukUnggulan extends CreateRecord
{
    protected static string $resource = ProdukUnggulanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
