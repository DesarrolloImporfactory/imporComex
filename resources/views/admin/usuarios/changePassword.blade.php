<div class="card card-dark">
    <div class="card-header">
        ACTUALIZAR CONTRASEÑA
    </div>
    <div class="card-body">
        <form action="{{ route('admin.password', $usuario->id) }}" method="POST" id="changePassword">
            {{ method_field('PATCH') }}
            @csrf
            <div class="form-group">
                <p>Contraseña actual</p>
                <input type="password" class="form-control @error('contraseña_actual') is-invalid @enderror"
                    name="contraseña_actual">
                @error('contraseña_actual')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <p>Nueva contraseña</p>
                <input type="password" class="form-control @error('nueva_contraseña') is-invalid @enderror"
                    name="nueva_contraseña">
                @error('nueva_contraseña')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <p>Confirmar contrseña</p>
                <input type="password" class="form-control @error('confirmar_contraseña') is-invalid @enderror"
                    name="confirmar_contraseña">
                @error('confirmar_contraseña')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-dark float-right" form="changePassword"><i
                class="fa-solid fa-rotate"></i> Actualizar</button>
    </div>
</div>