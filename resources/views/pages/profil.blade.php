<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Models\ProfilDesa;
use App\Models\Banner;
use App\Models\StrukturPemerintahan;

new class extends Component {
    public string $title;
    public string $namaDesa;
    public string $namaKabupaten;
    public string $activeSection = 'tentang';

    public function mount()
    {
        $profilDesa = ProfilDesa::first();
        $this->title = 'Profil Desa ' . ($profilDesa->nama_desa ?? 'Website Desa');
        $this->namaDesa = $profilDesa->nama_desa ?? 'Desa';
        $this->namaKabupaten = $profilDesa->nama_kabupaten ?? 'Kabupaten';
    }

    public function setActiveSection($section)
    {
        $this->activeSection = $section;
    }

    public function with()
    {
        $profilDesa = ProfilDesa::first();

        return [
            'banners' => Banner::aktif()->urutan()->with('media')->get(),
            'profilDesa' => $profilDesa,
            'strukturPemerintahan' => StrukturPemerintahan::where('profil_desa_id', $profilDesa->id ?? 0)->get(),
        ];
    }
}; ?>

<x-app-layout :title="'Profil Desa'">
  @volt
    <main class="min-h-screen bg-gray-50">
      <!-- Page Header / Breadcrumb -->
      <section class="">
        <div class="relative overflow-hidden rounded-3xl bg-[#eff2e6] p-8 lg:p-14">
          <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-[#45a735]"></div>
            <div class="absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-green-400"></div>
          </div>
          <div class="relative text-center text-white">
            <h1 class="text-4xl font-bold lg:text-5xl">Profil Desa</h1>
            <nav class="mt-6" aria-label="Breadcrumb">
              <ol class="inline-flex items-center space-x-2 text-lg">
                <li>
                  <a href="{{ url('/') }}" class="text-[#45a735] transition-colors hover:text-white">
                    Beranda
                  </a>
                </li>
                <li class="text-[#45a735]">→</li>
                <li class="font-medium text-[#45a735]">Profil Desa</li>
              </ol>
            </nav>
          </div>
        </div>
      </section>

      <!-- Main Content -->
      <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="grid gap-8 lg:grid-cols-4">

            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
              <div class="sticky top-8 space-y-6">
                <!-- Navigation Menu -->
                <div class="rounded-xl bg-white p-6 shadow-lg">
                  <h3 class="mb-4 text-lg font-bold text-gray-900">Menu Profil</h3>
                  <nav class="space-y-2">
                    <button wire:click="setActiveSection('tentang')"
                            class="{{ $activeSection === 'tentang' ? 'bg-[#45a735] text-white' : 'text-gray-600 hover:bg-gray-100' }} flex w-full items-center rounded-lg px-4 py-3 text-left text-sm font-medium transition-colors">
                      <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Tentang Desa
                    </button>

                    <button wire:click="setActiveSection('visi-misi')"
                            class="{{ $activeSection === 'visi-misi' ? 'bg-[#45a735] text-white' : 'text-gray-600 hover:bg-gray-100' }} flex w-full items-center rounded-lg px-4 py-3 text-left text-sm font-medium transition-colors">
                      <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                      </svg>
                      Visi & Misi
                    </button>

                    <button wire:click="setActiveSection('kepala-desa')"
                            class="{{ $activeSection === 'kepala-desa' ? 'bg-[#45a735] text-white' : 'text-gray-600 hover:bg-gray-100' }} flex w-full items-center rounded-lg px-4 py-3 text-left text-sm font-medium transition-colors">
                      <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                      </svg>
                      Profil Kepala Desa
                    </button>

                    <button wire:click="setActiveSection('struktur')"
                            class="{{ $activeSection === 'struktur' ? 'bg-[#45a735] text-white' : 'text-gray-600 hover:bg-gray-100' }} flex w-full items-center rounded-lg px-4 py-3 text-left text-sm font-medium transition-colors">
                      <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                      </svg>
                      Struktur Pemerintahan
                    </button>

                    <button wire:click="setActiveSection('geografis')"
                            class="{{ $activeSection === 'geografis' ? 'bg-[#45a735] text-white' : 'text-gray-600 hover:bg-gray-100' }} flex w-full items-center rounded-lg px-4 py-3 text-left text-sm font-medium transition-colors">
                      <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>
                      Data Geografis
                    </button>
                  </nav>
                </div>

                <!-- Quick Info Card -->
                @if ($profilDesa)
                  <div class="rounded-xl bg-[#eff2e6] bg-gradient-to-br p-6 text-white shadow-lg">
                    <h4 class="mb-4 text-lg font-bold">Informasi Singkat</h4>
                    <div class="space-y-3 text-sm font-semibold text-gray-800">
                      <div class="flex items-center">
                        <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $profilDesa->nama_kecamatan }}</span>
                      </div>
                      <div class="flex items-center">
                        <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Kode Pos: {{ $profilDesa->kode_pos ?? '-' }}</span>
                      </div>
                      @if ($profilDesa->luas_wilayah)
                        <div class="flex items-center">
                          <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                  clip-rule="evenodd"></path>
                          </svg>
                          <span>Luas: {{ number_format($profilDesa->luas_wilayah, 2) }} km²</span>
                        </div>
                      @endif
                    </div>
                  </div>
                @endif
              </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
              <div class="rounded-xl bg-white p-8 shadow-lg">

                <!-- Tentang Desa Section -->
                @if ($activeSection === 'tentang')
                  <div>
                    <div class="mb-8 border-b border-gray-200 pb-6">
                      <h2 class="text-3xl font-bold text-gray-900">Tentang Desa {{ $namaDesa }}</h2>
                      <p class="mt-2 text-lg text-gray-600">{{ $profilDesa->nama_kabupaten ?? 'Kabupaten' }},
                        {{ $profilDesa->nama_provinsi ?? 'Provinsi' }}</p>
                    </div>

                    @if ($profilDesa && $profilDesa->tentang_desa)
                      <div class="prose max-w-none text-gray-700">
                        {!! $profilDesa->tentang_desa !!}
                      </div>
                    @else
                      <div class="rounded-lg bg-gray-50 p-8 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                          </path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Konten</h3>
                        <p class="mt-2 text-gray-500">Informasi tentang desa belum tersedia.</p>
                      </div>
                    @endif
                  </div>
                @endif

                <!-- Visi Misi Section -->
                @if ($activeSection === 'visi-misi')
                  <div>
                    <div class="mb-8 border-b border-gray-200 pb-6">
                      <h2 class="text-3xl font-bold text-gray-900">Visi & Misi Desa</h2>
                    </div>

                    <div class="flex flex-col items-center">
                      <!-- Visi -->
                      <div class="rounded-lg border border-green-200 bg-green-50 p-6">
                        <h3 class="mb-4 flex items-center text-xl font-bold text-green-800">
                          <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                          </svg>
                          Visi
                        </h3>
                        @if ($profilDesa && $profilDesa->visi)
                          <div class="prose max-w-none text-green-700">
                            {!! $profilDesa->visi !!}
                          </div>
                        @else
                          <p class="text-green-600">Visi desa belum tersedia.</p>
                        @endif
                      </div>

                      <!-- Misi -->
                      <div class="rounded-lg border border-blue-200 bg-blue-50 p-6">
                        <h3 class="mb-4 flex items-center text-xl font-bold text-blue-800">
                          <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                          </svg>
                          Misi
                        </h3>
                        @if ($profilDesa && $profilDesa->misi)
                          <div class="prose max-w-none text-gray-800">
                            {!! $profilDesa->misi !!}
                          </div>
                        @else
                          <p class="text-blue-600">Misi desa belum tersedia.</p>
                        @endif
                      </div>
                    </div>

                  </div>
                @endif

                <!-- Kepala Desa Section -->
                @if ($activeSection === 'kepala-desa')
                  <div>
                    <div class="mb-8 border-b border-gray-200 pb-6">
                      <h2 class="text-3xl font-bold text-gray-900">Kepala Desa</h2>
                    </div>

                    @if ($profilDesa && ($profilDesa->nama_kepdes || $profilDesa->sambutan_kepdes))
                      <div class="lg:flex lg:items-start lg:space-x-8">
                        <!-- Photo -->
                        <div class="mb-6 flex-shrink-0 lg:mb-0">
                          @if ($profilDesa->getFirstMediaUrl('foto_kepdes'))
                            <img src="{{ $profilDesa->getFirstMediaUrl('foto_kepdes', 'large') }}" alt="Foto {{ $profilDesa->nama_kepdes }}"
                                 class="h-64 w-64 rounded-xl object-cover shadow-lg">
                          @else
                            <div class="flex h-64 w-64 items-center justify-center rounded-xl bg-gray-200 shadow-lg">
                              <svg class="h-24 w-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                              </svg>
                            </div>
                          @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                          <div class="mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">
                              {{ $profilDesa->nama_kepdes ?? 'Kepala Desa' }}
                            </h3>
                            <p class="text-lg font-semibold text-[#45a735]">
                              Kepala Desa {{ $namaDesa }}
                            </p>
                          </div>

                          @if ($profilDesa->sambutan_kepdes)
                            <div class="prose max-w-none">
                              <h4 class="mb-4 text-lg font-semibold text-gray-900">Sambutan Kepala Desa</h4>
                              <div class="text-gray-700">
                                {!! $profilDesa->sambutan_kepdes !!}
                              </div>
                            </div>
                          @endif
                        </div>
                      </div>
                    @else
                      <div class="rounded-lg bg-gray-50 p-8 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Profil Kepala Desa</h3>
                        <p class="mt-2 text-gray-500">Informasi kepala desa belum tersedia.</p>
                      </div>
                    @endif
                  </div>
                @endif

                <!-- Struktur Pemerintahan Section -->
                @if ($activeSection === 'struktur')
                  <div>
                    <div class="mb-8 border-b border-gray-200 pb-6">
                      <h2 class="text-3xl font-bold text-gray-900">Struktur Pemerintahan Desa</h2>
                    </div>

                    @if ($strukturPemerintahan->count() > 0)
                      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($strukturPemerintahan as $struktur)
                          <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
                            @if ($struktur->getFirstMediaUrl('foto'))
                              <img src="{{ $struktur->getFirstMediaUrl('foto', 'medium') }}" alt="Foto {{ $struktur->nama }}"
                                   class="mx-auto mb-4 h-24 w-24 rounded-full object-cover">
                            @else
                              <div class="mx-auto mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-200">
                                <svg class="h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                              </div>
                            @endif
                            <div class="text-center">
                              <h4 class="text-lg font-semibold text-gray-900">{{ $struktur->nama }}</h4>
                              <p class="text-sm font-medium text-[#45a735]">{{ $struktur->jabatan }}</p>
                              @if ($struktur->nip)
                                <p class="mt-1 text-xs text-gray-500">NIP: {{ $struktur->nip }}</p>
                              @endif
                            </div>
                          </div>
                        @endforeach
                      </div>
                    @else
                      <div class="rounded-lg bg-gray-50 p-8 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                          </path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Struktur Pemerintahan</h3>
                        <p class="mt-2 text-gray-500">Data struktur pemerintahan desa belum tersedia.</p>
                      </div>
                    @endif
                  </div>
                @endif

                <!-- Data Geografis Section -->
                @if ($activeSection === 'geografis')
                  <div>
                    <div class="mb-8 border-b border-gray-200 pb-6">
                      <h2 class="text-3xl font-bold text-gray-900">Data Geografis</h2>
                    </div>

                    @if ($profilDesa)
                      <div class="space-y-8">
                        <!-- Stats Cards -->
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                          <div class="rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                            <div class="flex items-center">
                              <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                              </svg>
                              <div class="ml-4">
                                <p class="text-blue-100">Luas Wilayah</p>
                                <p class="text-2xl font-bold">{{ $profilDesa->luas_wilayah ? number_format($profilDesa->luas_wilayah, 2) : '0' }} km²
                                </p>
                              </div>
                            </div>
                          </div>

                          <div class="rounded-lg bg-gradient-to-br from-green-500 to-green-600 p-6 text-white">
                            <div class="flex items-center">
                              <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                              </svg>
                              <div class="ml-4">
                                <p class="text-green-100">% Luas Kecamatan</p>
                                <p class="text-2xl font-bold">
                                  {{ $profilDesa->persen_luas_kec ? number_format($profilDesa->persen_luas_kec, 2) : '0' }}%</p>
                              </div>
                            </div>
                          </div>

                          <div class="rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white">
                            <div class="flex items-center">
                              <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                              </svg>
                              <div class="ml-4">
                                <p class="text-purple-100">Jarak ke Kecamatan</p>
                                <p class="text-2xl font-bold">{{ $profilDesa->jarak_kec ?? '0' }} km</p>
                              </div>
                            </div>
                          </div>

                          <div class="rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 p-6 text-white">
                            <div class="flex items-center">
                              <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                              </svg>
                              <div class="ml-4">
                                <p class="text-orange-100">Jarak ke Kabupaten</p>
                                <p class="text-2xl font-bold">{{ $profilDesa->jarak_kab ?? '0' }} km</p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Batas Wilayah -->
                        <div class="rounded-lg border border-gray-200 p-6">
                          <h3 class="mb-4 text-xl font-bold text-gray-900">Batas Wilayah</h3>
                          <div class="grid gap-4 md:grid-cols-2">
                            <div class="flex items-center space-x-3">
                              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                              </div>
                              <div>
                                <p class="font-medium text-gray-900">Utara</p>
                                <p class="text-gray-600">{{ $profilDesa->batas_utara ?? 'Belum diisi' }}</p>
                              </div>
                            </div>

                            <div class="flex items-center space-x-3">
                              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V1"></path>
                                </svg>
                              </div>
                              <div>
                                <p class="font-medium text-gray-900">Selatan</p>
                                <p class="text-gray-600">{{ $profilDesa->batas_selatan ?? 'Belum diisi' }}</p>
                              </div>
                            </div>

                            <div class="flex items-center space-x-3">
                              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100">
                                <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                              </div>
                              <div>
                                <p class="font-medium text-gray-900">Timur</p>
                                <p class="text-gray-600">{{ $profilDesa->batas_timur ?? 'Belum diisi' }}</p>
                              </div>
                            </div>

                            <div class="flex items-center space-x-3">
                              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                </svg>
                              </div>
                              <div>
                                <p class="font-medium text-gray-900">Barat</p>
                                <p class="text-gray-600">{{ $profilDesa->batas_barat ?? 'Belum diisi' }}</p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Koordinat -->
                        @if ($profilDesa->latitude && $profilDesa->longitude)
                          <div class="rounded-lg border border-gray-200 p-6">
                            <h3 class="mb-4 text-xl font-bold text-gray-900">Koordinat Geografis</h3>
                            <div class="grid gap-4 md:grid-cols-2">
                              <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">
                                  <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                  </svg>
                                </div>
                                <div>
                                  <p class="font-medium text-gray-900">Latitude</p>
                                  <p class="font-mono text-gray-600">{{ $profilDesa->latitude }}</p>
                                </div>
                              </div>

                              <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">
                                  <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                  </svg>
                                </div>
                                <div>
                                  <p class="font-medium text-gray-900">Longitude</p>
                                  <p class="font-mono text-gray-600">{{ $profilDesa->longitude }}</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                      </div>
                    @else
                      <div class="rounded-lg bg-gray-50 p-8 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                          </path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Data Geografis</h3>
                        <p class="mt-2 text-gray-500">Data geografis desa belum tersedia.</p>
                      </div>
                    @endif
                  </div>
                @endif

              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  @endvolt
</x-app-layout>
