<div>
    <x-adminlte-select2 name="cliente" id="cliente">
        <option value="">Selecciona una opción....</option>
        @foreach ($clientes as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </x-adminlte-select2>
</div>
