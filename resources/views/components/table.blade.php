<table class="table table-striped" id="table2">
    {{$slot}}
</table>
@section('js')
    <script>
        $(document).ready(function() {
            $('#table2').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop