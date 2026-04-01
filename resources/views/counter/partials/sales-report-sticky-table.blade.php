{{--
  Jadual split header/body + footer untuk laporan kategori (Daily / Monthly / Yearly).
  @param string $tbodyId id pada <tbody> data
  @param string $footerId id pada bekas footer ringkasan
--}}
<div class="sales-table-sticky">
	<div class="sales-table-head-wrap">
		<table class="table table-borderless table-sales table-sales-split-head mb-0">
			<colgroup>
				<col style="width: 46%">
				<col style="width: 18%">
				<col style="width: 36%">
			</colgroup>
			<thead>
				<tr class="thead-tr fw-500">
					<td class="text-start">Category Name</td>
					<td class="text-center">Quantity</td>
					<td class="text-end">Amount</td>
				</tr>
			</thead>
		</table>
	</div>
	<div class="sales-table-scroll">
		<table class="table table-borderless table-sales table-sales-split-body mb-0">
			<colgroup>
				<col style="width: 46%">
				<col style="width: 18%">
				<col style="width: 36%">
			</colgroup>
			<tbody id="{{ $tbodyId }}"></tbody>
		</table>
	</div>
	<div class="sales-summary-footer px-0" id="{{ $footerId }}"></div>
</div>
