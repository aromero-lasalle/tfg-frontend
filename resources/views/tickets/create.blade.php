<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white p-8 rounded shadow">
            <h1 class="text-3xl font-bold mb-6">Crear Ticket</h1>

            <form action="/tickets" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-bold mb-1">Título</label>
                    <input type="text" name="titulo" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-1">Descripción</label>
                    <textarea name="descripcion" class="w-full border rounded p-2" rows="5" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-1">Prioridad</label>
                    <select name="prioridad" class="w-full border rounded p-2" required>
                        <option value="baja">Baja</option>
                        <option value="media" selected>Media</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>

                @if(auth()->user()->rol === 'admin')
                    <div class="mb-6">
                        <label class="block font-bold mb-1">Técnico asignado</label>
                        <select name="user_id" class="w-full border rounded p-2">
                            <option value="">Sin asignar</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Guardar ticket
                </button>

                <a href="/tickets" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Volver al listado
                </a>
            </form>
        </div>
    </div>
</x-app-layout>