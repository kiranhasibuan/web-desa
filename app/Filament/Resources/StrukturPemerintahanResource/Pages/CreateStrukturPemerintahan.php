<?php

namespace App\Filament\Resources\StrukturPemerintahanResource\Pages;

use App\Filament\Resources\StrukturPemerintahanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStrukturPemerintahan extends CreateRecord
{
    protected static string $resource = StrukturPemerintahanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
