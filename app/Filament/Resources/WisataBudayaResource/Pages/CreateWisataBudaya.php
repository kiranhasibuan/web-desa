<?php

namespace App\Filament\Resources\WisataBudayaResource\Pages;

use App\Filament\Resources\WisataBudayaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWisataBudaya extends CreateRecord
{
    protected static string $resource = WisataBudayaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
