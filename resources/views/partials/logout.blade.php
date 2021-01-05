@if( session('username') )

    <div class="logout_wrapper">
        <span class="greeting">Hi, {{ session('username') }}!</span>
        <a class="logout" title="Abmelden" href="/logout">Abmelden</a>
    </div>
@endif