@extends('layouts.dashboard')

@section('content')

    <!-- CONTENT HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Ticket')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a class="text-muted"
                                                       href="{{route('admin.ticket.index')}}">{{__('Ticket List')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- END CONTENT HEADER -->

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">

                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title"><i class="fas fa-ticket-alt mr-2"></i>{{__('Ticket List')}}</h5>
                    </div>
                </div>

                <div class="card-body table-responsive">

                    {!! $html->table() !!}

                </div>
            </div>


        </div>
        <!-- END CUSTOM CONTENT -->

    </section>
    <!-- END CONTENT -->

@endsection

@section('scripts')
    {!! $html->scripts() !!}
@endsection
