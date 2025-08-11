<?php

namespace App\Filament\Resources\BeritaKegiatanResource\Pages;

use App\Filament\Resources\BeritaKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBeritaKegiatan extends CreateRecord
{
    protected static string $resource = BeritaKegiatanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
