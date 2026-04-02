{{-- Kandungan dalaman #confirm_order — dikongsi dock tetap & drawer sidenav --}}
@php
	$asDrawer = $asDrawer ?? false;
@endphp
<div id="scrollOrderContainer" class="{{ $asDrawer ? '' : 'order-cart-dock__scroll' }}"@if($asDrawer) style="height: 100vh"@endif>
	<table class="order-item table-sm table-borderless mt-3 text-light">
		<tbody class="order-item-master d-none">
			<tr class="rowitem" fid="">
				<td width="70" class=""><img src="{{ URL::asset('img/icon/dinning.svg') }}" alt="" class="list-group-icon" /></td>
				<td class="">
					<h5 class="fw-600 mb-3" item-name>Chat Masala</h5>
					<table class="table-sm table-borderless">
						<tr>
							<td class="pe-0" style="width: 1px"><button type="button" class="btn btn-success btn-sm qty-rem"><span class="fa fa-minus"></span></button></td>
							<td class="px-2 text-center" style="width: 60px"><span class="h6 fw-600" item-qty>4</span></td>
							<td class="" style="width: 1px"><button type="button" class="btn btn-success btn-sm qty-add"><span class="fa fa-plus"></span></button></td>
							<td class=" text-end"><span class="h6 fw-600" item-amt>20.00</span></td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
		<tbody id="order-list"></tbody>
	</table>
</div>
<div class="sideright-footer {{ $asDrawer ? '' : 'order-cart-dock__footer' }}">
	<table class="table table-borderless p-0">
		<tr class="sum-total">
			<th class="text-start align-middle"><span class="fs-5 text-light fw-500 align-middle">Total Amount</span></th>
			<th class="text-end align-middle"><span class="fs-4 text-light fw-600" order-total>0.00</span></th>
		</tr>
		<tr>
			<th colspan="2" class="p-0">
				<button type="button" class="btn btn-lg btn-success fw-400 fs-5 btn-block py-3 rounded-0 shadow-0 text-capitalize"
					id="confirm-order-button"
					@if($asDrawer) data-toggle="sidenav" data-target="#confirm_order" @endif>Finish Ordering</button>
			</th>
		</tr>
	</table>
</div>
