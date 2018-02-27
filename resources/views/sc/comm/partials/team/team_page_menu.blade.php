<div class="team-page-menu-section sidebar-menu-section">
  <div class="team-menu-label menu-label">
    {{ $team->name }}
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#team-page-menu" aria-expanded="false">
      <span class="caret"></span>
    </button>
  </div>

  <div id="team-page-menu" class="collapse navbar-collapse sidebar-menu">
    <ul class="nav">
      <li class="@if ($active_page=='team_discussion') active @endif">
        <a href="{{ route('team.discussion', ['slug'=>$team->slug]) }}">Discussion</a>
      </li>
      <li class="@if ($active_page=='team_leagues') active @endif">
        <a href="{{ route('team.leagues', ['slug'=>$team->slug]) }}">Leagues</a>
      </li>
      <li class="@if ($active_page=='team_members') active @endif">
        <a href="{{ route('team.members', ['slug'=>$team->slug]) }}">Members</a>
      </li>
      @if ($currentUser && SCTeamLib::isTeamManager($currentUser->id, $team))
        <li class="@if ($active_page=='team_settings') active @endif">
          <a href="#">Team Settings</a>
        </li>
      @endif
    </ul>
  </div>
</div>
