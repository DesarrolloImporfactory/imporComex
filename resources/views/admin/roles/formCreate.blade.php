<div>
    <div class="modal fade " id="crearRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header card-primary">
                        <h3 class="card-title">Registrar Rol</h3>
                    </div>
                    {!! Form::open(['route' => 'admin.roles.store']) !!}
                    <div class="card-body">
                        @include('admin.roles.partials.form')
                        
                    </div>
                    <div class="card-footer">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        {{-- {!! Form::close() !!} --}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>