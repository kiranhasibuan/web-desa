@props(['title', 'value', 'color' => 'blue', 'icon' => 'chart'])

@php
  $colorClasses = [
      'blue' => 'text-blue-500',
      'green' => 'text-green-500',
      'purple' => 'text-purple-500',
      'pink' => 'text-pink-500',
      'indigo' => 'text-indigo-500',
      'yellow' => 'text-yellow-500',
      'red' => 'text-red-500',
      'orange' => 'text-orange-500',
  ];

  $iconMap = [
      'users' => 'fas fa-users',
      'home' => 'fas fa-home',
      'user-male' => 'fas fa-mars',
      'user-female' => 'fas fa-venus',
      'chart' => 'fas fa-chart-bar',
      'user' => 'fas fa-user',
      'analytics' => 'fas fa-chart-line',
  ];

  $iconClass = $iconMap[$icon] ?? 'fas fa-chart-bar';
@endphp

{{-- <div class="group rounded-xl bg-white p-6 shadow-lg transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl">
  <div class="flex items-center">
    <div class="flex-shrink-0">
      <div class="flex h-16 w-16 items-center justify-center rounded-md bg-white">
        <div class="icon-box"><i class="{{ $iconClass }} {{ $colorClasses[$color] ?? $colorClasses['blue'] }} text-4xl"></i></div>
      </div>
    </div>
    <div class="ml-5 flex-1">
      <dl>
        <dt class="text-md truncate font-bold text-gray-600">{{ $title }}</dt>
        <dd class="text-3xl font-extrabold text-gray-900">{{ number_format($value) }}</dd>
      </dl>
    </div>
  </div>
</div> --}}

<div class="industries-block-two">
  <div class="inner-box group transition duration-300 ease-in-out hover:bg-gray-800">
    <div class="icon-box text-gray-600 transition duration-300 ease-in-out group-hover:text-white"><i class="{{ $iconClass }}"></i></div>
    <dt class="text-md truncate font-bold text-gray-600 transition duration-300 ease-in-out group-hover:text-white">{{ $title }}</dt>
    <dd class="text-4xl font-extrabold text-gray-900 transition duration-300 ease-in-out group-hover:text-white">{{ number_format($value) }}</dd>
  </div>
</div>
