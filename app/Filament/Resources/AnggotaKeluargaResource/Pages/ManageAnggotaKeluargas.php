<?php

namespace App\Filament\Resources\AnggotaKeluargaResource\Pages;

use App\Filament\Resources\AnggotaKeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAnggotaKeluargas extends ManageRecords
{
    protected static string $resource = AnggotaKeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
