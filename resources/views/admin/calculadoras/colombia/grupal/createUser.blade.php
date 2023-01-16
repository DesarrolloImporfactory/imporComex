<x-adminlte-modal id="modalCustom" title="Registro rapido de cliente" size="" theme="dark" icon="fa-solid fa-user-plus" v-centered
    static-backdrop scrollable>
    <div>
        <form action="{{ route('create.user.fast') }}" id="id_form">
            @csrf
            <input type="hidden" name="paises" id="" value="{{ $paises->id }}">
            <input type="hidden" name="modalidad" id="" value="3">
            <div class="form-group">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" class="form-control" value="{{old('nombre')}}">
                @error('nombre')
                <span style="color: red">{{$message}}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="nombre">Telefono: </label>
                <input type="text" name="telefono" class="form-control" value="{{old('telefono')}}">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" class="form-control" name="email" placeholder="usuario@gmail.com">
                @error('email')
                    <span style="color: red">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nombre">Crear password temporal: </label>
                <input type="text" name="password" class="form-control">
            </div>
            <button class="btn btn-dark" type="submit" >Crear</button>
            <x-adminlte-button class="btn btn-secondary" data-dismiss="modal" label="Close" />
        </form>

    </div>

</x-adminlte-modal>
