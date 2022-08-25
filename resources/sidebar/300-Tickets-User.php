@can('1day2die.ticket.read')
    <li class="nav-item {{ request()->routeIs('ticket.index') ? 'active' : '' }}">
        <a href="{{ route('ticket.index') }}" class="nav-link">
                    <span class="sidebar-icon me-3">
                        <i class="fas fa-money-bill fa-fw"></i>
                    </span>
            <span class="sidebar-text">{{ __('Support Tickets') }}</span>
        </a>
    </li>
@endcan
