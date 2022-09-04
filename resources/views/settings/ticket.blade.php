@extends('settings.layout')

@section('settings_content')
    <h2 class="mb-4 h5">{{__('Ticketsystem')}}</h2>



    <form method="post" action="{{route('settings.ticket.update')}}">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-lg-6">
                <x-input.checkbox label="{{(__('Enable ticket system'))}}"
                                  name="ticket_enabled"
                                  tooltip="{{(__('Enable / Disable the Ticket system'))}}"
                                  value="{{$settings->enabled}}"/>


                <x-input.text label="{{__('New Ticket WebhookURL')}}"
                              name="ticket_webhook_new"
                              value="{{$settings->webhooknew}}"
                              tooltip="{{__('Enter the URL to your Discord Webhook for NEW tickets')}}"/>

                <x-input.text label="{{__('Closing Ticket WebhookURL')}}"
                              name="ticket_webhook_closed"
                              value="{{$settings->webhookclosed}}"
                              tooltip="{{__('Enter the URL to your Discord Webhook for CLOSED tickets')}}"/>

                <x-input.text label="{{__('Reply Ticket WebhookURL')}}"
                              name="ticket_webhook_reply"
                              value="{{$settings->webhookreply}}"
                              tooltip="{{__('Enter the URL to your Discord Webhook for replies to tickets')}}"/>

                    <div class="form-group d-flex justify-content-end mt-3">
                        <button name="submit" type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>


            </div>
        </div>
    </form>
@endsection
