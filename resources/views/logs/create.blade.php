<x-layout>
  <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-md px-6 py-5">
      <h2 class="text-2xl font-semibold text-gray-900 mb-6">Tambah Log Harian</h2>

      <form action="{{ route("logs.store") }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Deskripsi Aktivitas --}}
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Aktivitas</label>
          <textarea
            name="description"
            id="description"
            rows="4"
            class="mt-1 p-2 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-md"
          >
{{ old("description") }}</textarea
          >
          @error("description")
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Bukti (Attachment) --}}
        <div class="mb-4">
          <label for="attachment" class="block text-sm font-medium text-gray-700">Bukti (opsional)</label>
          <input
            type="file"
            name="attachment"
            id="attachment"
            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
          />
          @error("attachment")
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
          <a
            href="{{ route("logs.index") }}"
            class="mr-4 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200"
          >
            Batal
          </a>
          <button
            type="submit"
            class="px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800"
          >
            Simpan Log
          </button>
        </div>
      </form>
    </div>
  </div>
</x-layout>
