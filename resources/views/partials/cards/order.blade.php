<div class="card card-main">
  <div class="card-body">
    <div class="float-right">
      <small class="text-secondary">{{ diffForHumans($order->created_at) }}</small>
    </div>

    <div class="d-flex flex-row mt-1">
      <div>
        <img src="{{ $order_user->photo }}" style="width: 50px;" class="img-thumbnail" alt="{{ $order_user->name }}">
      </div>
      <div class="pl-2">
        <a href="/user/{{ $order_user->id }}/reputation">{{ $order_user->name }}</a>
        @if ($order_user->user_type == 'officer')
        <div>
          <span class="badge badge-info">officer</span>
        </div>
        @endif

        @if (!empty($orders_feed) && $order->postedBids->count())
        <div>
          <span class="badge badge-primary">{{ $order->postedBids->count() }} {{ Str::plural('bid', $order->postedBids->count()) }}</span>
        </div>
        @endif
      </div>
    </div>

    <div class="mt-2">
      @if (empty($orders_feed) && ($page == 'orders' || $page == 'bids'))
      <strong>Request #{{ orderNumber($order->id) }}</strong>
      @endif

      @include('partials.components.status-badge', ['status' => ($page == 'orders') ? $order->status : $bid->status])
    </div>

    <div class="mt-2">
      <span class="badge badge-success">{{ $service_types_arr[$order->service_type_id] }}</span>
    </div>

    <div>
      {{ $order->description }}
    </div>
    
    @if ($page == 'bids' && $bid->status == 'accepted')
      @include('partials.components.contact-button', ['contact_user_id' => $order->user_id])
    @endif

    @if (!empty($barangay_orders) && Auth::user()->user_type == 'officer')
    <div class="mt-1">
      <form action="/barangay-order/fulfilled" method="POST">
        @method('PATCH')
        @csrf
        @honeypot
        <input type="hidden" name="_order_id" value="{{ $order->id }}">
        <button type="button" class="btn btn-sm btn-success float-right fulfill-order" data-user="{{ $order->user->name }}">Fulfill</button>
      </form>
      
      <button class="btn btn-sm btn-secondary mr-2 float-right view-contact" data-userid="{{ $order->user_id }}" type="button">
        Contact
      </button>
    </div>
    @endif
  
    @if (!empty($orders_feed) && Auth::id() != $order->user->id && Auth::user()->hasNoBids($order->postedBids) && $order->postedBids->count() < 10)
    <button class="btn btn-sm btn-success float-right bid" data-id="{{ $order->id }}" data-recipient="{{ $order->user->name }}" data-service-type="{{ $service_types_arr[$order->service_type_id] }}" data-description="{{ $order->description }}" data-datetime="{{ $order->created_at }}" data-friendlydatetime="{{ friendlyDatetime($order->created_at) }}">Bid</button>
    @endif
  </div>
</div>