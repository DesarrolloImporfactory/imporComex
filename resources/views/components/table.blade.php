<table class="table table-striped" id="table2">
    {{$slot}}
</table>
@section('js')
    <script>
        $(document).ready(function() {
            $('#table2').DataTable();
        });
    </script>
@stop