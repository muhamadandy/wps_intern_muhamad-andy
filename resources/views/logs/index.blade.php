<x-layout>
  {{-- Heading Logs --}}
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-gray-900">Log Harian</h1>
      <a
        href="{{ route("logs.create") }}"
        class="px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800"
      >
        Tambah Log
      </a>
    </div>

    <form method="GET" action="{{ route("logs.index") }}" class="mb-4 flex items-center space-x-2 px-4">
      <select
        name="status"
        class="px-4 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring focus:ring-blue-300"
      >
        <option value="">-- Semua Status --</option>
        <option value="pending" {{ request("status") === "pending" ? "selected" : "" }}>Pending</option>
        <option value="disetujui" {{ request("status") === "disetujui" ? "selected" : "" }}>Disetujui</option>
        <option value="ditolak" {{ request("status") === "ditolak" ? "selected" : "" }}>Ditolak</option>
      </select>
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">Filter</button>
      @if (request()->has("status"))
        <a
          href="{{ route("logs.index") }}"
          class="px-4 py-2 bg-gray-300 text-sm text-gray-800 rounded hover:bg-gray-400"
        >
          Reset
        </a>
      @endif
    </form>

    {{-- Tabel Log --}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($logs as $log)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $log->created_at->format("d M Y H:i") }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                <div class="font-medium text-gray-900">
                  {{ $log->description }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <div class="flex items-center space-x-2">
                  <div class="flex flex-col">
                    <span class="text-xs text-gray-500">
                      {{ $log->original_name }}
                    </span>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{
                    $log->status === "pending"
                      ? "bg-yellow-100 text-yellow-800"
                      : ($log->status === "disetujui"
                        ? "bg-green-100 text-green-800"
                        : "bg-red-100 text-red-800")
                  }}"
                >
                  {{ $log->status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                  <a href="{{ route("logs.show", $log) }}" class="text-blue-600 hover:text-blue-900">Detail</a>

                  @if ($log->status !== "disetujui")
                    <a href="{{ route("logs.edit", $log) }}" class="text-green-600 hover:text-green-900">Edit</a>

                    @if ($log->status !== "ditolak")
                      <form
                        action="{{ route("logs.destroy", $log) }}"
                        method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus log ini?')"
                        class="inline"
                      >
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-0 p-0">
                          Hapus
                        </button>
                      </form>
                    @endif
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-4">
      {{ $logs->links() }}
    </div>
  </div>
</x-layout>
