<div class="card mt-1 offset-1">
  <div class="card-body">

    <div class="row">
      <div class="col-md-12">
        <div class="float-right">
        <small class="text-secondary">{{ diffForHumans($bid->created_at) }}</small>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div>
          <div class="d-flex flex-row mt-2">
            <div>
              <img src="{{ $bid_user->photo }}" style="width: 50px;" class="img-thumbnail" alt="{{ $bid_user->name }}">
            </div>

            <div class="pl-2">
              <a href="/user/{{ $bid->user_id }}/reputation">{{ $bid_user->name }}</a>
              <div>
                @if ($bid_user->user_type == 'officer')
                <span class="badge badge-info">officer</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-2">
      <strong>Service Fee: </strong> {{ money($bid->service_fee) }}
      @include('partials.components.status-badge', ['status' => $bid->status])
    </div>

    <div class="py-1">
      {{ $bid->notes }}
    </div>

    @include('partials.card-actions.order')
  </div>
</div>