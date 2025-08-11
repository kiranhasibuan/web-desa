<?php

namespace App\Filament\Resources\ProdukUnggulanResource\Pages;

use App\Filament\Resources\ProdukUnggulanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdukUnggulan extends EditRecord
{
    protected static string $resource = ProdukUnggulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
