<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Despacho de Componente: {{ $part->part_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-xl rounded-lg">
                <p class="mb-4 text-sm text-gray-600">Stock disponible: <strong>{{ $part->stock }} unidades</strong></p>
                
                <form action="{{ route('parts.dispatch.store', $part) }}" method="POST">
                    @csrf
                    <div class="grid gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Aeronave Destino</label>
                            <select name="aircraft_id" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Selecciona una aeronave --</option>
                                @foreach($aircrafts as $aircraft)
                                    <option value="{{ $aircraft->id }}">
                                        {{ $aircraft->registration }} ({{ $aircraft->model }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold">Cantidad a retirar</label>
                            <input type="number" name="quantity" max="{{ $part->stock }}" min="1" 
                                class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block font-bold">Notas de instalación (Opcional)</label>
                            <textarea name="notes" class="w-full rounded-md border-gray-300"></textarea>
                        </div>
                        <button type="submit" class="bg-green-600 text-white py-2 rounded-md font-bold hover:bg-green-700">
                            Confirmar Salida de Almacén
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>