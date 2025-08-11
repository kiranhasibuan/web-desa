@props(['id', 'title', 'hasData' => true, 'class' => ''])

<div class="{{ $class }} rounded-lg bg-white p-6 shadow">
  <h3 class="mb-4 text-lg font-medium text-gray-900">{{ $title }}</h3>

  @if ($hasData)
    <div id="{{ $id }}" class="h-64 w-full"></div>
  @else
    <div class="flex h-64 w-full items-center justify-center">
      <div class="text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
        <p class="mt-1 text-sm text-gray-500">Data akan muncul setelah tersedia.</p>
      </div>
    </div>
  @endif
</div>
