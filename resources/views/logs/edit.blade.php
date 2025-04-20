<x-layout>
  <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Edit Log Harian</h2>

    <form
      action="{{ route("logs.update", $log) }}"
      method="POST"
      enctype="multipart/form-data"
      class="space-y-6 bg-white p-6 rounded-lg shadow"
    >
      @csrf
      @method("PUT")

      {{-- Deskripsi Aktivitas --}}
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Aktivitas</label>
        <textarea
          name="description"
          id="description"
          rows="4"
          required
          class="w-full p-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
        >
{{ old("description", $log->description) }}</textarea
        >
        @error("description")
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Lampiran --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran Bukti (Opsional)</label>
        <p class="text-xs text-gray-500 mb-2">Format file harus PDF. Ukuran maksimal 2MB.</p>
        @if ($log->attachment)
          <p class="text-sm text-gray-600 mb-2">
            Lampiran saat ini: {{ $log->original_name }}
            <br />
            <a href="{{ route("logs.download", $log) }}" class="text-blue-600 hover:underline font-medium" download>
              Download
            </a>
          </p>
        @endif

        <input
          type="file"
          name="attachment"
          class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
        />
        @error("attachment")
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Feedback Penolakan --}}
      @if ($log->status === "ditolak" && $log->feedback)
        <div class="mb-6">
          <h3 class="text-sm font-medium text-gray-500">Alasan Penolakan</h3>
          <div class="mt-2 p-4 bg-red-50 border border-red-200 rounded-md">
            <p class="text-sm text-red-800">{{ $log->feedback }}</p>
          </div>
        </div>
      @endif

      {{-- Tombol Aksi --}}
      <div class="flex justify-end space-x-2 pt-4">
        <a
          href="{{ route("logs.index") }}"
          class="inline-flex items-center px-4 py-2 text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md"
        >
          Batal
        </a>
        <button
          type="submit"
          class="px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800"
        >
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</x-layout>
