{{--
	Suis panel pesanan: dock tetap (lalai) vs drawer MDB.
	Tetapkan config('ordering.order_cart_drawer') atau .env ORDERING_ORDER_CART_DRAWER=true
--}}
@if(config('ordering.order_cart_drawer'))
@push('modal')
<div id="confirm_order"
	class="sidenav gray-black shadow-0"
	role="navigation"
	data-scroll-container="#scrollOrderContainer"
	data-backdrop-class="backdrop-63"
	data-width="356"
	data-content="main"
	data-right="true">
	<div class="d-flex navbar container-fluid h-topbar shadow-0">
		<div class="d-flex w-100 justify-content-between">
			<button type="button" class="btn fw-600 text-white shadow-0 btn-lg text-capitalize" data-toggle="sidenav" data-target="#confirm_order">Close</button>
			@include('ordering.partials.toprightbar')
		</div>
	</div>
	@include('ordering.partials.order-cart-inner', ['asDrawer' => true])
</div>
@endpush
@else
<aside id="confirm_order" class="order-cart-dock gray-black shadow-0" aria-label="Senarai pesanan">
	<div class="order-cart-dock__bar d-flex align-items-center px-3 py-2">
		<h2 class="h5 mb-0 text-white fw-600 text-capitalize flex-fill">Pesanan</h2>
	</div>
	@include('ordering.partials.order-cart-inner', ['asDrawer' => false])
</aside>
@endif
