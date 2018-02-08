<div class="team-page-menu-section sidebar-menu-section">
  <div class="team-menu-label menu-label">
    {{ $team->name }}
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#team-page-menu" aria-expanded="false">
      <span class="caret"></span>
    </button>
  </div>

  <div id="team-page-menu" class="collapse navbar-collapse sidebar-menu">
    <ul class="nav">
      <li class="@if ($active_page=='team_discussion') active @endif"><a href="{{ route('team.discussion', ['slug'=>$team->slug]) }}">Discussion</a></li>
      <li><a href="/">Members</a></li>
      <li><a href="/">Team Settings</a></li>
    </ul>
  </div>
</div>
