<nav class="navigation">
    <a class="menuitem {{ (request()->is('matches')) ? 'active' : '' }}" title="Matches" href="/matches"><x-icon-double_heart/></a>
    <a class="menuitem {{ (request()->is('suggest')) ? 'active' : '' }}" title="WatchMatch" href="/suggest"><x-icon-logo_symbol/></a>
    <a class="menuitem {{ (request()->is('watched')) ? 'active' : '' }}" title="Watched" href="/watched"><x-icon-check/></a>
</nav>
