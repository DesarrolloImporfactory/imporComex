@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Imporcomex')
<img src="{{ base_path('public/imagenes/icono.png') }}" class="" alt="Laravel Logo">
{{-- <p>{{ base_path('public/imagenes/icono.png') }}</p>
<p>si</p> --}}
@else

@endif
</a>
</td>
</tr>
