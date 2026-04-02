<button type="button" class="btn btn-danger btn-rounded btn-lg fw-500 text-capitalize"
	@if(config('ordering.order_cart_drawer')) data-toggle="sidenav" data-target="#confirm_order" @endif
	aria-controls="confirm_order">
	Items in Cart (<span class="count-order">0</span>)
</button>
