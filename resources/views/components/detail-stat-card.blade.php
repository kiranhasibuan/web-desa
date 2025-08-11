@props(['title', 'value', 'color' => 'indigo', 'icon' => null])

@php
  $colorClasses = [
      'indigo' => 'bg-indigo-500',
      'yellow' => 'bg-yellow-500',
      'red' => 'bg-red-500',
      'orange' => 'bg-orange-500',
      'blue' => 'bg-blue-500',
      'gray' => 'bg-gray-500',
      'green' => 'bg-green-500',
      'purple' => 'bg-purple-500',
      'pink' => 'bg-pink-500',
      'cyan' => 'bg-cyan-500',
      'teal' => 'bg-teal-500',
      'emerald' => 'bg-emerald-500',
  ];

  $iconMap = [
      'indigo' => 'fas fa-check-circle',
      'yellow' => 'fas fa-venus-mars',
      'red' => 'fas fa-heartbeat',
      'orange' => 'fas fa-bolt',
      'blue' => 'fas fa-info-circle',
      'green' => 'fas fa-check',
      'purple' => 'fas fa-star',
      'pink' => 'fas fa-heart',
  ];

  $defaultIcon = $iconMap[$color] ?? 'fas fa-check-circle';
  $displayIcon = $icon ?? $defaultIcon;
@endphp

<div class="rounded-lg bg-white p-6 shadow-lg transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl">
  <div class="flex items-center justify-between">
    <div>
      <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
      <p class="text-2xl font-semibold text-gray-900">{{ $value }}</p>
    </div>
    <div class="{{ $colorClasses[$color] ?? $colorClasses['indigo'] }} flex h-10 w-10 items-center justify-center rounded-lg">
      <i class="{{ $displayIcon }} text-lg text-white"></i>
    </div>
  </div>
</div>
