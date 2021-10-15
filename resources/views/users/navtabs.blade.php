<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('users.show', $user) }}"
            class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
            TimeLine
            <span class="badge badge-secondary">{{ $user->microposts_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.followings', $user) }}"
            class="nav-link {{ Request::routeIs('users.followings') ? 'active' : '' }}">
            Followings
            <span class="badge badge-secondary">{{ $user->followings_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.followers', $user) }}"
            class="nav-link {{ Request::routeIs('users.followers') ? 'active' : '' }}">
            Followers
            <span class="badge badge-secondary">{{ $user->followers_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.favorites', $user) }}"
            class="nav-link {{ Request::routeIs('users.favorites') ? 'active' : '' }}">
            Favorites
            <span class="badge badge-secondary">{{ $user->favorites_count }}</span>
        </a>
    </li>
</ul>
