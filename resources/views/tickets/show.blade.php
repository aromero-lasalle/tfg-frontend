<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <div class="bg-white p-8 rounded shadow">

            <h1 class="text-3xl font-bold mb-4">{{ $ticket->titulo }}</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <p class="mb-4">{{ $ticket->descripcion }}</p>

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

            <p>
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

            <div class="mt-6 flex gap-2 flex-wrap">
                <a href="/tickets" class="bg-gray-700 text-white px-4 py-2 rounded">
                    Volver al listado
                </a>

                <a href="/tickets/{{ $ticket->id }}/edit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Editar
                </a>
            </div>

            <hr class="my-8">

            <h2 class="text-2xl font-bold mb-4">Historial de estados</h2>

            @forelse($ticket->histories as $history)
                <div class="border rounded p-4 mb-3 bg-gray-50">
                    <p>
                        <strong>Cambio:</strong>
                        {{ ucfirst(str_replace('_', ' ', $history->estado_anterior)) }}
                        →
                        {{ ucfirst(str_replace('_', ' ', $history->estado_nuevo)) }}
                    </p>

                    <p class="text-sm text-gray-600">
                        <strong>Realizado por:</strong>
                        {{ $history->user ? $history->user->name : 'Usuario eliminado' }}
                    </p>

                    <p class="text-sm text-gray-600">
                        <strong>Fecha:</strong>
                        {{ $history->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-600">Todavía no hay cambios de estado registrados.</p>
            @endforelse

            <hr class="my-8">

            <h2 class="text-2xl font-bold mb-4">Comentarios</h2>

            @forelse($ticket->comments as $comment)
                <div class="border rounded p-4 mb-4 bg-gray-50">
                    <p class="mb-2">{{ $comment->contenido }}</p>

                    <p class="text-sm text-gray-600">
                        <strong>Comentado por:</strong>
                        {{ $comment->user ? $comment->user->name : 'Usuario eliminado' }}
                    </p>

                    <p class="text-sm text-gray-600">
                        <strong>Fecha:</strong>
                        {{ $comment->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-600">Todavía no hay comentarios.</p>
            @endforelse

            <hr class="my-8">

            <h2 class="text-xl font-bold mb-4">Añadir comentario</h2>

            <form method="POST" action="/tickets/{{ $ticket->id }}/comments">
                @csrf

                <textarea
                    name="contenido"
                    class="w-full border rounded p-3 mb-4"
                    rows="4"
                    placeholder="Escribe un comentario..."
                    required
                ></textarea>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Publicar comentario
                </button>
            </form>

        </div>
    </div>
</x-app-layout>