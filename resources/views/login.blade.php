@extends('layouts.app')

@section('content')
    @unless( session('username') )
        <h1>Login</h1>

        <div class="login_buttons">

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

        </div>
    @endunless
@endsection
