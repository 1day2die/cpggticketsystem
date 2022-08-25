@can('1day2die.admin.ticket.read')
<li class="nav-item ms-2 {{ request()->routeIs('admin.ticket.index') ? 'active' : '' }}" data-bs-toggle="collapse"
    href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-newspaper fa-fw"></i>
                </span>
    <span class="sidebar-text">{{ __('Ticketsystem') }}</span>
</li>

<div class="collapse" id="collapseExample">
    <a href="{{ route('admin.ticket.index') }}" class="ms-4 nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-envelope fa-fw"></i>
                </span>
        <span class="sidebar-text">{{ __('Show Tickets') }}</span>
    </a>
    <a href="{{ route('admin.ticket.blacklist') }}" class="ms-4 nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-user-edit fa-fw"></i>
                </span>
        <span class="sidebar-text">{{ __('Blacklist') }}</span>
    </a>
</div>
@endcan
