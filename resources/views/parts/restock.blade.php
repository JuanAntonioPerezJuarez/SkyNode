<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reabastecer Componente: <span class="text-green-600">{{ $part->part_number }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 border-t-4 border-green-500 shadow-xl rounded-lg">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-green-100 rounded-full mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $part->name }}</h3>
                        <p class="text-sm text-gray-500">Stock actual: {{ $part->stock }} unidades</p>
                    </div>
                </div>

                <form action="{{ route('parts.restock.store', $part) }}" method="POST">
                    @csrf
                    <div class="grid gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Cantidad Recibida</label>
                            <input type="number" name="quantity" min="1" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Referencia / Factura (Opcional)</label>
                            <input type="text" name="reference" placeholder="Ej: Factura #4502 o Proveedor Aviaparts" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-green-600 text-white font-bold py-3 px-4 rounded-md hover:bg-green-700 transition">
                                Confirmar Entrada
                            </button>
                            <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 px-4 rounded-md text-center hover:bg-gray-200 transition">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>