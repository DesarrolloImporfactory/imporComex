<select class="form-control select2 " style="width: 100%;" name="modalidad" >
    {{$slot}}
</select>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap"
        });
    });
</script>
