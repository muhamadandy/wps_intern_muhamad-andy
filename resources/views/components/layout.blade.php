<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ env("APP_NAME") }}</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-end items-center space-x-4">
          {{-- Notifikasi Lonceng --}}
          @php
            $user = Auth::user();
            $notifications = $user->unreadNotifications;
            $level = $user->position->level ?? "";
          @endphp

          @if ($level === "staff")
            <div x-data="{ open: false }" class="relative">
              <button @click="open = !open" class="relative focus:outline-none">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                  />
                </svg>
                @if ($notifications->count() > 0)
                  <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
                @endif
              </button>

              {{-- Dropdown Notifikasi --}}
              <div
                x-show="open"
                @click.away="open = false"
                class="absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-md shadow-lg z-50 overflow-hidden"
              >
                <div class="px-4 py-2 font-semibold text-gray-700 border-b">Notifikasi</div>
                @forelse ($notifications as $notification)
                  <div class="px-4 py-2 text-sm text-gray-700 border-b">
                    <p>{{ $notification->data["message"] ?? "Ada notifikasi baru." }}</p>
                    <form
                      method="POST"
                      action="{{ route("notifications.markAsRead", $notification->id) }}"
                      class="mt-1"
                    >
                      @csrf
                      <button type="submit" class="text-xs text-blue-600 hover:underline">Tandai sebagai dibaca</button>
                    </form>
                  </div>
                @empty
                  <div class="px-4 py-2 text-sm text-gray-500">Tidak ada notifikasi baru</div>
                @endforelse
              </div>
            </div>
          @endif

          {{-- User Dropdown --}}
          <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-2 text-sm text-gray-700 focus:outline-none">
              <span>{{ Auth::user()->name }}</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
              x-show="open"
              @click.away="open = false"
              class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1"
            >
              <div class="px-4 py-2 text-sm text-gray-600 border-b">
                {{ Auth::user()->name }}
              </div>

              <a href="{{ route("dashboard") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Dashboard
              </a>

              @if ($level === "staff")
                <a href="{{ route("logs.index") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Log Harian
                </a>
              @endif

              <form method="POST" action="{{ route("logout") }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                  Keluar
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main>
      {{ $slot }}
    </main>
  </body>
</html>
