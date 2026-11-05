<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Panel TPV</title>
    </head>
    <body>
        <h1>Bienvenido al TPV, {{ auth()->user()->name }}</h1>

        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <strong>Error:</strong> {{ $errors->first() }}
            </div>
        @endif

        @if($activeSession)
            <p>Estado de la caja: <strong>ABIERTA</strong></p>
            <p>Abierta por: {{ $activeSession->user_id }}</p>
            <p>Fondo inicial: {{ $activeSession->starting_cash }} €</p>

            <form action="{{ route('tpv.close', $activeSession->id) }}" method="POST">
                @csrf
                <label for="closing_cash">Fondo final en caja (€):</label>
                <input type="number" name="closing_cash" step="0.01" required>

                <label for="notes">Notas (opcional):</label>
                <input type="text" name="notes">
                <button type="submit">Cerrar caja</button>
            </form>
        @else
            <p>Estado de la caja: <strong>CERRADA</strong></p>
            <form action="{{ route('tpv.open') }}" method="POST">
                @csrf
                <label for="starting_cash">Fondo inicial (€):</label>
                <input type="number" name="starting_cash" step="0.01" required>
                <button type="submit">Abrir caja</button>
            </form>
        @endif

        <hr>
        <a href="{{ route('profile.edit') }}">Ir a mi perfil</a>
    </body>
</html>