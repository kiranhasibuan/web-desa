<?php

namespace App\Filament\Resources\WisataBudayaResource\Pages;

use App\Filament\Resources\WisataBudayaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWisataBudaya extends EditRecord
{
    protected static string $resource = WisataBudayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
