@if ($page == 'bids')
	@if ($bid->status == 'posted' || $bid->status == 'accepted')
	<div>
	  <button class="btn btn-sm btn-danger float-right show-bid-cancel-modal" data-id="{{ $bid->id }}">Cancel</button>
	</div>  
	@endif
@endif