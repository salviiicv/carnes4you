<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel TPV - Carnes4You</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100 h-screen flex flex-col overflow-hidden font-sans text-gray-800">

        <header class="bg-white shadow-sm border-b px-6 py-3 flex justify-between items-center z-10 shrink-0">
            <div class="font-bold text-lg text-gray-700">
                Carnes4You - Cajero: <span class="text-blue-600">{{ auth()->user()->name }}</span>
            </div>

            <div class="flex items-center gap-6">
                @if($activeSession)
                    <div class="flex items-center gap-4">
                        <span class="text-green-600 font-semibold flex items-center gap-1 text-sm">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Caja Abierta
                        </span>

                        <form action="{{ route('tpv.close', $activeSession->id) }}" method="POST" class="m-0 flex items-center gap-2">
                            @csrf
                            <input type="text" name="notes" placeholder="Notas (opcional)" class="border border-gray-300 rounded px-2 py-1 text-sm w-32 focus:outline-none focus:border-blue-400">
                            <input type="number" name="closing_cash" step="0.01" placeholder="Fondo final (€)" required class="border border-gray-300 rounded px-2 py-1 text-sm w-32 focus:outline-none focus:border-blue-400">
                            <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded text-sm font-bold hover:bg-red-700 transition-colors">
                                Cerrar caja
                            </button>
                        </form>
                    </div>
                @endif
                <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-gray-800 text-sm underline">Mi perfil</a>
            </div>
        </header>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4 rounded shadow-sm">
                <strong>Error:</strong> {{ $errors->first() }}
            </div>
        @endif

        <main class="flex-1 flex overflow-hidden relative">
            @if($activeSession)
                <div class="w-full h-full">
                    <livewire:tpv.terminal />
                </div>
            @else
                <div class="m-auto bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-200">
                    <div class="flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-full mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Caja Cerrada</h2>
                    <p class="text-gray-500 text-center mb-6 text-sm">Debes abrir tu turno introduciendo el fondo inicial de la caja registradora.</p>

                    <form action="{{ route('tpv.open') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <div>
                            <label for="starting_cash" class="block text-gray-700 font-bold mb-1">Fondo inicial (€):</label>
                            <input type="number" name="starting_cash" step="0.01" required placeholder="Ej: 150.00" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-lg">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition-colors mt-2 text-lg shadow-md">
                            Abrir caja
                        </button>
                    </form>
                </div>
            @endif
        </main>

    </body>
</html>