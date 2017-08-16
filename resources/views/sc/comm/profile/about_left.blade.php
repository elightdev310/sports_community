<ul class="about-left-tab nav flex-column">
  <li class="nav-item @if ($about_tab=='contact') active @endif">
    <a class="nav-link " href="{{ route('profile.about.contact', ['user'=>$user->id]) }}">Contact Info</a>
  </li>
  <li class="nav-item @if ($about_tab=='basic') active @endif">
    <a class="nav-link" href="{{ route('profile.about.basic', ['user'=>$user->id]) }}">Basic Info</a>
  </li>
  <li class="nav-item @if ($about_tab=='education') active @endif">
    <a class="nav-link" href="{{ route('profile.about.education', ['user'=>$user->id]) }}">Education</a>
  </li>
</ul>
