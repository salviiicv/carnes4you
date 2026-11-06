<div class="flex h-full bg-gray-100 font-sans text-gray-800">
    <div class="w-2/3 p-4 flex flex-col">
        <h2 class="text-2xl font-bold mb-4">Productos</h2>

        <div class="grid grid-cols-3 gap-4 overflow-y-auto">
            @foreach($products as $product)
                <button wire:click="addToCard{{ $product->id }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:bg-blue-50 text-left transition-colors">
                    <span class="block font-bold text-lg">{{ $product->name }}</span>
                    <span class="block text-gray-500 mt-1">{{ number_format($product->price, 2) }} €</span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="w-1/3 bg-white border-l border-gray-200 shadow-xl flex flex-col">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-700">Ticket actual</h2>
        </div>

        <div class="flex-1 p-4 overflow-y-auto bg-white">
            <div class="flex justify-between items-center mb-3 pb-3 border-b border-dashed border-gray-200">
                <div class="flex flex-col">
                    <span class="text-lg font-semibold text-gray-800">Entrecot de ternera</span>
                    <span class="text-sm text-gray-500">Fileteado</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center bg-gray100 rounded-lg">
                        <button class="px-3 py-1 text-gray-600 hover:bg-gray-200 rounded-l-lg font-bold">-</button>
                        <span class="px-3 font-semibold">1</span>
                        <button class="px-3 py-1 text-gray-600 hover:bg-gray-200 rounded-r-lg font-bold">+</button>
                    </div>
                    <span class="font-bold text-gray-800 w-16 text-right">12.50 €</span>
                    <button class="text-red-500 hover:text-red-700 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-500 font-medium">Subtotal</span>
                <span class="text-gray-700 font-medium">12.50 €</span>
            </div>
            <div class="flex justify-between items-center font-bold text-3xl mb-6 text-gray-800">
                <span>Total</span>
                <span>12.50 €</span>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button class="w-full bg-red-100 text-red-700 font-bold text-lg py-4 rounded-lg shadow-sm hover:bg-red-200 transition-colors border border-red-200">
                    Cancelar
                </button>
                <button class="w-full bg-green-600 text-white font-bold text-lg py-4 rounded-lg shadow-sm hover:bg-green-700 transition-colors">
                    Cobrar
                </button>
            </div>
        </div>
    </div>
</div>