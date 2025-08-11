<?php

namespace App\Filament\Resources\KeluargaResource\Widgets;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsKeluarga extends BaseWidget
{
    protected function getStats(): array
    {
        $queryAngKel = AnggotaKeluarga::with('keluarga')
            ->get();

        $queryKeluarga = Keluarga::all();

        return [
            Stat::make('Jumlah Penduduk', $queryAngKel->count())->description('Jumlah Keluarga : ' . $queryKeluarga->count())
                ->descriptionIcon('heroicon-m-user-group'),
            Stat::make('Laki-laki', $queryAngKel->where('jenis_kelamin', '1')->count()),
            Stat::make('Perempuan', $queryAngKel->where('jenis_kelamin', '0')->count())
        ];
    }
}
