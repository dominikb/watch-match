@extends('layouts.app')

@section('content')
@if( session('username') )
<h1>Hello, {{ session('username') }}</h1>

@include('partials/menu')
@else
<h1>Login</h1>

<form action="/login" method="post">
    @csrf
    <input hidden id="username" name="username" type="text" value="Dominik">
    <button type="submit">Dominik</button>
</form>

<form action="/login" method="post">
    @csrf
    <input hidden id="username" name="username" type="text" value="Kathi">
    <button type="submit">Kathi</button>
</form>
@endif
@endsection
