@can('1day2die.admin.ticket.settings')
<li class="list-inline-item px-0 {{ request()->routeIs('settings.ticket.index') ? 'text-info' : '' }} px-sm-2">
    <a href="{{route('settings.ticket.index')}}">{{__('Support Tickets')}}</a>
</li>
@endcan
