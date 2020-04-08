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

@if (Auth::user()->setup_step == 0)
<div class="modal" id="user-setup-modal-0" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 1: Connect Facebook Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        @include('partials.alert')

        @if (!session('alert'))
        <div class="alert alert-info">
        Your Facebook account will be used to validate your identity. Your profile picture will be displayed for your posts and bids.
        </div>
        @endif

        <div class="row justify-content-center">
          @include('partials.facebook-login-button')
        </div>

      </div>
      <div class="modal-footer">
        @include('partials.facebook-login-form', ['facebook_login_form_action' => "/setup/step-one"])
      </div>
    </div>
  </div>
</div>
@endif

@if (Auth::user()->setup_step == 1)
<div class="modal" id="user-setup-modal-1" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 2: Where do you live?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="/setup/step-two" method="POST">
        @method('PATCH')
        @csrf
        @honeypot
        <div class="modal-body">

          <div class="form-group row">
              <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('Province') }}</label>

              <div class="col-md-6">
                  <select name="province" id="province" class="form-control @error('province') is-invalid @enderror">
                      <option value="">Select province</option>
                      @foreach($provinces as $province)
                      <option value="{{ $province->id }}">{{ $province->name }}</option>
                      @endforeach
                  </select>

                  @error('province')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

              <div class="col-md-6">
                  <div class="text-center loader">
                    <div class="spinner-border">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <div>
                    <select name="city" id="city" class="form-control @error('city') is-invalid @enderror">

                    </select>

                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
              </div>
          </div>

          <div class="form-group row">
              <label for="barangay" class="col-md-4 col-form-label text-md-right">{{ __('Barangay') }}</label>

              <div class="col-md-6">
                  <div class="text-center loader">
                    <div class="spinner-border">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <div>
                    <select name="barangay" id="barangay" class="form-control @error('barangay') is-invalid @enderror">

                    </select>

                    @error('barangay')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
              </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Next</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endif

@if (Auth::user()->setup_step == 2)
<div class="modal" id="user-setup-modal-2" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 3: How can you be contacted?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          Your phone number or your Facebook Messenger ID will be used for communication between the person who made the order and the person who submitted the bid. This information will only be available to both parties once a request has been accepted.
        </div>

        <form action="/setup/step-three" method="POST" id="user-contact-form">
          @method('PATCH')
          @csrf
          @honeypot

          <div class="form-group row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

              <div class="col-md-6">
                  <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', Auth::user()->detail->phone_number) }}" placeholder="eg. 09176543210" autocomplete="off">

                  @error('phone_number')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="messenger_id" class="col-md-4 col-form-label text-md-right">{{ __('Messenger ID') }}</label>

              <div class="col-md-6">
                  <input id="messenger_id" type="text" class="form-control @error('messenger_id') is-invalid @enderror" name="messenger_id" value="{{ old('messenger_id', Auth::user()->detail->messenger_id) }}" placeholder="eg. laong.laan25" autocomplete="off">

                  <small class="text-secondary">You can find this on your Messenger app by clicking on your profile picture on the upper left. Then under profile, you can see the username. Simply omit the m.me/ part.</small>

                  @error('messenger_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">

        <form action="/setup/back" method="POST">
          @method('PATCH')
          @csrf
          @honeypot
          <button class="btn btn-secondary">Back</button>
        </form>

        <button class="btn btn-primary" form="user-contact-form">Next</button>
      </div>
    </div>
  </div>
</div>
@endif

@if (Auth::user()->setup_step == 3)
<div class="modal" id="user-setup-modal-3" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 4: Which services will you offer?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="alert alert-info">
          Simply click <strong>Next</strong> if only want to avail services. You can always update your selection later in your account settings page.
        </div>

        <div class="row">
          <div class="col-md-12 text-left">

            <form action="/setup/step-four" method="POST" id="services-form">
              @method('PATCH')
              @csrf
              @honeypot

              <input type="hidden" name="_is_ios" id="_is_ios">

              @include('partials.services')
             
            </form>

          </div>
        </div>
      </div>

      <div class="modal-footer">
        <form action="/setup/back" method="POST">
          @method('PATCH')
          @csrf
          @honeypot
          <button class="btn btn-secondary">Back</button>
        </form>

        <button class="btn btn-primary" form="services-form">Next</button>
      </div>
    </div>
  </div>
</div>
@endif

@if (Auth::user()->setup_step == 4)
<div class="modal" id="user-setup-modal-4" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 5: Notifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="alert alert-info">
          Click the button below so you can receive notifications when someone makes a request in your barangay, someone makes a bid to your request, or when your bid gets accepted. Click <strong>allow</strong> when you get a prompt to enable notifications. If you don't want to receive notifications, simply click on the <strong>Finish Setup</strong> button.
        </div>

        <div class="row justify-content-center">
          <div class="col-md-6 text-center">

            <button type="button" class="btn btn-block btn-success" id="enable-notifications">
              <span class="spinner-border spinner-border-sm button-loader" role="status"></span>
              <span class="button-loader">Please wait...</span>
              <span class="button-text">Enable Notifications</span>
            </button>

            <form action="/setup/step-five" method="POST" id="notifications-form">
              @method('PATCH')
              @csrf
              @honeypot
              <input type="hidden" name="_fcm_token" id="_fcm_token">
            </form>
          </div>
        </div>
      </div>

      <div class="modal-footer">

        <form action="/setup/back" method="POST">
          @method('PATCH')
          @csrf
          @honeypot
          <button class="btn btn-secondary">Back</button>
        </form>

        <button class="btn btn-primary" form="notifications-form">Finish Setup</button>
      </div>
    </div>
  </div>
</div>
@endif


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
