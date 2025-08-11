<?php

use Livewire\Volt\Component;
use App\Models\ProfilDesa;

new class extends Component {
    public function with()
    {
        return [
            'profilDesa' => ProfilDesa::first(),
        ];
    }
}; ?>

@if ($profilDesa && !empty($profilDesa->sambutan_kepdes))
  <section class="py-6 sm:py-6 lg:py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="relative overflow-hidden rounded-3xl bg-[#eff2e6] p-8 lg:p-14">
        <div class="absolute inset-0 opacity-10">
          <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-[#45a735]"></div>
          <div class="absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-green-400"></div>
        </div>
        <div class="relative">
          <div class="text-center lg:flex lg:items-center lg:space-x-12 lg:text-left">
            <div class="mb-8 flex-shrink-0 text-center lg:mb-0 lg:text-left">
              @if ($profilDesa->getFirstMediaUrl('foto_kepdes'))
                <img src="{{ $profilDesa->getFirstMediaUrl('foto_kepdes', 'medium') }}" alt="Foto {{ $profilDesa->nama_kepdes }}"
                     class="mx-auto h-24 w-24 rounded-full border-4 border-white object-cover shadow-xl lg:mx-0 lg:h-64 lg:w-64">
              @else
                <div
                     class="mx-auto flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-[#eff2e6] shadow-xl lg:mx-0 lg:h-64 lg:w-64">
                  <svg class="h-12 w-12 text-[#45a735] lg:h-32 lg:w-32" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                  </svg>
                </div>
              @endif
            </div>
            <div class="flex-1">
              <svg class="mx-auto mb-4 h-8 w-8 text-[#45a735] lg:mx-0" fill="currentColor" viewBox="0 0 32 32">
                <path
                      d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
              </svg>

              <div class="mb-6">
                @if ($profilDesa->sambutan_kepdes)
                  <p class="text-lg font-light leading-relaxed text-gray-700 lg:text-xl">
                    {!! $profilDesa->sambutan_kepdes !!}
                  </p>
                @else
                  <p class="text-lg font-light leading-relaxed text-gray-700 lg:text-xl">
                    Selamat datang di website resmi Desa {{ $profilDesa->nama_desa }}. Kami berkomitmen untuk memberikan pelayanan terbaik kepada
                    masyarakat.
                  </p>
                @endif
              </div>

              <!-- Author -->
              <div>
                <h4 class="text-2xl font-semibold text-gray-900">
                  {{ $profilDesa->nama_kepdes ?? 'Kepala Desa' }}
                </h4>
                <p class="font-medium text-[#45a735]">
                  Kepala Desa {{ $profilDesa->nama_desa }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
