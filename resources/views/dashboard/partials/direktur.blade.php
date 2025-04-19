<div class="bg-gray-100 min-h-screen">
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-5 sm:px-6 mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Jumlah Manager</dt>
                <dd class="text-2xl font-semibold text-gray-900">
                  {{ $divisions->where("level", "manager")->sum("users_count") }}
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Jumlah Staff</dt>
                <dd class="text-2xl font-semibold text-gray-900">
                  {{ $divisions->where("level", "staff")->sum("users_count") }}
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
