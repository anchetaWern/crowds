@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <h5>My Requests</h5>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-4">
      @include('partials.alert')

      @if (count($orders) > 0)
        @foreach ($orders as $order)
          <div class="my-3">
            @include('partials.cards.order', ['order_user' => Auth::user()])
            
            @if (!is_null($order->bidsAcceptedFirst))
            <div class="bids clearfix mb-5">
            @foreach ($order->bidsAcceptedFirst as $bid)
              @include('partials.cards.bid', ['bid_user' => $bid->user])
            @endforeach
            </div>
            @endif

          </div>
        @endforeach

        <div>
        {{ $orders->links() }}
        </div>
      @endif

      @if (count($orders) == 0)
      <div class="alert alert-info">
        You haven't posted any requests yet.
      </div>
      @endif
    </div>
  </div>
</div>

@include('partials.contact-modal')
@endsection

@section('foot_scripts')
<script src="{{ mix('js/orders.js') }}" defer></script>
<script src="{{ mix('js/view-contact.js') }}" defer></script>
@endsection
