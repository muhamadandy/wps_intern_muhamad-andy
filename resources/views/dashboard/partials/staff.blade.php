<div>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Dashboard Header -->
    <div class="px-4 py-5 sm:px-6">
      <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
    </div>

    <!-- Stats -->
    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
      <!-- Pending -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
              <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                ></path>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                <dd class="text-2xl font-semibold text-gray-900">{{ $logStats["pending"] }}</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Disetujui -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
              <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Disetujui</dt>
                <dd class="text-2xl font-semibold text-gray-900">{{ $logStats["disetujui"] }}</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Ditolak -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
              <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Ditolak</dt>
                <dd class="text-2xl font-semibold text-gray-900">{{ $logStats["ditolak"] ?? 0 }}</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Logs -->
    <div class="mt-8">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-gray-900">Log Harian Terbaru</h2>
        <a
          href="{{ route("logs.index") }}"
          class="text-sm font-medium text-blue-600 hover:text-blue-500 cursor-pointer"
        >
          Lihat semua
        </a>
      </div>
      <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-md">
        @forelse ($logs->take(3) as $log)
          <div class="block hover:bg-gray-50 transition duration-150 ease-in-out">
            <div class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between">
                <div class="truncate">
                  <p class="font-medium text-gray-900 truncate">
                    {{ $log->description }}
                  </p>
                  <p class="text-sm text-gray-500 truncate">
                    {{ $log->original_name }}
                  </p>
                  <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"
                      />
                    </svg>
                    <p>
                      {{ $log->created_at->format("d M Y H:i") }}
                    </p>
                  </div>
                </div>
                <span
                  class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{
                    $log->status === "pending"
                      ? "bg-yellow-100 text-yellow-800"
                      : ($log->status === "disetujui"
                        ? "bg-green-100 text-green-800"
                        : "bg-red-100 text-red-800")
                  }}"
                >
                  {{ ucfirst($log->status) }}
                </span>
              </div>
            </div>
          </div>
        @empty
          <li class="px-4 py-4 text-sm text-gray-500">Belum ada log harian.</li>
        @endforelse
      </div>
    </div>
  </div>
</div>
