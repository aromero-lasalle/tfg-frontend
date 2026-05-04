<x-app-layout>
    <div class="max-w-6xl mx-auto py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-4 sm:p-8 rounded shadow">

            <h1 class="text-2xl sm:text-3xl font-bold mb-6">Listado de Tickets</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 flex flex-col sm:flex-row gap-2">
                <a href="/tickets/create" class="bg-blue-600 text-white px-4 py-2 rounded text-center">
                    Crear nuevo ticket
                </a>

                <a href="/dashboard" class="bg-gray-700 text-white px-4 py-2 rounded text-center">
                    Ver dashboard
                </a>

                @if(auth()->user()->rol === 'admin')
                    <a href="/tickets/sin-asignar" class="bg-purple-600 text-white px-4 py-2 rounded text-center">
                        Tickets sin asignar
                    </a>
                @endif
            </div>

            <form action="/tickets" method="GET" class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <input
                    type="text"
                    name="buscar"
                    value="{{ $buscar }}"
                    placeholder="Buscar ticket..."
                    class="border rounded p-2 w-full"
                >

                <select name="estado" class="border rounded p-2 w-full">
                    <option value="">Todos los estados</option>
                    <option value="nuevo" {{ $estado == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                    <option value="en_curso" {{ $estado == 'en_curso' ? 'selected' : '' }}>En curso</option>
                    <option value="resuelto" {{ $estado == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                    <option value="cerrado" {{ $estado == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                </select>

                <select name="prioridad" class="border rounded p-2 w-full">
                    <option value="">Todas las prioridades</option>
                    <option value="alta" {{ $prioridad == 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="media" {{ $prioridad == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="baja" {{ $prioridad == 'baja' ? 'selected' : '' }}>Baja</option>
                </select>

                <select name="user_id" class="border rounded p-2 w-full" {{ auth()->user()->rol !== 'admin' ? 'disabled' : '' }}>
                    <option value="">Todos los técnicos</option>

                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">
                    Filtrar
                </button>
            </form>

            @forelse($tickets as $ticket)
                <div class="border rounded p-4 sm:p-5 mb-4">
                    <h2 class="text-lg sm:text-xl font-bold break-words">
                        {{ $ticket->titulo }}
                    </h2>

                    <p class="mt-2 break-words">{{ $ticket->descripcion }}</p>

                    <div class="mt-4 space-y-1 text-sm sm:text-base">
                        <p>
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

                        <p class="text-sm text-gray-600">
                            <strong>Creado el:</strong>
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </p>

                        <p>
                            <strong>Técnico asignado:</strong>
                            {{ $ticket->user ? $ticket->user->name : 'Sin asignar' }}
                        </p>

                        <p>
                            <strong>Asignado por:</strong>
                            {{ $ticket->assignedBy ? $ticket->assignedBy->name : 'Sin asignar' }}
                        </p>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:flex gap-2">
                        <a href="/tickets/{{ $ticket->id }}" class="bg-gray-700 text-white px-3 py-2 rounded text-center">
                            Ver
                        </a>

                        <a href="/tickets/{{ $ticket->id }}/edit" class="bg-blue-600 text-white px-3 py-2 rounded text-center">
                            Editar
                        </a>

                        @if($ticket->estado != 'cerrado')
                            <form action="/tickets/{{ $ticket->id }}/cerrar" method="POST">
                                @csrf
                                <button class="bg-red-600 text-white px-3 py-2 rounded w-full sm:w-auto">
                                    Cerrar
                                </button>
                            </form>
                        @else
                            <form action="/tickets/{{ $ticket->id }}/reabrir" method="POST">
                                @csrf
                                <button class="bg-green-600 text-white px-3 py-2 rounded w-full sm:w-auto">
                                    Reabrir
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->rol === 'admin')
                            <form action="/tickets/{{ $ticket->id }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este ticket?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-black text-white px-3 py-2 rounded w-full sm:w-auto">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p>No hay tickets registrados.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>