@extends('solicitud::layouts.masterusers')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('solicitud.name') !!}
    </p>
@endsection
