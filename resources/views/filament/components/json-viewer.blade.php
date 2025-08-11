<div class="space-y-2">
  @if ($getState())
    <div class="rounded-lg border border-gray-300 dark:border-gray-600">
      <div class="border-b border-gray-300 bg-gray-50 px-4 py-2 dark:border-gray-600 dark:bg-gray-800">
        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
          Koordinat Polygon (JSON)
        </h4>
      </div>
      <div class="p-4">
        <pre class="overflow-x-auto rounded bg-gray-100 p-4 text-xs dark:bg-gray-900">{{ json_encode($getState(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
      </div>
    </div>
  @else
    <div class="text-sm italic text-gray-500 dark:text-gray-400">
      Belum ada Koordinat Polygon (JSON)
    </div>
  @endif
</div>
