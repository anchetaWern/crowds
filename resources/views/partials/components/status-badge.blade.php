@if ($page == 'orders' || $page == 'bids')
	@if ($status == 'accepted')
	  <span class="badge badge-warning">accepted</span>
	@endif

	@if ($status == 'fulfilled')
	  <span class="badge badge-success">fulfilled</span>
	@endif

	@if ($status == 'expired')
	  <span class="badge badge-secondary">expired</span>
	@endif

	@if ($status == 'no_show')
	  <span class="badge badge-danger">no show</span>
	@endif

	@if ($status == 'cancelled')
	  <span class="badge badge-dark">cancelled</span>
	@endif
@endif