<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Систем за управување со флота'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Mobile Menu Button -->
    <div id="mobileMenuBtn" class="md:hidden fixed bottom-4 right-4 z-50">
        <button onclick="toggleMenu()" class="bg-blue-900 text-white p-4 rounded-full shadow-lg">
            <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Top Navigation -->
    <nav class="bg-blue-900 text-white p-4 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-xl md:text-2xl font-bold">
                <a href="{{ route('dashboard') }}">{{ __('Систем за флота') }}</a>
            </div>
            <div class="flex gap-2 md:gap-4 items-center">
                @auth
                    <span class="text-sm md:text-base">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 px-3 md:px-4 py-2 rounded hover:bg-red-700 text-sm md:text-base">
                            {{ __('Одјави се') }}
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 px-4">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-4">
            @auth
                <!-- Sidebar - Hidden on mobile, visible on md and up -->
                <aside id="sidebar" class="hidden md:block w-full md:w-48 bg-white p-4 rounded shadow">
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">
                            {{ __('Почетна') }}
                        </a>
                        @if (auth()->user()->isSuperAdmin())
                            <a href="{{ route('companies.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">
                                {{ __('Компании') }}
                            </a>
                        @elseif(auth()->user()->isDriver())
                            <h3 class="font-semibold text-gray-700 mt-4 mb-2">{{ __('Мое работно место') }}</h3>
                            <a href="{{ route('driver.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm font-bold text-blue-600">
                                📋 {{ __('Мои Тури') }}
                            </a>
                            <a href="{{ route('expenses.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                💰 {{ __('Мои издатоци') }}
                            </a>
                        @elseif(auth()->user()->company_id)
                            <h3 class="font-semibold text-gray-700 mt-4 mb-2">{{ __('Флота') }}</h3>
                            <a href="{{ route('trucks.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                {{ __('Камиони') }}
                            </a>
                            <a href="{{ route('trailers.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                {{ __('Приколки') }}
                            </a>
                            
                            <h3 class="font-semibold text-gray-700 mt-4 mb-2">{{ __('Управување') }}</h3>
                            <a href="{{ route('drivers.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                {{ __('Возачи') }}
                            </a>
                            <a href="{{ route('tours.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                {{ __('Тури') }}
                            </a>
                            <a href="{{ route('partners.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                {{ __('Партнери') }}
                            </a>
                            
                            <h3 class="font-semibold text-gray-700 mt-4 mb-2">{{ __('Финансии') }}</h3>
                            <a href="{{ route('invoices.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                {{ __('Фактури') }}
                            </a>
                            <a href="{{ route('expenses.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-sm">
                                {{ __('Трошоци') }}
                            </a>
                        @endif
                    </nav>
                </aside>

                <!-- Main Content -->
                <main class="flex-1 w-full">
                    @yield('content')
                </main>
            @else
                <main class="flex-1 w-full">
                    @yield('content')
                </main>
            @endauth
        </div>
    </div>

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const menuIcon = document.getElementById('menuIcon');
            const closeIcon = document.getElementById('closeIcon');
            
            sidebar.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }
    </script>
</body>
</html>
