<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Filament\Resources\KeluargaResource;
use App\Models\SLS;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

class CreateKeluarga extends CreateRecord
{
    protected static string $resource = KeluargaResource::class;
}
