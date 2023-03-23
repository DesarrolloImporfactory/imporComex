<table class="table table-bordered table-striped text-center" id="table2">
    {{$slot}}
</table>
@section('js')
    <script>
        $(document).ready(function() {
            $('#table2').DataTable();
        });
    </script>
@stop