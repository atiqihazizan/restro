<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Panel pesanan (senarai order)
	|--------------------------------------------------------------------------
	|
	| false = panel tetap di kanan (order-cart-dock) dalam barisan menu
	| true  = drawer MDB Sidenav (buka/tutup, backdrop) — seperti asal
	|
	| Tetapkan di .env: ORDERING_ORDER_CART_DRAWER=true
	|
	*/
	'order_cart_drawer' => (bool) env('ORDERING_ORDER_CART_DRAWER', false),

];
