<x-app-layout>
    <div class="max-w-6xl mx-auto py-6 sm:py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                    Dashboard de Tickets
                </h1>

                <div class="mt-6 flex flex-col sm:flex-row gap-2">
                    <a href="/tickets" class="bg-blue-600 text-white px-4 py-2 rounded text-center">
                        Ir al listado
                    </a>

                    <a href="/tickets/create" class="bg-gray-600 text-white px-4 py-2 rounded text-center">
                        Crear ticket
                    </a>
                </div>
            </div>

            <div class="text-sm text-gray-900 sm:text-right">
                <p>
                    Usuario:
                    <strong>{{ auth()->user()->name }}</strong>
                </p>

                <p>{{ auth()->user()->email }}</p>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="bg-gray-600 text-white px-4 py-2 rounded">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold text-gray-800">Total de tickets</h2>
                <div class="text-3xl font-bold text-blue-600 mt-3">{{ $total }}</div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold text-gray-800">Tickets abiertos</h2>
                <div class="text-3xl font-bold text-green-600 mt-3">{{ $abiertos }}</div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold text-gray-800">Tickets cerrados</h2>
                <div class="text-3xl font-bold text-red-600 mt-3">{{ $cerrados }}</div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold text-gray-800">Tickets vencidos</h2>
                <div class="text-3xl font-bold text-red-700 mt-3">{{ $vencidos }}</div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold text-gray-800">Prioridad alta</h2>
                <div class="text-3xl font-bold text-red-600 mt-3">{{ $prioridadAlta }}</div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold text-gray-800">Prioridad media</h2>
                <div class="text-3xl font-bold text-yellow-500 mt-3">{{ $prioridadMedia }}</div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold text-gray-800">Prioridad baja</h2>
                <div class="text-3xl font-bold text-green-600 mt-3">{{ $prioridadBaja }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-2xl font-bold mb-5">Distribución por estado</h2>

                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span>Abiertos</span>
                        <span>{{ $abiertos }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-600 h-3 rounded-full"
                             style="width: {{ $total > 0 ? ($abiertos / $total) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1">
                        <span>Cerrados</span>
                        <span>{{ $cerrados }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-red-600 h-3 rounded-full"
                             style="width: {{ $total > 0 ? ($cerrados / $total) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-2xl font-bold mb-5">Distribución por prioridad</h2>

                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span>Alta</span>
                        <span>{{ $prioridadAlta }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-red-600 h-3 rounded-full"
                             style="width: {{ $total > 0 ? ($prioridadAlta / $total) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span>Media</span>
                        <span>{{ $prioridadMedia }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-yellow-500 h-3 rounded-full"
                             style="width: {{ $total > 0 ? ($prioridadMedia / $total) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1">
                        <span>Baja</span>
                        <span>{{ $prioridadBaja }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-600 h-3 rounded-full"
                             style="width: {{ $total > 0 ? ($prioridadBaja / $total) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>