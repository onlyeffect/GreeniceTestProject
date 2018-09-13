@extends('layouts.app')

@section('content')
<a href="/" class="btn btn-lg btn-warning">Go Back</a>
<div id="app">
    <google-map-update-component :place="{{$place}}" :place-address="{{json_encode($place->address)}}" />
</div>
@endsection