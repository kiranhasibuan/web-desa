<?php
// resources/views/livewire/dashboard-keluarga.blade.php

use Livewire\Attributes\{Layout, Title, Computed};
use Livewire\Volt\Component;
use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

            // Kelompok umur detail
            'kelompok_umur' => [
                '0_4' => (clone $anggota)->usia(0, 4)->count(),
                '5_9' => (clone $anggota)->usia(5, 9)->count(),
                '10_14' => (clone $anggota)->usia(10, 14)->count(),
                '15_19' => (clone $anggota)->usia(15, 19)->count(),
                '20_24' => (clone $anggota)->usia(20, 24)->count(),
                '25_29' => (clone $anggota)->usia(25, 29)->count(),
                '30_34' => (clone $anggota)->usia(30, 34)->count(),
                '35_39' => (clone $anggota)->usia(35, 39)->count(),
                '40_44' => (clone $anggota)->usia(40, 44)->count(),
                '45_49' => (clone $anggota)->usia(45, 49)->count(),
                '50_54' => (clone $anggota)->usia(50, 54)->count(),
                '55_59' => (clone $anggota)->usia(55, 59)->count(),
                '60_64' => (clone $anggota)->usia(60, 64)->count(),
                '65_69' => (clone $anggota)->usia(65, 69)->count(),
                '70_74' => (clone $anggota)->usia(70, 74)->count(),
                '75_plus' => (clone $anggota)->usia(75)->count(),
            ],
        ];
    }

    #[Computed]
    public function pendidikan()
    {
        $data = AnggotaKeluarga::ada()->selectRaw('ijazah, COUNT(*) as total')->whereNotNull('ijazah')->groupBy('ijazah')->orderBy('ijazah')->get();

        if ($data->isEmpty()) {
            return ['categories' => [], 'series' => []];
        }

        $categories = [];
        $series = [];

        foreach ($data as $item) {
            $label = AnggotaKeluarga::LABELS['ijazah'][$item->ijazah] ?? 'Tidak diketahui';
            $categories[] = $label;
            $series[] = (int) $item->total;
        }

        return [
            'categories' => $categories,
            'series' => $series,
        ];
    }

    #[Computed]
    public function pekerjaan()
    {
        $data = AnggotaKeluarga::ada()->where('bekerja', true)->selectRaw('status_kerja, COUNT(*) as total')->whereNotNull('status_kerja')->groupBy('status_kerja')->orderBy('status_kerja')->get();

        if ($data->isEmpty()) {
            return ['categories' => [], 'series' => []];
        }

        $categories = [];
        $series = [];

        foreach ($data as $item) {
            $label = AnggotaKeluarga::LABELS['status_kerja'][$item->status_kerja] ?? 'Tidak diketahui';
            $categories[] = $label;
            $series[] = (int) $item->total;
        }

        return [
            'categories' => $categories,
            'series' => $series,
        ];
    }

    #[Computed]
    public function perumahan()
    {
        // Status Tempat
        $statusTempatData = Keluarga::selectRaw('status_tempat, COUNT(*) as total')->whereNotNull('status_tempat')->groupBy('status_tempat')->orderBy('status_tempat')->get();

        $statusTempat = [];
        foreach ($statusTempatData as $item) {
            $label = Keluarga::LABELS['status_tempat'][$item->status_tempat] ?? 'Tidak diketahui';
            $statusTempat[$label] = (int) $item->total;
        }

        // Jenis Lantai
        $jenisLantaiData = Keluarga::selectRaw('jenis_lantai, COUNT(*) as total')->whereNotNull('jenis_lantai')->groupBy('jenis_lantai')->orderBy('jenis_lantai')->get();

        $jenisLantai = [];
        foreach ($jenisLantaiData as $item) {
            $label = Keluarga::LABELS['jenis_lantai'][$item->jenis_lantai] ?? 'Tidak diketahui';
            $jenisLantai[$label] = (int) $item->total;
        }

        return [
            'status_tempat' => $statusTempat,
            'jenis_lantai' => $jenisLantai,
        ];
    }

    #[Computed]
    public function kesehatan()
    {
        $kontrasepsiData = AnggotaKeluarga::ada()->where('kontrasepsi', true)->whereNotNull('jenis_kontrasepsi')->selectRaw('jenis_kontrasepsi, COUNT(*) as total')->groupBy('jenis_kontrasepsi')->orderBy('jenis_kontrasepsi')->get();

        $kontrasepsi = [];
        foreach ($kontrasepsiData as $item) {
            $label = AnggotaKeluarga::LABELS['jenis_kontrasepsi'][$item->jenis_kontrasepsi] ?? 'Tidak diketahui';
            $kontrasepsi[$label] = (int) $item->total;
        }

        return [
            'kontrasepsi' => $kontrasepsi,
            'gizi_buruk' => AnggotaKeluarga::ada()->where('status_gizi', 1)->count(),
            'stunting' => AnggotaKeluarga::ada()->where('status_gizi', 2)->count(),
        ];
    }
}; ?>

<x-app-layout :title="'Dashboard Keluarga'">
  @volt
    <div class="min-h-screen bg-gray-50">
      <!-- Header -->
      <div class="border-b bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
              <h1 class="text-2xl font-bold text-gray-900">
                <i class="fas fa-tachometer-alt mr-2 text-[#45a735]"></i>
                Dashboard Keluarga
              </h1>

            </div>
            <div class="flex items-center space-x-4">
              <div class="ml-4 flex items-center space-x-2">
                <div>
                  <i class="fas fa-circle animate-pulse text-sm text-green-500"></i>
                </div>
                <span class="text-sm text-gray-500">
                  <span>Live Data dari <a href="https://bakukele.site">Bakukele</a></span>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Stats Cards -->
        <livewire:demografi.stat-card />

        <!-- Statistik Detail -->
        <livewire:demografi.detail-stat-card />

        <!-- Charts Placeholder -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
          <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <div class="">
              <h3 class="flex items-center text-lg font-semibold text-gray-900">
                <i class="fas fa-chart-bar mr-3 text-blue-600"></i>
                Distribusi Jenis Kelamin
              </h3>
              <p class="mt-1 text-sm text-gray-600">
                Perbandingan jumlah penduduk laki-laki dan perempuan
              </p>
            </div>

            <div class="chart-wrapper">
              <div id="chart-jenis-kelamin" class="w-full"></div>
            </div>
          </div>

          <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <div class="">
              <h3 class="flex items-center text-lg font-semibold text-gray-900">
                <i class="fas fa-chart-bar mr-3 text-green-600"></i>
                Distribusi Kelompok Umur
              </h3>
              <p class="mt-1 text-sm text-gray-600">
                Sebaran penduduk berdasarkan kelompok usia
              </p>
            </div>

            <div class="chart-wrapper">
              <div id="chart-kelompok-umur" class="w-full"></div>
            </div>
          </div>

          <div class="col-span-1 rounded-lg bg-white p-6 shadow lg:col-span-2">
            <h3 class="mb-4 flex items-center text-lg font-medium text-gray-900">
              <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
              Tingkat Pendidikan
            </h3>
            <div class="flex h-80 items-center justify-center rounded-lg border-2 border-dashed border-gray-300">
              <div class="text-center">
                <i class="fas fa-graduation-cap mb-2 text-4xl text-gray-400"></i>
                <p class="text-gray-500">Chart pendidikan akan ditampilkan di sini</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @script
        <script>
          const data = {
            kependudukan: @json($this->kependudukan),
            pendidikan: @json($this->pendidikan),
            pekerjaan: @json($this->pekerjaan),
            perumahan: @json($this->perumahan),
            kesehatan: @json($this->kesehatan)
          };

          const jenisKelaminChart = (data) => {
            const options = {
              chart: {
                type: 'donut',
                height: 250
              },
              series: [data.laki_laki, data.perempuan],
              labels: ['Laki-laki', 'Perempuan'],
              colors: ['#3B82F6', '#EC4899'],
              legend: {
                position: 'bottom'
              },
              dataLabels: {
                enabled: true,
                formatter: (val) => Math.round(val) + '%'
              },
              tooltip: {
                y: {
                  formatter: (val) => val.toLocaleString() + ' orang'
                }
              },
              responsive: [{
                breakpoint: 480,
                options: {
                  chart: {
                    height: 200
                  },
                  legend: {
                    position: 'bottom'
                  }
                }
              }]
            };

            chart = new ApexCharts(
              document.querySelector("#chart-jenis-kelamin"),
              options
            );
            chart.render();
          };
          jenisKelaminChart(data.kependudukan);

          const kelompokUmurChart = (data) => {
            const options = {
              chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                  show: false
                }
              },
              series: [{
                name: 'Jumlah Penduduk',
                data: [data['0_4'] || 0, data['5_9'] || 0, data['10_14'] || 0, data['15_19'] || 0, data['20_24'] || 0, data['25_29'] || 0, data[
                  '30_34'] || 0, data['35_39'] || 0, data['40_44'] || 0, data['45_49'] || 0, data['50_54'] || 0, data['55_59'] || 0, data[
                  '60_64'] || 0, data['65_69'] || 0, data['70_74'] || 0, data['75_plus'] || 0]
              }],
              xaxis: {
                categories: ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64', '65-69',
                  '70-74', '75+'
                ],
                labels: {
                  rotate: -45,
                  style: {
                    fontSize: '12px'
                  }
                }
              },
              yaxis: {
                title: {
                  text: 'Jumlah Penduduk'
                },
              },
              colors: ['#10B981'],
              dataLabels: {
                enabled: true,
                formatter: (val) => val > 0 ? val : ''
              },
              tooltip: {
                y: {
                  formatter: (val) => val.toLocaleString() + ' orang'
                }
              },
              responsive: [{
                breakpoint: 768,
                options: {
                  chart: {
                    height: 300
                  },
                  xaxis: {
                    labels: {
                      rotate: -90
                    }
                  },
                  dataLabels: {
                    enabled: false
                  }
                }
              }, {
                breakpoint: 480,
                options: {
                  chart: {
                    height: 250
                  },
                  title: {
                    style: {
                      fontSize: '14px'
                    }
                  }
                }
              }]
            };

            // Hapus chart yang sudah ada jika ada
            const chartElement = document.querySelector("#chart-kelompok-umur");
            if (chartElement) {
              chartElement.innerHTML = '';
            }

            // Buat chart baru
            const chart = new ApexCharts(chartElement, options);
            chart.render();

            return chart;
          };

          // Panggil fungsi dengan data yang benar
          kelompokUmurChart(data.kependudukan.kelompok_umur);
        </script>
      @endscript
    </div>
  @endvolt
</x-app-layout>
