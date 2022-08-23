@can('admin.ticket.read')
    <li class="nav-item {{ request()->routeIs('admin.ticket.index') ? 'active' : '' }}">
        <a href="{{ route('admin.ticket.index') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-users fa-fw"></i>
                </span>
            <span class="sidebar-text">{{ __('Tickets') }}</span>
        </a>
    </li>
@endcan
