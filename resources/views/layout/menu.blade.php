<nav class="bg-blue-700 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('inicio') }}" class="text-2xl font-bold tracking-wide hover:text-blue-200 transition">
                    FerroBalance
                </a>
            </div>

            {{-- Menú escritorio --}}
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('inicio') }}" class="hover:text-blue-200 transition">Inicio</a>
                <a href="{{ route('productos.index') }}" class="hover:text-blue-200 transition">Productos</a>

                @auth
                    {{-- Facturas solo para roles internos --}}
                    @if(auth()->user()->role->Name === 'Cajero' || auth()->user()->role->Name === 'Almacenista' || auth()->user()->role->Name === 'Administrador')
                        <a href="{{ route('facturas.index') }}" class="hover:text-blue-200 transition">Facturas</a>
                    @endif

                    {{-- Carrito solo para clientes --}}
                    @if(auth()->user()->role->Name === 'Cliente')
                        <a href="{{ route('compras.index') }}" class="hover:text-blue-200 transition flex items-center">
                            <img src="{{ asset('images/carrito.png') }}" class="w-6 h-6 mr-1" alt="Carrito">
                            Compras
                        </a>
                    @endif

                    {{-- Dashboard solo para administrador --}}
                    @if(auth()->user()->role->Name === 'Administrador')
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-200 transition">📊 Dashboard</a>
                    @endif

                    <span class="mr-4">
                        {{ auth()->user()->FirstName }}
                        ({{ auth()->user()->role->Name ?? 'Sin rol' }})
                    </span>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200 transition">
                            Cerrar sesión
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('registro') }}" class="hover:text-blue-200 transition">Registro</a>
                    <a href="{{ route('login') }}" class="hover:text-blue-200 transition">Login</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
