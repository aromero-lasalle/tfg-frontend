<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img 
                            src="{{ asset('media/img/infraticket-logo.svg') }}" 
                            alt="InfraTicket Logo"
                            class="h-10 w-auto"
                        >
                    </a>
                </div>

                <div class="hidden sm:flex sm:ml-10 sm:space-x-8">
                    <a href="/dashboard" class="text-white hover:text-gray-300">
                        Panel
                    </a>

                    @if(auth()->user()->rol === 'admin')
                        <a href="/tickets" class="text-white hover:text-gray-300">
                            Todos los tickets
                        </a>

                        <a href="/tickets/sin-asignar" class="text-white hover:text-gray-300">
                            Sin asignar
                        </a>
                    @endif

                    @if(auth()->user()->rol === 'tecnico')
                        <a href="/tickets-asignados" class="text-white hover:text-gray-300">
                            Tickets asignados
                        </a>

                        <a href="/mis-tickets" class="text-white hover:text-gray-300">
                            Mis tickets creados
                        </a>
                    @endif

                    @if(auth()->user()->rol === 'usuario')
                        <a href="/mis-tickets" class="text-white hover:text-gray-300">
                            Mis tickets
                        </a>

                        <a href="/tickets/create" class="text-white hover:text-gray-300">
                            Crear ticket
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center text-white">
                <span class="mr-4 text-sm">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded text-sm">
                        Cerrar sesión
                    </button>
                </form>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="text-white text-2xl">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" class="sm:hidden bg-gray-900 px-4 pb-4 space-y-3">
        <a href="/dashboard" class="block text-white pt-3">
            Panel
        </a>

        @if(auth()->user()->rol === 'admin')
            <a href="/tickets" class="block text-white">
                Todos los tickets
            </a>

            <a href="/tickets/sin-asignar" class="block text-white">
                Sin asignar
            </a>
        @endif

        @if(auth()->user()->rol === 'tecnico')
            <a href="/tickets-asignados" class="block text-white">
                Tickets asignados
            </a>

            <a href="/mis-tickets" class="block text-white">
                Mis tickets creados
            </a>
        @endif

        @if(auth()->user()->rol === 'usuario')
            <a href="/mis-tickets" class="block text-white">
                Mis tickets
            </a>

            <a href="/tickets/create" class="block text-white">
                Crear ticket
            </a>
        @endif

        <div class="border-t border-gray-700 pt-3 text-white text-sm">
            {{ auth()->user()->name }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded text-sm text-white w-full">
                Cerrar sesión
            </button>
        </form>
    </div>
</nav>