@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
    @php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->email }}
    </a>

    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="#">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            @if($profile_url)
                <a href="{{ $profile_url }}" class="dropdown-item">
                    <i class="fa fa-fw fa-user text-primary"></i>
                    <span class="align-middle">My Profile</span>
                </a>
            @endif
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-door-open text-danger"></i>
                <span class="align-middle"> Log Out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</li>