<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="shrink-0 flex items-center text-white font-bold">
                    Mesa de ayuda
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
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

            <div class="hidden sm:flex sm:items-center sm:ml-6 text-white">
                {{ auth()->user()->name }}

                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button class="bg-red-500 px-3 py-2 rounded">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>