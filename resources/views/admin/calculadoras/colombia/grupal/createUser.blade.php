<x-adminlte-modal id="modalCustom" title="Registro rapido de cliente" size="" theme="dark" icon="fa-solid fa-user-plus"
    v-centered static-backdrop scrollable>
    <div>
        <form action="{{ route('create.user.fast') }}" id="id_form">
            @csrf
            <input type="hidden" name="paises" id="" value="{{ $paises->id }}">
            <input type="hidden" name="modalidad" id="" value="3">
            <div class="form-group">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
                @error('nombre')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nombre">Telefono: </label>
                <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}"
                    placeholder="opcional">
            </div>
            <div class="form-group">
                <label for="nombre">Ruc: </label>
                <input type="text" name="ruc" id="ruc" class="form-control" value="{{ old('ruc') }}">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="usuario@gmail.com">
                @error('email')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nombre">Crear password temporal: </label>
                <input type="text" name="password" id="password" class="form-control">
            </div>
            <button class="btn btn-dark" type="submit">Crear</button>
            <x-adminlte-button class="btn btn-secondary" data-dismiss="modal" label="Close" />
        </form>

    </div>

</x-adminlte-modal>
<style>
    .error {
        color: red;
    }
</style>
<script>
    $(document).ready(function() {
        $('#id_form').validate({
            rules: {
                nombre: "required",
                telefono: "required",
                ruc: "required",
                email: {
                    required: true,
                    email: true
                },
                password: "required",
            },
            messages: {
                nombre: "El campo nombre es requerido",
                telefono: " El campo telefono es requerido",
                ruc: " El campo ruc es requerido ",
                email: "Por favor ingresa un correo válido",
                password: "El campo password es requerido",
            },

        });
    });
</script>
