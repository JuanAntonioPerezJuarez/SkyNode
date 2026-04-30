@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Flota</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="font-bold mb-4">Nueva Aeronave</h3>
                <form action="{{ route('aircraft.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4">
                        <input type="text" name="registration" placeholder="Matrícula (XB-XXX)" class="rounded border-gray-300 uppercase" required>
                        <input type="text" name="model" placeholder="Modelo (Cessna 182)" class="rounded border-gray-300" required>
                        <input type="text" name="serial_number" placeholder="Número de Serie" class="rounded border-gray-300">
                        <button class="bg-blue-600 text-white py-2 rounded font-bold">Dar de Alta</button>
                    </div>
                </form>
            </div>

            <div class="md:col-span-2 bg-white p-6 shadow rounded-lg">
                <h3 class="font-bold mb-4">Aeronaves Activas</h3>
                <div class="overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3">Matrícula</th>
                <th class="px-6 py-3">Modelo</th>
                <th class="px-6 py-3">Serie</th>
                <th class="px-6 py-3 text-right">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fleet as $plane)
            <tr class="bg-white border-b hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-bold text-blue-600 uppercase">
                    <a href="{{ route('aircraft.show', $plane->id) }}" class="hover:underline">
                        {{ $plane->registration }}
                    </a>
                </td>
                <td class="px-6 py-4">{{ $plane->model }}</td>
                <td class="px-6 py-4 text-gray-400 italic">{{ $plane->serial_number ?? 'N/A' }}</td>
                <td class="px-6 py-4 text-right">
                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Activo</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
            </div>
        </div>
    </div>
</x-app-layout>