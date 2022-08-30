@extends('layouts.dashboard')


@section('content')

    <!-- END CONTENT HEADER -->

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title"><i class="fas fas fa-users mr-2"></i>{{__('Blacklist List')}}</h5>
                            </div>
                        </div>
                        <div class="card-body table-responsive">

                            <div class="card-body table-responsive">

                                {!! $html->table() !!}



                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{__('Add To Blacklist')}}
                                <i data-toggle="popover"
                                data-trigger="hover"
                                data-content="{{__('please make the best of it')}}"
                                class="fas fa-info-circle"></i></h5>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.ticket.blacklist.add')}}" method="POST" class="ticket-form">
                            @csrf
                                <div class="custom-control mb-3 p-0">
                                    <label for="user_id">{{ __('User') }}:
                                        <i data-toggle="popover" data-trigger="hover"
                                        data-content="{{ __('Please note, the blacklist will make the user unable to make a ticket/reply again') }}" class="fas fa-info-circle"></i>
                                    </label>
                                    <select id="user_id" style="width:100%" class="custom-select" name="user_id" required
                                            autocomplete="off" @error('user_id') is-invalid @enderror>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="reason" class="control-label">{{__("Reason")}}</label>
                                    <input id="reason" type="text" class="form-control" name="reason" placeholder="Input Some Reason" required>
                                </div>
                                <button type="submit" class="btn btn-primary ticket-once">
                                    {{__('Submit')}}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END CONTENT -->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            $('#user_id').select2();
        })
    </script>
@endsection


@section('scripts')
    {!! $html->scripts() !!}
@endsection

