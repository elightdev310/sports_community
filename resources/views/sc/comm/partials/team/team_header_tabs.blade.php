<ul class="team-header-tabs page-header-tabs nav nav-pills">
  <li class="@if ($tab=='my_teams') active @endif">
    <a href="{{ route('team.my_teams') }}">Teams</a>
  </li>
  <li class="@if ($tab=='search') active @endif">
    <a href="{{ route('team.search') }}">Search</a>
  </li>
</ul>
