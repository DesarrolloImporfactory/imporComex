<div class="col-md-4">
    <div class="form-group">
        <label for="">Terminos de negociación</label>
        <x-adminlte-select2 name="termino" id="termino" enable-old-support>
            <option value="">Selecciona una opción....</option>
            @foreach ($puertosChina as $item)
                @if ($item->id == 1 || $item->id == 4)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @else
                    <option value="{{ $item->id }}" disabled>{{ $item->name }} - proximamente</option>
                @endif
            @endforeach
        </x-adminlte-select2>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">Puerto de origen</label>
        <x-adminlte-select2 name="puerto" id="puerto" disabled enable-old-support>
            
        </x-adminlte-select2>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#termino').change(function(e) {
            e.preventDefault();
            let data = $(this).val();
            $.ajax({
                type: "GET",
                url: "../admin/individual/" + data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        // $("#formCreate").validate({
                        //     rules: {
                        //         puerto: {
                        //             required: true,
                        //         },
                        //     },
                        //     messages: {
                        //         nombre: "El campo es obligatorio.",
                        //     }
                        // });
                        $('#puerto').empty();
                        $('#puerto').removeAttr('disabled');
                        response.puertos.forEach(puerto => {
                            $('#puerto').append(`
                           <option value="${puerto.id}">${puerto.name}</option>
                           `);
                        });
                    } else {
                        $('#puerto').empty();
                        $('#puerto').attr('disabled', 'disabled');
                        console.log('no existe datos');
                    }
                }
            });
        });
    });
</script>
