@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <h5>Requests Feed @if (Auth::user()->barangay) (Brgy. {{ Auth::user()->barangay->name }}) @endif</h5>
    </div>
  </div>

  <input type="hidden" id="setup_step" value="{{ Auth::user()->setup_step }}">

  @if (Auth::user()->setup_step == 5)
  <div class="row justify-content-center">
  <div class="col-md-4 mt-3">
    @include('partials.alert')


    <form method="POST" action="/order/create">
      @csrf
      @honeypot
      
      @include('partials.order-form', ['description_placeholder' => 'Buy 12 eggs, 1 loaf bread, and 1 fresh milk'])
    </form>
  </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-4 mt-5">
      @if (count($orders) > 0)
        @foreach ($orders as $order)
          <div class="my-3">
            @include('partials.cards.order', ['orders_feed' => true, 'order_user' => $order->user])
          </div>
        @endforeach

        <div>
        {{ $orders->links() }}
        </div>
      @endif

      @if (count($orders) == 0)
      <div class="alert alert-info">
        No requests in your neighborhood yet.
      </div>
      @endif
    </div>
  </div>
  @else
  <div class="row justify-content-center">
    <div class="col-md-4 mt-3">
      <div class="alert alert-warning">
      You need to setup your account first before you can start posting or bidding.
      </div>
    </div>
  </div>
  @endif

</div>

@include('partials.modals.setup.step-one')

@include('partials.modals.setup.step-two')

@include('partials.modals.setup.step-three')

@include('partials.modals.setup.step-four')

@include('partials.modals.setup.step-five')


@if (Auth::user()->setup_step == 5)
<div class="modal fade" id="bid-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Request Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <form action="/bid/create" method="POST">
                @csrf
                @honeypot
                <input type="hidden" name="order_id" id="order_id" value="{{ old('order_id') }}">
                <input type="hidden" name="order_recipient" id="order_recipient" value="{{ old('order_recipient') }}">
                <input type="hidden" name="order_service_type" id="order_service_type" value="{{ old('order_service_type') }}">
                <input type="hidden" name="order_description" id="order_description" value="{{ old('order_description') }}">
                <input type="hidden" name="order_created_at" id="order_created_at" value="{{ old('order_created_at') }}">

                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Recipient</strong>
                        </div>
                        <div class="col-md-8 mt-1" id="order-recipient">
                        {{ old('order_recipient') }}
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <strong>Service type</strong>
                        </div>
                        <div class="col-md-8 mt-3 mb-3" id="order-service-type">
                        {{ old('order_service_type') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <strong>Description</strong>
                        </div>
                        <div class="col-md-8 mt-3 mb-3" id="order-description">
                        {{ old('order_description') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <strong>Posted at</strong>
                        </div>
                        <div class="col-md-8 mt-2 mb-3" id="order-datetime">
                        {{ friendlyDatetime(old('order_created_at')) }}
                        </div>
                    </div>

                    <div class="form-group row">
                      <label for="service_fee" class="col-sm-4 col-form-label">How much will you charge?</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control @error('service_fee') is-invalid @enderror" name="service_fee" id="service_fee" placeholder="eg. 200" value="{{ old('service_fee') }}">

                        @error('service_fee')
                          <span class="invalid-feedback bid-modal-error" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                      <div class="col-sm-8">
                        <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" rows="3" placeholder="eg. I can do this in 1 hour. I'm wearing blue shirt.">{{ old('notes') }}</textarea>

                        @error('notes')
                          <span class="invalid-feedback bid-modal-error" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <button class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
      </div>

  </div>
</div>
@endif
@endsection

@section('foot_scripts')
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-messaging.js"></script>
<script src="{{ mix('js/facebook-login.js') }}" defer></script>
<script src="{{ mix('js/user-setup.js') }}" defer></script>
<script src="{{ mix('js/orders-feed.js') }}" defer></script>
@endsection
