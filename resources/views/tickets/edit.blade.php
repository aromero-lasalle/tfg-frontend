<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white p-8 rounded shadow">

            <h1 class="text-3xl font-bold mb-6">Editar Ticket</h1>

            <form action="/tickets/{{ $ticket->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-bold mb-1">Título</label>
                    <input
                        type="text"
                        name="titulo"
                        value="{{ $ticket->titulo }}"
                        class="w-full border rounded p-2"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-1">Descripción</label>
                    <textarea
                        name="descripcion"
                        class="w-full border rounded p-2"
                        rows="5"
                        required
                    >{{ $ticket->descripcion }}</textarea>
                </div>

                <!-- ESTADO -->
                <div class="mb-4">
                    <label class="block font-bold mb-1">Estado</label>
                    <select name="estado" class="w-full border rounded p-2" required>

                        <option value="nuevo" {{ $ticket->estado == 'nuevo' ? 'selected' : '' }}>
                            Nuevo
                        </option>

                        <option value="en_curso" {{ $ticket->estado == 'en_curso' ? 'selected' : '' }}>
                            En curso
                        </option>

                        <option value="resuelto" {{ $ticket->estado == 'resuelto' ? 'selected' : '' }}>
                            Resuelto
                        </option>

                        <option value="cerrado" {{ $ticket->estado == 'cerrado' ? 'selected' : '' }}>
                            Cerrado
                        </option>

                    </select>
                </div>

                <!-- PRIORIDAD -->
                <div class="mb-4">
                    <label class="block font-bold mb-1">Prioridad</label>
                    <select name="prioridad" class="w-full border rounded p-2" required>
                        <option value="baja" {{ $ticket->prioridad == 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ $ticket->prioridad == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ $ticket->prioridad == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>

                <!-- ASIGNACIÓN -->
                @if(auth()->user()->rol === 'admin')
                    <div class="mb-6">
                        <label class="block font-bold mb-1">Técnico asignado</label>
                        <select name="user_id" class="w-full border rounded p-2">
                            <option value="">Sin asignar</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $ticket->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Actualizar ticket
                </button>

                <a href="/tickets" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Volver
                </a>

            </form>

        </div>
    </div>
</x-app-layout>