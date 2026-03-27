<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.welcome') }} - Систем за управување со флота</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                <h1 class="text-2xl md:text-3xl font-bold text-center text-blue-600 mb-8">Логирај се</h1>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm md:text-base">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 font-bold mb-2 text-sm md:text-base">
                            {{ __('messages.username') }}
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="w-full px-4 py-2 text-sm md:text-base border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            value="{{ old('username') }}"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-bold mb-2 text-sm md:text-base">
                            {{ __('messages.password') }}
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-2 text-sm md:text-base border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            required
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 text-sm md:text-base"
                    >
                        {{ __('messages.welcome') }}
                    </button>
                </form>

                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded text-xs md:text-sm text-gray-700">
                    <p class="font-bold mb-2">Демо пристап:</p>
                    <p><strong>Администратор:</strong></p>
                    <p>Корисничко име: admin</p>
                    <p>Лозинка: password</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
