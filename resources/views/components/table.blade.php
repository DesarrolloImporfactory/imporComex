<table class="table table-striped" id="table">
    {{$slot}}
</table>
@section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop