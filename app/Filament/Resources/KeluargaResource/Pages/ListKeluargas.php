<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Filament\Resources\KeluargaResource;
use App\Filament\Resources\KeluargaResource\Widgets\StatsKeluarga;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeluargas extends ListRecords
{
    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->createAnother(false),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [StatsKeluarga::class];
    }
}
