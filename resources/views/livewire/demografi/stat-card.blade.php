<?php

use Livewire\Attributes\{Computed};
use Livewire\Volt\Component;
use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;

new class extends Component {
    #[Computed]
    public function kependudukan()
    {
        $anggota = AnggotaKeluarga::ada();
        return [
            'total_penduduk' => $anggota->count(),
            'total_keluarga' => Keluarga::count(),
            'laki_laki' => (clone $anggota)->lakiLaki()->count(),
            'perempuan' => (clone $anggota)->perempuan()->count(),
        ];
    }
}; ?>

<div class="industries-style-four">
  <div class="row clearfix">
    <div class="industries-block">
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <x-stat-card title="Total Penduduk" :value="$this->kependudukan['total_penduduk']" color="orange" icon="users" />
        <x-stat-card title="Total Keluarga" :value="$this->kependudukan['total_keluarga']" color="green" icon="home" />
        <x-stat-card title="Laki-laki" :value="$this->kependudukan['laki_laki']" color="blue" icon="user-male" />
        <x-stat-card title="Perempuan" :value="$this->kependudukan['perempuan']" color="pink" icon="user-female" />
      </div>
    </div>
  </div>
</div>
