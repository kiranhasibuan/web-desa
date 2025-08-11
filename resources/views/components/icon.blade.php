<!-- resources/views/components/icon.blade.php -->
@props(['name', 'class' => 'w-5 h-5'])

@php
  $iconMap = [
      'users' => 'fas fa-users',
      'home' => 'fas fa-home',
      'user-male' => 'fas fa-male',
      'user-female' => 'fas fa-female',
      'chart' => 'fas fa-chart-bar',
      'user' => 'fas fa-user',
      'check' => 'fas fa-check-circle',
      'refresh' => 'fas fa-sync-alt',
      'age' => 'fas fa-birthday-cake',
      'gender' => 'fas fa-venus-mars',
      'health' => 'fas fa-heartbeat',
      'electricity' => 'fas fa-bolt',
      'education' => 'fas fa-graduation-cap',
      'work' => 'fas fa-briefcase',
      'house' => 'fas fa-home',
      'contraception' => 'fas fa-shield-alt',
      'analytics' => 'fas fa-analytics',
      'statistics' => 'fas fa-chart-line',
  ];

  $iconClass = $iconMap[$name] ?? 'fas fa-circle';
@endphp

<i {{ $attributes->merge(['class' => $iconClass . ' ' . $class]) }}></i>
