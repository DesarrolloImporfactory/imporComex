@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@if ($layoutHelper->isLayoutTopnavEnabled())
    @php($def_container_class = 'container')
@else
    @php($def_container_class = 'container-fluid')
@endif

{{-- Default Content Wrapper --}}
<div class="content-wrapper {{ config('adminlte.classes_content_wrapper', '') }}">
    <div class="aler alert-danger" id="alerta">
                    
    </div>
    {{-- Content Header --}}
    @hasSection('content_header')
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="content">
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            @yield('content')
        </div>
    </div>

</div>
<script>
    window.addEventListener('load', function() {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.roles.create') }}",
            dataType: "json",
            success: function(response) {
                if (response.status == 200) {
                    $("#alerta").text('Suscripción demo, fecha de finalización es: ' + response
                        .fecha_fin + ', le quedan ' + response.dias +
                        ' dias para usar el sistema.');
                    setInterval(() => {
                        Swal.fire({
                            allowOutsideClick: false,
                            position: 'center',
                            icon: 'warning',
                            title: 'Tipo de suscripción demo.',
                            showConfirmButton: false,
                            timer: 15000
                        })
                    }, 240000);
                } else {
                    $('#alerta').empty();
                }
            }
        });

    });
</script>
