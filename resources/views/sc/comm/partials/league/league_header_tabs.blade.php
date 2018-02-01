<ul class="league-header-tabs page-header-tabs nav nav-pills">
  <li class="@if ($tab=='my_leagues') active @endif">
    <a href="{{ route('league.my_leagues') }}">leagues</a>
  </li>
  <li class="@if ($tab=='search') active @endif">
    <a href="{{ route('league.search') }}">Search</a>
  </li>
</ul>
