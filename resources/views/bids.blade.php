@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <h5>My Bids</h5>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-4">
      @include('partials.alert')

      @if (count($bids) > 0)
      <div class="bids clearfix">
        @foreach ($bids as $bid)
          <div class="my-3">
            @include('partials.cards.order', ['order' => $bid->order, 'order_user' => $bid->order->user])
            
            @include('partials.cards.bid', ['bid_user' => Auth::user()])
          </div>
        @endforeach
      </div>
      @else
      <div class="alert alert-info">
        You haven't submitted any bids yet.
      </div>
      @endif
    </div>
  </div>
</div>

<div class="modal fade" id="bid-cancel-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cancel Bid</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <form action="#" method="POST" id="bid-cancel-form">
                @method('PATCH')
                @csrf
                @honeypot
                <div class="container">
                  <div class="alert alert-info">
                  Whether your reason is valid or not, note that this will be reflected in your <a href="/user/{{ Auth::id() }}/reputation">user profile</a>. This is to ensure a safe and trusthworthy environment for all.
                  </div>
                    <div class="form-group row">
                      <label for="cancel_reason" class="col-sm-5 col-form-label">Cancellation Reason</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control @error('cancel_reason') is-invalid @enderror" name="cancel_reason" id="cancel_reason" placeholder="eg. I have an emergency" value="{{ old('cancel_reason') }}">

                        @error('cancel_reason')
                          <span class="invalid-feedback bid-modal-error" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <button class="btn btn-danger float-right">Cancel Bid</button>
                </div>
            </form>
        </div>
      </div>

  </div>
</div>

@include('partials.contact-modal')

@endsection

@section('foot_scripts')
<script src="{{ mix('js/bids.js') }}"></script>
<script src="{{ mix('js/view-contact.js') }}" defer></script>
@endsection
