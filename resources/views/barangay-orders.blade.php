@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-4">
			<h5>My Barangay Requests (Brgy. {{ Auth::user()->barangay->name }})</h5>
		</div>
	</div>
  
  <div class="row justify-content-center">
    <div class="col-md-4 mt-3">
    @if (Auth::user()->user_type == 'user')
	
  		@include('partials.alert')

  		<form method="POST" action="/barangay-order/create">
  			@csrf
  			@honeypot
  			
        @include('partials.order-form', ['description_placeholder' => 'eg. Relief goods'])
  		</form>
    @else
      @include('partials.alert')
    @endif
    </div>
  </div>
  
  @if (Auth::user()->user_type == 'officer')
  <div class="row justify-content-center">
    <div class="col-md-4">

      <label for="order_status">Request status</label>
      <select class="custom-select" name="order_status" id="order_status">
        @foreach ($order_status as $status)
        <option value="{{ $status }}" {{ isSelected($status, $selectedStatus) }}>{{ $status }}</option>
        @endforeach
      </select>

      <div class="mt-3">
        <a href="?status=posted" class="btn btn-primary float-right" id="filter-order">Filter</a>
      </div>

    </div>
  </div>
  @endif

	<div class="row justify-content-center">
    <div class="col-md-4 mt-2">
      @if (count($orders) > 0)
        @foreach ($orders as $order)
          <div class="my-3">
            @include('partials.cards.order', ['order_user' => $order->user, 'barangay_orders' => true])
          </div>
        @endforeach

        <div>
        {{ $orders->links() }}
        </div>
      @endif

      @if (count($orders) == 0)
      <div class="alert alert-info">
        No requests yet.
      </div>
      @endif
    </div>
	</div>	
</div>

@include('partials.contact-modal')
@endsection

@section('foot_scripts')
<script src="{{ mix('js/barangay-orders.js') }}" defer></script>
<script src="{{ mix('js/view-contact.js') }}" defer></script>
@endsection