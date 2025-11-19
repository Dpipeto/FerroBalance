<nav class="bg-blue-700 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('inicio') }}" class="text-2xl font-bold tracking-wide hover:text-blue-200 transition">
                    FerroBalance
                </a>
            </div>

            {{-- Links Desktop --}}
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('inicio') }}" class="hover:text-blue-200 transition">Inicio</a>
                <a href="{{ route('registro') }}" class="hover:text-blue-200 transition">Registro</a>
                <a href="{{ route('productos') }}" class="hover:text-blue-200 transition">Productos</a>
                <a href="{{ route('facturas') }}" class="hover:text-blue-200 transition">Facturas</a>

                @guest
                    <a href="{{ route('login') }}" class="hover:text-blue-200 transition">Login</a>
                @endguest

                @auth
                    <span class="ml-4">👤 {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                        @csrf
                        <button type="submit" class="hover:text-blue-200 transition">Cerrar sesión</button>
                    </form>
                @endauth
            </div>

            {{-- Botón menú móvil --}}
            <div class="md:hidden">
                <button id="menu-toggle" class="focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú móvil --}}
    <div id="mobile-menu" class="hidden md:hidden bg-blue-600">
        <a href="{{ route('inicio') }}" class="block px-4 py-2 hover:bg-blue-500">Inicio</a>
        <a href="{{ route('registro') }}" class="block px-4 py-2 hover:bg-blue-500">Registro</a>
        <a href="{{ route('productos') }}" class="block px-4 py-2 hover:bg-blue-500">Productos</a>
        <a href="{{ route('facturas') }}" class="block px-4 py-2 hover:bg-blue-500">Facturas</a>

        @guest
            <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-blue-500">Login</a>
        @endguest

        @auth
            <span class="block px-4 py-2">👤 {{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-blue-500">Cerrar sesión</button>
            </form>
        @endauth
    </div>

    {{-- Script para abrir/cerrar menú móvil --}}
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</nav>
