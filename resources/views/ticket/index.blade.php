@extends('layouts.dashboard')

@section('content')


    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title"><i class="fas fa-ticket-alt mr-2"></i>{{__('My Ticket')}}</h5>
                                <a href="{{route('ticket.new')}}" class="btn btn-sm btn-primary"><i
                                        class="fas fa-plus mr-1"></i>{{__('New Ticket')}}</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">

                            {!! $html->table() !!}



                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{__('Ticket Information')}}
                                <i data-toggle="popover"
                                data-trigger="hover"
                                data-content="{{__('please make the best of it')}}"
                                class="fas fa-info-circle"></i></h5>
                        </div>
                        <div class="card-body">
                            <p>Can't start your server? Need an additional port? Do you have any other questions? Let us know by
                                opening a ticket.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



@section('scripts')
    {!! $html->scripts() !!}
@endsection


