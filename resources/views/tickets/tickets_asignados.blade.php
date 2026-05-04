<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <div class="bg-white p-8 rounded shadow">

            <h1 class="text-3xl font-bold mb-6">Tickets asignados</h1>

            <div class="mb-6">
                <a href="/dashboard" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Volver al panel
                </a>
            </div>

            @forelse($tickets as $ticket)
                <div class="border rounded p-5 mb-4">
                    <h2 class="text-xl font-bold">{{ $ticket->titulo }}</h2>

                    <p class="text-sm text-gray-600 mt-2">
                        <strong>Creado el:</strong>
                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </p>

                    <p class="mt-2">{{ $ticket->descripcion }}</p>

                    <p class="mt-3">
                        <strong>Estado:</strong>

                        @if($ticket->estado == 'nuevo')
                            <span class="text-blue-600">Nuevo</span>
                        @elseif($ticket->estado == 'en_curso')
                            <span class="text-yellow-600">En curso</span>
                        @elseif($ticket->estado == 'resuelto')
                            <span class="text-green-600">Resuelto</span>
                        @elseif($ticket->estado == 'cerrado')
                            <span class="text-red-600">Cerrado</span>
                        @endif
                    </p>

                    <p>
                        <strong>Prioridad:</strong>

                        @if($ticket->prioridad == 'alta')
                            <span class="text-red-600">Alta</span>
                        @elseif($ticket->prioridad == 'media')
                            <span class="text-yellow-500">Media</span>
                        @else
                            <span class="text-green-600">Baja</span>
                        @endif
                    </p>

                    <p>
                        <strong>Creado por:</strong>
                        {{ $ticket->creator ? $ticket->creator->name : 'Sin registrar' }}
                    </p>

                    <p>
                        <strong>Asignado por:</strong>
                        {{ $ticket->assignedBy ? $ticket->assignedBy->name : 'Sin asignar' }}
                    </p>

                    <div class="mt-4">
                        <a href="/tickets/{{ $ticket->id }}" class="bg-gray-700 text-white px-3 py-2 rounded">
                            Ver
                        </a>
                    </div>
                </div>
            @empty
                <p>No tienes tickets asignados.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>