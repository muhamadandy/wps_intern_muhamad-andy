<x-layout>
  <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg p-6">
      <h2 class="text-2xl font-semibold text-gray-900 mb-4">Detail Log Harian</h2>

      {{-- Tanggal --}}
      <div class="mb-4">
        <h3 class="text-sm font-medium text-gray-500">Tanggal</h3>
        <p class="text-base text-gray-900">
          {{ $log->created_at->format("d M Y H:i") }}
        </p>
      </div>

      {{-- Deskripsi Aktivitas --}}
      <div class="mb-4">
        <h3 class="text-sm font-medium text-gray-500">Aktivitas</h3>
        <p class="text-base text-gray-900">{{ $log->description }}</p>
      </div>

      {{-- Bukti / Attachment --}}
      <div class="mb-4">
        <h3 class="text-sm font-medium text-gray-500">Bukti</h3>

        @if ($log->attachment)
          <div class="mt-2">
            <p class="text-sm text-gray-600">
              Nama File:
              <span class="font-medium">
                {{ $log->original_name }}
              </span>
            </p>
            <a
              href="{{ route("logs.download", $log) }}"
              class="inline-block mt-2 px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700"
            >
              Download Bukti
            </a>
          </div>
        @else
          <p class="text-gray-500 italic">Tidak ada bukti terlampir.</p>
        @endif
      </div>

      {{-- Status --}}
      <div class="mb-4">
        <h3 class="text-sm font-medium text-gray-500">Status</h3>
        <span
          class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{
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

      {{-- Riwayat Penolakan --}}
      @if ($log->is_resubmission && $log->revision_history)
        @php
          // Memastikan revision_history adalah array
          $revisionHistory = is_array($log->revision_history) ? $log->revision_history : json_decode($log->revision_history, true);

          // Jika format lama (single associative array), konversi ke array item
          if (isset($revisionHistory["previous_feedback"]) && ! isset($revisionHistory[0])) {
            $revisionHistory = [$revisionHistory];
          }
        @endphp

        <div class="mb-6">
          <h3 class="text-sm font-medium text-gray-500">Riwayat Pengiriman Ulang</h3>
          <div class="mt-2">
            @foreach ($revisionHistory as $index => $revision)
              <div class="p-4 bg-gray-50 border border-gray-200 rounded-md mb-3">
                <div class="flex justify-between items-center mb-2">
                  <span class="font-medium text-sm text-gray-900">Pengiriman Ulang</span>
                  <span class="text-xs text-gray-500">
                    {{ \Carbon\Carbon::parse($revision["resubmitted_at"] ?? now())->format("d M Y H:i") }}
                  </span>
                </div>

                <p class="text-sm text-gray-700 mb-2">
                  <span class="font-medium">Ditolak pada:</span>
                  {{ \Carbon\Carbon::parse($revision["last_rejected_at"] ?? ($revision["rejected_at"] ?? now()))->format("d M Y H:i") }}
                </p>

                <p class="text-sm text-gray-700 mb-2">
                  <span class="font-medium">Alasan penolakan:</span>
                </p>

                <div class="p-3 bg-red-50 border border-red-200 rounded-md">
                  <p class="text-sm text-red-800">
                    {{ $revision["previous_feedback"] ?? ($revision["feedback"] ?? "Tidak ada alasan yang dicatat") }}
                  </p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Feedback Penolakan Saat Ini (jika ditolak) --}}
      @if ($log->status === "ditolak" && $log->feedback)
        <div class="mb-6">
          <h3 class="text-sm font-medium text-gray-500">Alasan Penolakan</h3>
          <div class="mt-2 p-4 bg-red-50 border border-red-200 rounded-md">
            <p class="text-sm text-red-800">{{ $log->feedback }}</p>
          </div>
        </div>
      @endif

      {{-- Tombol Approval untuk Manager --}}
      @php
        $user = Auth::user();
        $level = $user?->position?->level ?? "";
      @endphp

      {{-- Tombol Kembali --}}
      <div class="flex justify-end mt-6">
        @if ($level === "manager")
          <a
            href="{{ url()->previous() }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200"
          >
            Kembali
          </a>
        @elseif ($level === "staff")
          <a
            href="{{ route("logs.index") }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200"
          >
            Kembali
          </a>
        @endif
      </div>
    </div>
  </div>
</x-layout>
