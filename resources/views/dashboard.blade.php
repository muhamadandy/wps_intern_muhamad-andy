{{-- resources/views/dashboard.blade.php --}}
<x-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Dashboard</h2>
  </x-slot>

  @php
    $user = Auth::user();
    $level = $user?->position?->level ?? "";
  @endphp

  <div class="p-4">
    @if ($level === "direktur")
      @include("dashboard.partials.direktur")
    @elseif ($level === "manager")
      @include("dashboard.partials.manager")
    @elseif ($level === "staff")
      @include("dashboard.partials.staff")
    @else
      <p class="text-red-500">Level tidak dikenali.</p>
    @endif
  </div>
</x-layout>
