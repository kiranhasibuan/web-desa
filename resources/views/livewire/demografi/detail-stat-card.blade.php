<?php

use Livewire\Attributes\{Computed};
use Livewire\Volt\Component;
use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;

new class extends Component {
    #[Computed]
    public function statistikDetail()
    {
        $anggota = AnggotaKeluarga::ada();
        $totalAnggota = $anggota->count();
        $totalKeluarga = Keluarga::count();
        $perempuanCount = (clone $anggota)->perempuan()->count();

        $avgAge = $anggota->whereNotNull('tanggal_lahir')->selectRaw('AVG(strftime("%Y", "now") - strftime("%Y", tanggal_lahir)) AS avg_age')->value('avg_age') ?? 0;

        return [
            'demografi' => [
                'rata_rata_umur' => round($avgAge, 1),
                'rasio_jenis_kelamin' => $perempuanCount > 0 ? round(((clone $anggota)->lakiLaki()->count() / $perempuanCount) * 100, 1) : 0,
                'rata_rata_anggota_keluarga' => $totalKeluarga > 0 ? round($totalAnggota / $totalKeluarga, 1) : 0,
            ],
            'rumah' => [
                'milik_sendiri' => Keluarga::where('status_tempat', 1)->count(),
                'kontrak_sewa' => Keluarga::where('status_tempat', 2)->count(),
                'rata_rata_luas_lantai' => Keluarga::whereNotNull('luas_lantai')->avg('luas_lantai') ?? 0,
                'rata_rata_kamar' => Keluarga::whereNotNull('jlh_kamar')->avg('jlh_kamar') ?? 0,
                'lantai_keramik' => Keluarga::where('jenis_lantai', 2)->count(),
                'lantai_semen' => Keluarga::where('jenis_lantai', 6)->count(),
                'lantai_tanah' => Keluarga::where('jenis_lantai', 8)->count(),
                'dinding_tembok' => Keluarga::where('jenis_dinding', 1)->count(),
                'atap_genteng' => Keluarga::where('jenis_atap', 2)->count(),
                'atap_seng' => Keluarga::where('jenis_atap', 3)->count(),
                'punya_shm' => Keluarga::where('jenis_kepemilikan', 1)->count(),
            ],
            'energi' => [
                'listrik_pln_meteran' => Keluarga::where('listrik', 1)->count(),
                'listrik_pln_tanpa_meteran' => Keluarga::where('listrik', 2)->count(),
                'listrik_non_pln' => Keluarga::where('listrik', 3)->count(),
                'bukan_listrik' => Keluarga::where('listrik', 4)->count(),
                'daya_450w' => Keluarga::whereIn('daya1', [1])
                    ->orWhereIn('daya2', [1])
                    ->orWhereIn('daya3', [1])
                    ->count(),
                'daya_900w' => Keluarga::whereIn('daya1', [2])
                    ->orWhereIn('daya2', [2])
                    ->orWhereIn('daya3', [2])
                    ->count(),
                'memasak_gas' => Keluarga::whereIn('bahan_bakar', [2, 3, 4, 5])->count(),
                'memasak_kayu' => Keluarga::where('bahan_bakar', 10)->count(),
            ],
            'sanitasi' => [
                'air_kemasan' => Keluarga::where('sumber_airMinum', 1)->count(),
                'air_leding' => Keluarga::whereIn('sumber_airMinum', [3, 4])->count(),
                'air_sumur' => Keluarga::whereIn('sumber_airMinum', [5, 6, 7])->count(),
                'air_permukaan' => Keluarga::where('sumber_airMinum', 10)->count(),
                'jamban_sendiri' => Keluarga::where('kepemilikan_sanitasi', 1)->count(),
                'jamban_bersama' => Keluarga::where('kepemilikan_sanitasi', 2)->count(),
                'mck_komunal' => Keluarga::where('kepemilikan_sanitasi', 3)->count(),
                'kloset_leher_angsa' => Keluarga::where('jenis_sanitasi', 1)->count(),
                'sampah_diangkut' => Keluarga::where('tempat_sampah', 1)->count(),
                'sampah_dibakar' => Keluarga::where('tempat_sampah', 2)->count(),
                'sampah_dilaut' => Keluarga::where('tempat_sampah', 3)->count(),
                'sampah_selokan' => Keluarga::where('tempat_sampah', 4)->count(),
                'sampah_lainnya' => Keluarga::where('tempat_sampah', 5)->count(),
                'pemukiman_kumuh' => Keluarga::where('kumuh', true)->count(),
            ],
            'aset_elektronik' => [
                'tabung_gas' => Keluarga::where('aset_tabungGas', true)->count(),
                'kulkas' => Keluarga::where('aset_kulkas', true)->count(),
                'ac' => Keluarga::where('aset_ac', true)->count(),
                'pemanas_air' => Keluarga::where('aset_pemanasAir', true)->count(),
                'telepon_rumah' => Keluarga::where('aset_telefonRumah', true)->count(),
                'televisi' => Keluarga::where('aset_televisi', true)->count(),
                'komputer' => Keluarga::where('aset_komputer', true)->count(),
                'smartphone' => Keluarga::where('aset_smartphone', true)->count(),
                'rata_rata_hp' => Keluarga::whereNotNull('jlh_noHp')->avg('jlh_noHp') ?? 0,
                'rata_rata_tv' => Keluarga::whereNotNull('jlh_TV')->avg('jlh_TV') ?? 0,
            ],
            'aset_transportasi' => [
                'sepeda' => Keluarga::where('aset_sepeda', true)->count(),
                'sepeda_motor' => Keluarga::where('aset_sepedaMotor', true)->count(),
                'mobil' => Keluarga::where('aset_mobil', true)->count(),
                'perahu' => Keluarga::where('aset_perahu', true)->count(),
                'motor_tempel' => Keluarga::where('aset_motorTempel', true)->count(),
                'perahu_motor' => Keluarga::where('aset_perahuMotor', true)->count(),
            ],
            'aset_investasi' => [
                'emas_perhiasan' => Keluarga::where('aset_emas', true)->count(),
                'lahan' => Keluarga::where('aset_lahan', true)->count(),
                'rumah_lain' => Keluarga::where('aset_rumahLain', true)->count(),
                'rata_rata_luas_lahan' => Keluarga::where('aset_lahan', true)->whereNotNull('luas_lahan')->avg('luas_lahan') ?? 0,
            ],
            'ternak' => [
                'total_sapi' => Keluarga::whereNotNull('ternak_sapi')->sum('ternak_sapi') ?? 0,
                'total_kerbau' => Keluarga::whereNotNull('ternak_kerbau')->sum('ternak_kerbau') ?? 0,
                'total_kuda' => Keluarga::whereNotNull('ternak_kuda')->sum('ternak_kuda') ?? 0,
                'total_babi' => Keluarga::whereNotNull('ternak_babi')->sum('ternak_babi') ?? 0,
                'total_kambing' => Keluarga::whereNotNull('ternak_kambing')->sum('ternak_kambing') ?? 0,
                'pemilik_sapi' => Keluarga::where('ternak_sapi', '>', 0)->count(),
                'pemilik_kambing' => Keluarga::where('ternak_kambing', '>', 0)->count(),
            ],
            'kesehatan' => [
                'cakupan_kb' => $totalAnggota > 0 ? round(((clone $anggota)->where('kontrasepsi', true)->count() / $totalAnggota) * 100, 1) : 0,
                'balita_gizi_buruk' => (clone $anggota)->where('status_gizi', 1)->count(),
                'balita_stunting' => (clone $anggota)->where('status_gizi', 2)->count(),
            ],
        ];
    }
}; ?>

<style>
  .filter-tabs-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    /* margin-bottom: 2rem; */
  }

  .filter-tabs {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    box-shadow: 0px 0px 80px 0px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e5e5;
    border-radius: 100px;
    padding: 4px;
    flex-wrap: wrap;
    gap: 2px;
  }

  .filter-tab {
    position: relative;
    display: inline-block;
    font-size: 16px;
    line-height: 26px;
    font-weight: 500;
    color: #666;
    text-transform: capitalize;
    padding: 5px 15px;
    cursor: pointer;
    border-radius: 100px;
    transition: all 1000ms ease;
    border: none;
    background: transparent;
  }

  .filter-tab:hover,
  .filter-tab.active {
    color: #333;
    background: rgba(59, 130, 246, 0.1);
  }

  .filter-tab.active {
    background: #45a735;
    color: white;
  }

  @media only screen and (max-width: 1200px) {
    .filter-tab {
      padding-left: 20px;
      padding-right: 20px;
      font-size: 14px;
    }
  }

  @media only screen and (max-width: 991px) {
    .filter-tabs {
      display: inline-flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .filter-tab {
      padding: 8px 16px;
      font-size: 13px;
    }
  }

  @media only screen and (max-width: 499px) {
    .filter-tabs {
      border-radius: 10px;
      padding: 4px;
    }

    .filter-tab {
      border-radius: 10px;
      padding: 6px 12px;
      font-size: 12px;
    }
  }
</style>

<div x-data="{ activeTab: 'demografi' }" class="w-full">
  <!-- Tab Navigation with Custom Style -->
  <div class="filter-tabs-container">
    <div class="filter-tabs">
      <!-- Tab Demografi -->
      <button :class="activeTab === 'demografi' ? 'active' : ''" class="filter-tab" @click="activeTab = 'demografi'">
        <i class="fas fa-users mr-1"></i>
        Demografi
      </button>

      <!-- Tab Rumah -->
      <button :class="activeTab === 'rumah' ? 'active' : ''" class="filter-tab" @click="activeTab = 'rumah'">
        <i class="fas fa-home mr-1"></i>
        Rumah
      </button>

      <!-- Tab Energi -->
      <button :class="activeTab === 'energi' ? 'active' : ''" class="filter-tab" @click="activeTab = 'energi'">
        <i class="fas fa-bolt mr-1"></i>
        Energi
      </button>

      <!-- Tab Sanitasi -->
      <button :class="activeTab === 'sanitasi' ? 'active' : ''" class="filter-tab" @click="activeTab = 'sanitasi'">
        <i class="fas fa-tint mr-1"></i>
        Air & Sanitasi
      </button>

      <!-- Tab Aset Elektronik -->
      <button :class="activeTab === 'aset_elektronik' ? 'active' : ''" class="filter-tab" @click="activeTab = 'aset_elektronik'">
        <i class="fas fa-tv mr-1"></i>
        Elektronik
      </button>

      <!-- Tab Transportasi -->
      <button :class="activeTab === 'aset_transportasi' ? 'active' : ''" class="filter-tab" @click="activeTab = 'aset_transportasi'">
        <i class="fas fa-car mr-1"></i>
        Transportasi
      </button>

      <!-- Tab Investasi -->
      <button :class="activeTab === 'aset_investasi' ? 'active' : ''" class="filter-tab" @click="activeTab = 'aset_investasi'">
        <i class="fas fa-coins mr-1"></i>
        Investasi
      </button>

      <!-- Tab Ternak -->
      <button :class="activeTab === 'ternak' ? 'active' : ''" class="filter-tab" @click="activeTab = 'ternak'">
        <i class="fas fa-horse mr-1"></i>
        Ternak
      </button>

      <!-- Tab Kesehatan -->
      <button :class="activeTab === 'kesehatan' ? 'active' : ''" class="filter-tab" @click="activeTab = 'kesehatan'">
        <i class="fas fa-heartbeat mr-1"></i>
        Kesehatan
      </button>
    </div>
  </div>

  <!-- Tab Content -->
  <div class="my-6">
    <!-- Demografi Tab Content -->
    <div x-show="activeTab === 'demografi'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <x-detail-stat-card title="Rata-rata Umur" :value="number_format($this->statistikDetail['demografi']['rata_rata_umur'], 1) . ' tahun'" color="indigo" icon="fas fa-birthday-cake" />
        <x-detail-stat-card title="Rasio Jenis Kelamin" :value="number_format($this->statistikDetail['demografi']['rasio_jenis_kelamin'], 0) . '%'" color="purple" icon="fas fa-venus-mars" />
        <x-detail-stat-card title="Rata-rata Anggota Keluarga" :value="number_format($this->statistikDetail['demografi']['rata_rata_anggota_keluarga'], 1) . ' orang'" color="blue" icon="fas fa-users" />
      </div>
    </div>

    <!-- Rumah Tab Content -->
    <div x-show="activeTab === 'rumah'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <x-detail-stat-card title="Milik Sendiri" :value="number_format($this->statistikDetail['rumah']['milik_sendiri']) . ' keluarga'" color="blue" icon="fas fa-home" />
        <x-detail-stat-card title="Kontrak/Sewa" :value="number_format($this->statistikDetail['rumah']['kontrak_sewa']) . ' keluarga'" color="orange" icon="fas fa-key" />
        <x-detail-stat-card title="Rata-rata Luas Lantai" :value="number_format($this->statistikDetail['rumah']['rata_rata_luas_lantai'], 0) . ' m²'" color="green" icon="fas fa-ruler-combined" />
        <x-detail-stat-card title="Rata-rata Kamar" :value="number_format($this->statistikDetail['rumah']['rata_rata_kamar'], 1) . ' kamar'" color="purple" icon="fas fa-bed" />
        <x-detail-stat-card title="Lantai Keramik" :value="number_format($this->statistikDetail['rumah']['lantai_keramik']) . ' keluarga'" color="indigo" icon="fas fa-square" />
        <x-detail-stat-card title="Lantai Semen" :value="number_format($this->statistikDetail['rumah']['lantai_semen']) . ' keluarga'" color="gray" icon="fas fa-square" />
        <x-detail-stat-card title="Lantai Tanah" :value="number_format($this->statistikDetail['rumah']['lantai_tanah']) . ' keluarga'" color="yellow" icon="fas fa-square" />
        <x-detail-stat-card title="Dinding Tembok" :value="number_format($this->statistikDetail['rumah']['dinding_tembok']) . ' keluarga'" color="red" icon="fas fa-building" />
        <x-detail-stat-card title="Atap Genteng" :value="number_format($this->statistikDetail['rumah']['atap_genteng']) . ' keluarga'" color="pink" icon="fas fa-home" />
        <x-detail-stat-card title="Atap Seng" :value="number_format($this->statistikDetail['rumah']['atap_seng']) . ' keluarga'" color="cyan" icon="fas fa-home" />
        <x-detail-stat-card title="Punya SHM" :value="number_format($this->statistikDetail['rumah']['punya_shm']) . ' keluarga'" color="emerald" icon="fas fa-certificate" />
      </div>
    </div>

    <!-- Energi Tab Content -->
    <div x-show="activeTab === 'energi'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <x-detail-stat-card title="PLN dengan Meteran" :value="number_format($this->statistikDetail['energi']['listrik_pln_meteran']) . ' keluarga'" color="yellow" icon="fas fa-plug" />
        <x-detail-stat-card title="PLN tanpa Meteran" :value="number_format($this->statistikDetail['energi']['listrik_pln_tanpa_meteran']) . ' keluarga'" color="orange" icon="fas fa-bolt" />
        <x-detail-stat-card title="Listrik Non-PLN" :value="number_format($this->statistikDetail['energi']['listrik_non_pln']) . ' keluarga'" color="blue" icon="fas fa-battery-half" />
        <x-detail-stat-card title="Bukan Listrik" :value="number_format($this->statistikDetail['energi']['bukan_listrik']) . ' keluarga'" color="red" icon="fas fa-candle-holder" />
        <x-detail-stat-card title="Daya 450W" :value="number_format($this->statistikDetail['energi']['daya_450w']) . ' keluarga'" color="green" icon="fas fa-tachometer-alt" />
        <x-detail-stat-card title="Daya 900W" :value="number_format($this->statistikDetail['energi']['daya_900w']) . ' keluarga'" color="purple" icon="fas fa-tachometer-alt" />
        <x-detail-stat-card title="Memasak dengan Gas" :value="number_format($this->statistikDetail['energi']['memasak_gas']) . ' keluarga'" color="indigo" icon="fas fa-fire" />
        <x-detail-stat-card title="Memasak dengan Kayu" :value="number_format($this->statistikDetail['energi']['memasak_kayu']) . ' keluarga'" color="amber" icon="fas fa-tree" />
      </div>
    </div>

    <!-- Sanitasi Tab Content -->
    <div x-show="activeTab === 'sanitasi'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <x-detail-stat-card title="Air Kemasan" :value="number_format($this->statistikDetail['sanitasi']['air_kemasan']) . ' keluarga'" color="blue" icon="fas fa-bottle-water" />
        <x-detail-stat-card title="Air Leding" :value="number_format($this->statistikDetail['sanitasi']['air_leding']) . ' keluarga'" color="cyan" icon="fas fa-faucet" />
        <x-detail-stat-card title="Air Sumur" :value="number_format($this->statistikDetail['sanitasi']['air_sumur']) . ' keluarga'" color="teal" icon="fas fa-well" />
        <x-detail-stat-card title="Air Permukaan" :value="number_format($this->statistikDetail['sanitasi']['air_permukaan']) . ' keluarga'" color="indigo" icon="fas fa-water" />
        <x-detail-stat-card title="Jamban Sendiri" :value="number_format($this->statistikDetail['sanitasi']['jamban_sendiri']) . ' keluarga'" color="green" icon="fas fa-toilet" />
        <x-detail-stat-card title="MCK Komunal" :value="number_format($this->statistikDetail['sanitasi']['mck_komunal']) . ' keluarga'" color="purple" icon="fas fa-users" />
        <x-detail-stat-card title="Kloset Leher Angsa" :value="number_format($this->statistikDetail['sanitasi']['kloset_leher_angsa']) . ' keluarga'" color="pink" icon="fas fa-toilet-paper" />
        <x-detail-stat-card title="Sampah Diangkut" :value="number_format($this->statistikDetail['sanitasi']['sampah_diangkut']) . ' keluarga'" color="emerald" icon="fas fa-truck" />
        <x-detail-stat-card title="Sampah Dibakar" :value="number_format($this->statistikDetail['sanitasi']['sampah_dibakar']) . ' keluarga'" color="orange" icon="fas fa-fire" />
        <x-detail-stat-card title="Sampah Di Sungai/Laut" :value="number_format($this->statistikDetail['sanitasi']['sampah_dilaut']) . ' keluarga'" color="slate" icon="fas fa-water" />
        <x-detail-stat-card title="Sampah Di Selokan/Got" :value="number_format($this->statistikDetail['sanitasi']['sampah_selokan']) . ' keluarga'" color="amber" icon="fas fa-road" />
        <x-detail-stat-card title="Sampah Lainnya" :value="number_format($this->statistikDetail['sanitasi']['sampah_lainnya']) . ' keluarga'" color="gray" icon="fas fa-trash-alt" />
        <x-detail-stat-card title="Pemukiman Kumuh" :value="number_format($this->statistikDetail['sanitasi']['pemukiman_kumuh']) . ' keluarga'" color="red" icon="fas fa-exclamation-triangle" />
      </div>
    </div>

    <!-- Aset Elektronik Tab Content -->
    <div x-show="activeTab === 'aset_elektronik'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <x-detail-stat-card title="Tabung Gas" :value="number_format($this->statistikDetail['aset_elektronik']['tabung_gas']) . ' keluarga'" color="orange" icon="fas fa-burn" />
        <x-detail-stat-card title="Kulkas" :value="number_format($this->statistikDetail['aset_elektronik']['kulkas']) . ' keluarga'" color="blue" icon="fas fa-snowflake" />
        <x-detail-stat-card title="AC" :value="number_format($this->statistikDetail['aset_elektronik']['ac']) . ' keluarga'" color="cyan" icon="fas fa-wind" />
        <x-detail-stat-card title="Pemanas Air" :value="number_format($this->statistikDetail['aset_elektronik']['pemanas_air']) . ' keluarga'" color="red" icon="fas fa-thermometer-three-quarters" />
        <x-detail-stat-card title="Telepon Rumah" :value="number_format($this->statistikDetail['aset_elektronik']['telepon_rumah']) . ' keluarga'" color="green" icon="fas fa-phone" />
        <x-detail-stat-card title="Televisi" :value="number_format($this->statistikDetail['aset_elektronik']['televisi']) . ' keluarga'" color="purple" icon="fas fa-tv" />
        <x-detail-stat-card title="Komputer" :value="number_format($this->statistikDetail['aset_elektronik']['komputer']) . ' keluarga'" color="gray" icon="fas fa-laptop" />
        <x-detail-stat-card title="Smartphone" :value="number_format($this->statistikDetail['aset_elektronik']['smartphone']) . ' keluarga'" color="pink" icon="fas fa-mobile-alt" />
        <x-detail-stat-card title="Rata-rata HP" :value="number_format($this->statistikDetail['aset_elektronik']['rata_rata_hp'], 1) . ' unit'" color="indigo" icon="fas fa-mobile-alt" />
        <x-detail-stat-card title="Rata-rata TV" :value="number_format($this->statistikDetail['aset_elektronik']['rata_rata_tv'], 1) . ' unit'" color="emerald" icon="fas fa-tv" />
      </div>
    </div>

    <!-- Transportasi Tab Content -->
    <div x-show="activeTab === 'aset_transportasi'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <x-detail-stat-card title="Sepeda" :value="number_format($this->statistikDetail['aset_transportasi']['sepeda']) . ' keluarga'" color="green" icon="fas fa-bicycle" />
        <x-detail-stat-card title="Sepeda Motor" :value="number_format($this->statistikDetail['aset_transportasi']['sepeda_motor']) . ' keluarga'" color="blue" icon="fas fa-motorcycle" />
        <x-detail-stat-card title="Mobil" :value="number_format($this->statistikDetail['aset_transportasi']['mobil']) . ' keluarga'" color="red" icon="fas fa-car" />
        <x-detail-stat-card title="Perahu" :value="number_format($this->statistikDetail['aset_transportasi']['perahu']) . ' keluarga'" color="cyan" icon="fas fa-ship" />
        <x-detail-stat-card title="Motor Tempel" :value="number_format($this->statistikDetail['aset_transportasi']['motor_tempel']) . ' keluarga'" color="teal" icon="fas fa-anchor" />
        <x-detail-stat-card title="Perahu Motor" :value="number_format($this->statistikDetail['aset_transportasi']['perahu_motor']) . ' keluarga'" color="indigo" icon="fas fa-water" />
      </div>
    </div>

    <!-- Investasi Tab Content -->
    <div x-show="activeTab === 'aset_investasi'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
        <x-detail-stat-card title="Emas/Perhiasan" :value="number_format($this->statistikDetail['aset_investasi']['emas_perhiasan']) . ' keluarga'" color="yellow" icon="fas fa-gem" />
        <x-detail-stat-card title="Kepemilikan Lahan" :value="number_format($this->statistikDetail['aset_investasi']['lahan']) . ' keluarga'" color="green" icon="fas fa-seedling" />
        <x-detail-stat-card title="Rumah Lain" :value="number_format($this->statistikDetail['aset_investasi']['rumah_lain']) . ' keluarga'" color="blue" icon="fas fa-building" />
        <x-detail-stat-card title="Rata-rata Luas Lahan" :value="number_format($this->statistikDetail['aset_investasi']['rata_rata_luas_lahan'], 0) . ' m²'" color="emerald" icon="fas fa-ruler" />
      </div>
    </div>

    <!-- Ternak Tab Content -->
    <div x-show="activeTab === 'ternak'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <x-detail-stat-card title="Total Sapi" :value="number_format($this->statistikDetail['ternak']['total_sapi']) . ' ekor'" color="amber" icon="fas fa-cow" />
        <x-detail-stat-card title="Total Kerbau" :value="number_format($this->statistikDetail['ternak']['total_kerbau']) . ' ekor'" color="gray" icon="fas fa-hippo" />
        <x-detail-stat-card title="Total Kuda" :value="number_format($this->statistikDetail['ternak']['total_kuda']) . ' ekor'" color="orange" icon="fas fa-horse" />
        <x-detail-stat-card title="Total Babi" :value="number_format($this->statistikDetail['ternak']['total_babi']) . ' ekor'" color="pink" icon="fas fa-pig" />
        <x-detail-stat-card title="Total Kambing" :value="number_format($this->statistikDetail['ternak']['total_kambing']) . ' ekor'" color="green" icon="fas fa-sheep" />
        <x-detail-stat-card title="Pemilik Sapi" :value="number_format($this->statistikDetail['ternak']['pemilik_sapi']) . ' keluarga'" color="yellow" icon="fas fa-users" />
        <x-detail-stat-card title="Pemilik Kambing" :value="number_format($this->statistikDetail['ternak']['pemilik_kambing']) . ' keluarga'" color="teal" icon="fas fa-users" />
      </div>
    </div>

    <!-- Kesehatan Tab Content -->
    <div x-show="activeTab === 'kesehatan'" x-transition>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <x-detail-stat-card title="Cakupan KB" :value="number_format($this->statistikDetail['kesehatan']['cakupan_kb'], 1) . '%'" color="red" icon="fas fa-heartbeat" />
        <x-detail-stat-card title="Balita Gizi Buruk" :value="number_format($this->statistikDetail['kesehatan']['balita_gizi_buruk']) . ' anak'" color="red" icon="fas fa-exclamation-triangle" />
        <x-detail-stat-card title="Balita Stunting" :value="number_format($this->statistikDetail['kesehatan']['balita_stunting']) . ' anak'" color="orange" icon="fas fa-child" />
      </div>
    </div>
  </div>
</div>
