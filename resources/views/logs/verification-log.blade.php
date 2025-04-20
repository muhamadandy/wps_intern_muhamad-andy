<x-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Verifikasi Log Harian</h1>
          </div>

          <form method="GET" action="{{ route("verifikasi-log") }}" class="mb-4 flex items-center space-x-2">
            <input type="hidden" name="date" value="{{ $date }}" />
            <input
              type="text"
              name="search"
              value="{{ request("search") }}"
              placeholder="Cari nama pegawai..."
              class="w-1/3 px-4 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-300"
            />
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
              Cari
            </button>
            <a
              href="{{ route("verifikasi-log", ["date" => $date]) }}"
              class="px-4 py-2 bg-gray-300 text-sm text-gray-800 rounded hover:bg-gray-400"
            >
              Reset
            </a>
          </form>

          <!-- Logs Table -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Nama Pegawai
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Aktivitas
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Waktu
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Status
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($logs as $log)
                  <tr
                    onclick="window.location='{{ route("logs.show", $log) }}'"
                    class="cursor-pointer hover:bg-gray-50 transition"
                  >
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            {{ $log->user->name ?? "Unknown User" }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ $log->user->email ?? "" }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-900">
                        {{ $log->description }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ $log->original_name }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ $log->created_at->format("d M Y H:i") }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{
                          $log->status === "pending"
                            ? "bg-yellow-100 text-yellow-800"
                            : ($log->status === "disetujui"
                              ? "bg-green-100 text-green-800"
                              : "bg-red-100 text-red-800")
                        }}"
                      >
                        {{ ucfirst($log->status) }}
                      </span>

                      @if ($log->is_resubmission && $log->status !== "disetujui")
                        <span
                          class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"
                        >
                          Dikirim Ulang
                        </span>
                      @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      @if ($log->status === "pending")
                        <div x-data="{ showRejectForm: false }" @click.stop>
                          <div x-show="!showRejectForm" class="flex space-x-2">
                            <form
                              onsubmit="return confirm('Apakah Anda yakin?')"
                              action="{{ route("logs.approve", $log) }}"
                              method="POST"
                              @click.stop
                            >
                              @csrf
                              @method("PUT")
                              <button
                                type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-xs"
                              >
                                Setujui
                              </button>
                            </form>

                            <button
                              type="button"
                              @click.stop="showRejectForm = true"
                              class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs"
                            >
                              Tolak
                            </button>
                          </div>

                          <div x-show="showRejectForm" x-transition class="w-full" @click.stop>
                            <form
                              action="{{ route("logs.reject", $log) }}"
                              method="POST"
                              class="flex flex-col"
                              @click.stop
                            >
                              @csrf
                              @method("PUT")
                              <textarea
                                name="feedback"
                                rows="2"
                                placeholder="Masukkan alasan penolakan"
                                required
                                class="w-full text-xs p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-red-300"
                              ></textarea>
                              <div class="flex justify-between space-x-2 mt-2">
                                <button
                                  type="button"
                                  @click="showRejectForm = false"
                                  class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-1 px-2 rounded text-xs"
                                >
                                  Batal
                                </button>
                                <button
                                  type="submit"
                                  class="bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded text-xs"
                                >
                                  Kirim Penolakan
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                      Tidak ada log untuk tanggal ini.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-4">
            {{ $logs->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layout>
