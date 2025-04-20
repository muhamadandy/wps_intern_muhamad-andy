<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(["resources/css/app.css", "resources/js/app.js"])
  </head>
  <body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">LOGDAY</h2>

      @if (session("success"))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
          {{ session("success") }}
        </div>
      @endif

      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route("login") }}" class="space-y-4">
        @csrf

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            type="email"
            name="email"
            id="email"
            required
            autofocus
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            value="{{ old("email") }}"
          />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            name="password"
            id="password"
            required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>

        <div>
          <button
            type="submit"
            class="w-full bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800 transition duration-150"
          >
            Login
          </button>
        </div>
      </form>
    </div>
  </body>
</html>
