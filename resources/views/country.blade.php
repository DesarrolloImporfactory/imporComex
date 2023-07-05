@extends('adminlte::page')
@section('title', 'Countrys')

@section('content_header')

    {{-- <select name="country" class="form-select">
        @foreach ($countries as $country)
            <option value="{{ $country['name']['common'] }}">
                <img src="{{ $country['flags']['png'] }}" alt="{{ $country['name']['common'] }}" width="16" height="16">
                {{ $country['name']['common'] }}
            </option>
        @endforeach
    </select> --}}
    <div class="row">
        @foreach ($countries as $country)
            <div class="alert alert-success">
                <p>id: {{ $country['name']['common'] }}</p>
                <img src="{{ $country['flags']['png'] }}" alt="{{ $country['name']['common'] }}" width="16" height="16">
                {{ $country['name']['common'] }}
            </div>
        @endforeach
    </div>

@stop
