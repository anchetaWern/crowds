@if ($page == 'orders')
  @if ($order->status == 'posted' && $bid->status == 'posted')
  <form action="/bid/{{ $bid->id }}/accept" method="POST">
    @method('PATCH')
    @csrf
    @honeypot
    <input type="hidden" name="_bidder" value="{{ $bid->user->name }}">
    <input type="hidden" name="_order_id" value="{{ $order->id }}">
    <button type="button" class="btn btn-sm btn-primary float-right accept-bid" data-bidder="{{ $bid->user->name }}">Accept</button>
  </form>
  @endif

  @if ($bid->status == 'accepted')
  <div class="mt-2">
    <div class="float-right">
      <form action="/bid/{{ $bid->id }}/fulfilled" method="POST">
        @method('PATCH')
        @csrf
        @honeypot
        <input type="hidden" name="_order_id" value="{{ $order->id }}">
        <button type="button" class="btn btn-sm btn-success mark-as-fulfilled">Fulfilled</button>
      </form>
    </div>

    <div class="float-right">
      <form action="/bid/{{ $bid->id }}/no_show" method="POST">
        @method('PATCH')
        @csrf
        @honeypot
        <input type="hidden" name="_order_id" value="{{ $order->id }}">
        <button type="button" class="btn btn-sm btn-danger mr-2 mark-as-noshow" data-bidder="{{ $bid->user->name }}" data-bidder-id="{{ $bid->user_id }}" data-user-id="{{ $order->user_id }}">No show</button>
      </form>
    </div>
    
    @include('partials.components.contact-button', ['contact_user_id' => $bid->user_id])
  </div>
  @endif
@endif