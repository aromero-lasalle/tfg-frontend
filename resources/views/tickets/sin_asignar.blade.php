<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <div class="bg-white p-8 rounded shadow">

            <h1 class="text-3xl font-bold mb-6">Tickets sin asignar</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 flex gap-2 flex-wrap">
                <a href="/tickets" class="bg-gray-700 text-white px-4 py-2 rounded">
                    Volver al listado
                </a>

                <a href="/dashboard" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Ver dashboard
                </a>
            </div>

            @forelse($tickets as $ticket)
                <div class="border rounded p-5 mb-4">
                    <h2 class="text-xl font-bold">{{ $ticket->titulo }}</h2>

                    <p class="mt-2">{{ $ticket->descripcion }}</p>

                    <p class="mt-3">
                        <strong>Estado:</strong>
                        <span class="text-blue-600">Nuevo</span>
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

                    <form method="POST" action="/tickets/{{ $ticket->id }}/asignar" class="mt-4 flex gap-2 flex-wrap">
                        @csrf

                        <select name="tecnico_id" required class="border rounded p-2">
                            <option value="">Seleccionar técnico</option>

                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">
                                    {{ $tecnico->name }} - {{ $tecnico->email }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">
                            Asignar técnico
                        </button>
                    </form>
                </div>
            @empty
                <p>No hay tickets nuevos sin asignar.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>