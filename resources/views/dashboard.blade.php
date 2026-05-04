<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard de Tickets
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- BOTONES -->
            <div class="mb-6">
                <a href="/tickets" class="px-4 py-2 bg-blue-600 text-white rounded">Ir al listado</a>
                <a href="/tickets/create" class="px-4 py-2 bg-gray-500 text-white rounded">Crear ticket</a>
            </div>

            <!-- TARJETAS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-gray-500">Total de tickets</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $total }}</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-gray-500">Tickets abiertos</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $abiertos }}</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-gray-500">Tickets cerrados</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $cerrados }}</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-gray-500">Prioridad alta</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $prioridadAlta }}</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-gray-500">Prioridad media</h3>
                    <p class="text-3xl font-bold text-yellow-500">{{ $prioridadMedia }}</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-gray-500">Prioridad baja</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $prioridadBaja }}</p>
                </div>

            </div>

            <!-- ÚLTIMOS TICKETS -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Últimos tickets</h3>

                @forelse($ultimosTickets as $ticket)
                    <div class="border-b py-3">
                        <strong>{{ $ticket->titulo }}</strong><br>

                        <span>
                            Estado:
                            <span class="{{ $ticket->estado == 'abierto' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($ticket->estado) }}
                            </span>
                        </span>
                        <br>

                        <span>
                            Prioridad:
                            <span class="
                                @if($ticket->prioridad == 'alta') text-red-600
                                @elseif($ticket->prioridad == 'media') text-yellow-500
                                @else text-green-600
                                @endif
                            ">
                                {{ ucfirst($ticket->prioridad) }}
                            </span>
                        </span>
                        <br>

                        <span>
                            Técnico:
                            {{ $ticket->user ? $ticket->user->name : 'Sin asignar' }}
                        </span>
                    </div>
                @empty
                    <p>No hay tickets recientes.</p>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>