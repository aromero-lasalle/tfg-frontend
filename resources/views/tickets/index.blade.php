<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <div class="bg-white p-8 rounded shadow">

            <h1 class="text-3xl font-bold mb-6">Listado de Tickets</h1>

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

            <div class="mb-6 flex gap-2 flex-wrap">
                <a href="/tickets/create" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Crear nuevo ticket
                </a>

                <a href="/dashboard" class="bg-gray-700 text-white px-4 py-2 rounded">
                    Ver dashboard
                </a>

                @if(auth()->user()->rol === 'admin')
                    <a href="/tickets/sin-asignar" class="bg-purple-600 text-white px-4 py-2 rounded">
                        Tickets sin asignar
                    </a>
                @endif
            </div>

            <form action="/tickets" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input
                    type="text"
                    name="buscar"
                    value="{{ $buscar }}"
                    placeholder="Buscar ticket..."
                    class="border rounded p-2"
                >

                <select name="estado" class="border rounded p-2">
                    <option value="">Todos los estados</option>
                    <option value="nuevo" {{ $estado == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                    <option value="en_curso" {{ $estado == 'en_curso' ? 'selected' : '' }}>En curso</option>
                    <option value="resuelto" {{ $estado == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                    <option value="cerrado" {{ $estado == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                </select>

                <select name="prioridad" class="border rounded p-2">
                    <option value="">Todas las prioridades</option>
                    <option value="alta" {{ $prioridad == 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="media" {{ $prioridad == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="baja" {{ $prioridad == 'baja' ? 'selected' : '' }}>Baja</option>
                </select>

                <select name="user_id" class="border rounded p-2" {{ auth()->user()->rol !== 'admin' ? 'disabled' : '' }}>
                    <option value="">Todos los técnicos</option>

                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Filtrar
                </button>
            </form>

            @forelse($tickets as $ticket)
                <div class="border rounded p-5 mb-4">
                    <h2 class="text-xl font-bold">{{ $ticket->titulo }}</h2>

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

                    <p class="text-sm text-gray-600 mt-2">
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

                    <div class="mt-4 flex gap-2 flex-wrap">
                        <a href="/tickets/{{ $ticket->id }}" class="bg-gray-700 text-white px-3 py-2 rounded">
                            Ver
                        </a>

                        <a href="/tickets/{{ $ticket->id }}/edit" class="bg-blue-600 text-white px-3 py-2 rounded">
                            Editar
                        </a>

                        @if($ticket->estado != 'cerrado')
                            <form action="/tickets/{{ $ticket->id }}/cerrar" method="POST">
                                @csrf
                                <button class="bg-red-600 text-white px-3 py-2 rounded">
                                    Cerrar
                                </button>
                            </form>
                        @else
                            <form action="/tickets/{{ $ticket->id }}/reabrir" method="POST">
                                @csrf
                                <button class="bg-green-600 text-white px-3 py-2 rounded">
                                    Reabrir
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->rol === 'admin')
                            <form action="/tickets/{{ $ticket->id }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este ticket?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-black text-white px-3 py-2 rounded">
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