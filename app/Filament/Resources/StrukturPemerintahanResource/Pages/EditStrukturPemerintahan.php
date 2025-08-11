<?php

namespace App\Filament\Resources\StrukturPemerintahanResource\Pages;

use App\Filament\Resources\StrukturPemerintahanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStrukturPemerintahan extends EditRecord
{
    protected static string $resource = StrukturPemerintahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
