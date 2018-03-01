<div class="league-page-menu-section sidebar-menu-section">
  <div class="league-menu-label menu-label">
    {{ $league->name }}
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#league-page-menu" aria-expanded="false">
      <span class="caret"></span>
    </button>
  </div>

  <div id="league-page-menu" class="collapse navbar-collapse sidebar-menu">
    <ul class="nav">
      <li class="@if ($active_page=='league_discussion') active @endif">
        <a href="{{ route('league.discussion', ['slug'=>$league->slug]) }}">Discussion</a>
      </li>
      <li class="@if ($active_page=='league_seasons') active @endif">
        <a href="{{ route('league.seasons', ['slug'=>$league->slug]) }}">Seasons</a>
      </li>
      <li class="@if ($active_page=='league_members') active @endif">
        <a href="{{ route('league.members', ['slug'=>$league->slug]) }}">Members</a>
      </li>
      <li class="@if ($active_page=='league_teams') active @endif">
        <a href="{{ route('league.teams', ['slug'=>$league->slug]) }}">Teams</a>
      </li>
      @if ($currentUser && SCLeagueLib::isLeagueManager($currentUser->id, $league))
        <li class="@if ($active_page=='league_settings') active @endif">
          <a href="#">League Settings</a>
        </li>
      @endif
    </ul>
  </div>
</div>
