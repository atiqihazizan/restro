<div class="pos d-flex">
	<div class="pos-sidebar p-0">
		<div class="text-start d-flex">
			<h3 class="w-100 bg-black mb-0 p-3 text-start flex-fill" data-table-name>&nbsp;</h3>
			<div class="d-flex">
				<button class="btn fs-2" title="Print Receipt" print-receipt><i class="fa fa-print text-primary"></i></button>
				<button class="btn fs-2 ms-2" title="Print to kichen" print-tokichen><i class="fa fa-print text-danger"></i></button>
			</div>
		</div>
		<table class="table table-borderless table-flush table-to-pay header">
			<thead>
				<tr class="thead-tr fw-500">
					<th class="item">Item</th>
					<th class="price">Price</th>
					<th class="qnt">Qnt</th>
					<th class="total">Total($)</th>
				</tr>
			</thead>
			<tbody class="billing-master d-none">
				<tr>
					<td class="item">&nbsp;</td>
					<td class="price">0.00</td>
					<td class="qnt">0</td>
					<td class="total">0.00</td>
				</tr>
			</tbody>
		</table>
		<div class="empty" style="overflow-y: auto; height: calc(100vh - 299px)">
			<table class="table table-borderless table-flush table-to-pay body">
				<tbody class="billing"></tbody>
			</table>
		</div>
		<table class="table table-borderless table-flush table-to-pay footer">
			<tfoot>
				<tr class="gray-black net">
					<th>total</th>
					<th data-subt>0.00</th>
				</tr>
			</tfoot>
		</table>
		<div class="button-pay d-flex">
			<button class="btn btn-primary btn-lg text-capitalize" id="take-order" disabled>Take Order</button>
			<button class="btn btn-success btn-lg text-capitalize" id="btn_to_pay" disabled>Pay</button>
		</div>
	</div>
	<div id="pos-desk" class="flex-fill">
		<div class="pos-table">
			<div class="table-list" data-table-list></div>
		</div>
	</div>
</div>
@push('modal')
<style>
	.input-field-editable {
		background-color: rgba(128, 128, 128, 0.5) !important;
		padding: 0.25rem 0.5rem !important;
		border-radius: 4px !important;
		width: 100% !important;
		cursor: pointer !important;
		transition: background-color 0.2s ease !important;
	}

	.input-field-editable:hover {
		background-color: rgba(128, 128, 128, 0.7) !important;
	}

	.input-field-editable.input-active {
		background-color: rgba(0, 123, 255, 0.2) !important;
		box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5) !important;
	}
	.text-bigger {
		font-size: 3.5rem !important;
		font-weight: 600;
		/* color: #007bff; */
	}
	.input-field-editable.text-bigger {
		padding: 0! important;
	}
</style>
<div class="modal top fade" id="calculate" tabindex="-1" aria-labelledby="PayBillModalLabel">
	<div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 814px">
		<div class="modal-content rounded-9">
			<div class="modal-header border-0 pb-0">
				<h3 class="modal-title fw-bold text-black">Pay Bill</h3>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-5">
						<div class="pos-calculate" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
							<button type="button" class="btn btn-num" data-num-val="7">7</button>
							<button type="button" class="btn btn-num" data-num-val="8">8</button>
							<button type="button" class="btn btn-num" data-num-val="9">9</button>
							<button type="button" class="btn btn-num" data-num-val="4">4</button>
							<button type="button" class="btn btn-num" data-num-val="5">5</button>
							<button type="button" class="btn btn-num" data-num-val="6">6</button>
							<button type="button" class="btn btn-num" data-num-val="1">1</button>
							<button type="button" class="btn btn-num" data-num-val="2">2</button>
							<button type="button" class="btn btn-num" data-num-val="3">3</button>
							<button type="button" class="btn btn-num" data-num-val="c">c</button>
							<button type="button" class="btn btn-num" data-num-val="0">0</button>
							<button type="button" class="btn btn-num" data-num-val=".">.</button>
						</div>
						<div class="col-12 mt-3">
							<button class="btn btn-success btn-lg btn-block w-100" to-ledger>Enter</button>
							<button class="btn btn-danger btn-lg btn-block w-100" data-dismiss="modal">Cancel</button>
						</div>
					</div>
					<div class="col-md-7 d-flex flex-column justify-content-between">
						<div class="table-amount" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; color: #333;">
							<div class="fs-2 pt-0">Sub Total</div>
							<div class="fs-2 pt-0 text-right"><span class="text-black" data-subtotal>0.00</span></div>
							<div class="fs-2 pt-0">Discount <small class="fs-5" data-disc-percent>(0%)</small></div>
							<div class="fs-2 pt-0 text-right text-black input-field-editable" data-disc>0.00</div>
							<div class="fs-2 pt-0">Tax <small class="fs-5" data-tax-percent>(0%)</small></div>
							<div class="fs-2 pt-0 text-right text-black input-field-editable" data-tax>0.00</div>
							<!-- <div class="fs-2 pt-0">Net</div>
							<div class="fs-2 pt-0 text-right"><span class="text-black" data-total>0.00</span></div> -->
						</div>
						<div class="table-amount" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; color: #333;">
							<div class="fs-2 pt-0 text-bigger">Total</div>
							<div class="fs-2 pt-0 text-right"><span class="text-black text-bigger" data-grand>0.00</span></div>
							<div class="fs-2 pt-0 text-bigger">Paid</div>
							<div class="fs-2 pt-0 text-right text-black input-field-editable input-active text-bigger" data-pay>0.00</div>
							<div class="fs-2 pt-0 text-bigger">Bal</div>
							<div class="fs-2 pt-0 text-right"><span class="text-black text-bigger" data-bal>0.00</span></div>
						</div>
					</div>
				</div>
				<!-- <div class="row d-flex justify-content-between gap-1 px-3 mt-3">
					<button class="btn btn-success btn-lg btn-block" to-ledger>Enter</button>
					<button class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
				</div> -->

			</div>
		</div>
	</div>
</div>
@endpush
@push('javascript')
<script>
	var intervalCount = 0;
	var mdb_table = function() {
		var modalPay;
		var pagePos;
		var keyPay = '';
		var bill = {}
		var masterEl;
		var modalEl;
		window.discountFieldUnlocked = false

		async function refreshDeskGrid() {
			let res = await axios.get(APP_URL + 'ordering/?getpos=true')
			let tables = res.data.table ?? [];
			let tableContainer = pagePos.querySelector('[data-table-list]')
			// sts 0–4: gaya warna latar ditentukan oleh .pos-table-card--s{n} dalam grid-cards.css
			tableContainer.innerHTML = tables.map((t, n) => {
				const label = String(t.name)
				const split = label.match(/^(.*?)\s+(\d+)$/)
				const titleHtml = split ?
					`<span class="pos-table-line pos-table-line--label">${split[1]}</span><span class="pos-table-line pos-table-line--num">${split[2]}</span>` :
					`<span class="pos-table-line pos-table-line--single">${label}</span>`
				const rawSts = Number(t.sts)
				const s = Number.isFinite(rawSts) ? Math.min(4, Math.max(0, Math.floor(rawSts))) : 0
				return `<a data-id="${t.id}" data-order-id="${t.order_id}" data-name="${t.name}" data-sts="${s}" class="view-order pos-table-tile h-100 w-100 d-block text-decoration-none text-capitalize">
						<div class="card pos-table-card pos-table-card--s${s} border-0 shadow-none h-100">
							<div class="card-body pos-table-card-body d-flex flex-column justify-content-center align-items-center py-3 px-2">
								<div class="pos-table-card-title text-white text-center">${titleHtml}</div>
							</div>
						</div>
					</a>`
			}).join('')
			tableContainer.querySelectorAll('.view-order').forEach(function(b) {
				b.addEventListener('dblclick', async function(e) {
					e.preventDefault()
					pagePos.querySelector('#take-order').click();
				})
				b.addEventListener('click', async function() {
					tableContainer.querySelectorAll('.view-order.active').forEach(a => a.classList.remove('active'))
					this.classList.add('active')
					let oid = this.dataset.orderId * 1
					let idx = this.dataset.id * 1
					let tname = this.dataset.name
					pagePos.querySelector('[data-table-name]').innerHTML = tname
					pagePos.querySelector('#take-order').removeAttribute('disabled')
					document.querySelector('meta[name="table"]').setAttribute('content', idx)

					if (oid == 0) {
						resetBtnPay()
						return 
					}
					bill.oid = oid
					drawReceipt()
				})
			})
		}
		async function drawReceipt() {
			let res = await axios.get(APP_URL + 'counter/' + bill.oid + '/pos')
			let data = res.data ?? []
			let item = data.item;
			let subt = data.subt;
			let arry = {}
			let tbody = pagePos.querySelector('.table-to-pay.body tbody.billing');
			let html = item.map(d => {
				let el = masterEl.cloneNode(true)
				let tr = el.querySelector('tr')
				if (!arry[d.food_id]) arry[d.food_id] = [d.food_id, d.cate_id, '', '', '', '', 0]
				arry[d.food_id][4] = d.name
				arry[d.food_id][6] += d.qty

				el.querySelector('.item').innerHTML = d.name;
				el.querySelector('.price').textContent = d.price;
				el.querySelector('.qnt').textContent = d.qty;
				el.querySelector('.total').textContent = d.amount;

				tr.setAttribute('row-item-idx', d.id)
				return el.innerHTML
			}).join('')
			data.paid_at = ''
			data.rcptno = ''
			data.subtotal = 0
			mdb_ordering.tokichen(data.desk.name, Object.values(arry))
			mdb_salexpen.receipt(data, {
				posLineSubtotalSlot: true
			});

			pagePos.querySelector('.table-to-pay.footer [data-subt]').textContent = subt;
			bill.total = subt.replace(',', '') * 1;

			pagePos.querySelector('[data-table-name]').innerHTML = data.desk.name
			pagePos.querySelector('#btn_to_pay').removeAttribute('disabled')
			tbody.innerHTML = html
			tbody.querySelectorAll('[row-item-idx]').forEach(function(r) {
				r.addEventListener('dblclick', function(e) {
					let idx = this.getAttribute('row-item-idx')
					e.preventDefault()
					axios.delete(APP_URL + 'ordering/' + idx).then(function(res) {
						let data = res.data;
						if (data.success ?? false) {
							if (data.count > 0) {
								drawReceipt();
							} else {
								resetBtnPay();
								refreshDeskGrid();
							}
						}
					})
				})
			})

		}

		function initPayment() {
			const payAmountMax = 99999999.99
			let modalCalc = document.getElementById('calculate')
			// let inputTotal = modalCalc.querySelector('[data-total]')
			let inputSubtotal = modalCalc.querySelector('[data-subtotal]')
			let inputGrand = modalCalc.querySelector('[data-grand]')
			let inputPay = modalCalc.querySelector('[data-pay]')
			let inputBal = modalCalc.querySelector('[data-bal]')
			let inputTax = modalCalc.querySelector('[data-tax]')
			let inputDisc = modalCalc.querySelector('[data-disc]')
			let inputAmt;
			let calcTimeout = null;

			function constrainKeyPayDecimals(raw, maxFrac) {
				if (raw === null || raw === undefined) {
					return '';
				}
				var s = String(raw).replace(/[^\d.]/g, '');
				if (s.indexOf('.') === -1) {
					return s;
				}
				var firstDot = s.indexOf('.');
				var intPart = s.slice(0, firstDot);
				var frac = s.slice(firstDot + 1).replace(/\./g, '');
				frac = frac.slice(0, maxFrac);
				return intPart + '.' + frac;
			}

			function parseFiniteFromKeypay(k) {
				if (!k || k === '.' || /\.$/.test(k)) {
					return NaN;
				}
				var n = parseFloat(k);
				return isFinite(n) ? n : NaN;
			}

			function paidDisplayWhileTyping(keyPay) {
				keyPay = constrainKeyPayDecimals(keyPay, 2);
				if (!keyPay) {
					return currency(0);
				}
				var trailingDot = /\.$/.test(keyPay);
				var nBase = trailingDot ? parseFloat(keyPay.slice(0, -1) || '0') : parseFloat(keyPay);
				if (trailingDot) {
					return currency(nBase).replace(/(\.\d{2})$/, '.');
				}
				return currency(nBase);
			}

			async function recalculateFromServer() {
				if (!bill.oid) return;
				try {
					const res = await axios.post(APP_URL + 'counter/' + bill.oid + '/calculate', {
						taxnum: bill.taxnum || 0,
						discnum: bill.discnum || 0,
						_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
					});
					if (res.data.success) {
						bill.tax = res.data.tax;
						bill.net = res.data.net;
						bill.disc = res.data.disc;
						bill.grand = res.data.grand;

						inputTax.textContent = currency(bill.tax);
						// inputTotal.textContent = currency(bill.net);
						inputDisc.textContent = currency(bill.disc);
						inputGrand.textContent = currency(bill.grand);

						bill.bal = bill.grand - (bill.amt || 0);
						inputBal.textContent = currency(bill.bal);
					}
				} catch (err) {
					console.error('Calculate error:', err);
				}
			}
			modalCalc.querySelectorAll('.btn-num').forEach(function(b) {
				b.addEventListener('click', function(e) {
					let v = this.getAttribute('data-num-val')
					let num = 0

					e.preventDefault()
					// re-call element
					inputAmt = modalCalc.querySelector('.table-amount .input-active')
					inputPay = modalCalc.querySelector('[data-pay]')
					inputTax = modalCalc.querySelector('[data-tax]')
					inputDisc = modalCalc.querySelector('[data-disc]')

					if (v === 'c') {
						keyPay = ''
						if (inputAmt.hasAttribute('data-tax')) {
							bill.tax = 0
							bill.taxnum = 0
							inputAmt.textContent = currency(0)
							modalCalc.querySelector('[data-tax-percent]').textContent = '(0%)'
							recalculateFromServer()
						}
						if (inputAmt.hasAttribute('data-disc')) {
							bill.disc = 0
							bill.discnum = 0
							inputAmt.textContent = currency(0)
							modalCalc.querySelector('[data-disc-percent]').textContent = '(0%)'
							recalculateFromServer()
						}
						if (inputAmt.hasAttribute('data-pay')) {
							bill.amt = 0
							inputAmt.textContent = currency(0)
							bill.bal = bill.grand - bill.amt
							inputBal.textContent = currency(bill.bal)
						}
						return
					}
					if (v === '.') {
						if (String(keyPay).lastIndexOf('.') !== -1) {
							return;
						}
					}
					keyPay += v.toString();

					var isTax = inputAmt.hasAttribute('data-tax');
					var isDisc = inputAmt.hasAttribute('data-disc');
					var isPct = isTax || isDisc;
					var maxFrac = isPct ? 4 : 2;
					keyPay = constrainKeyPayDecimals(keyPay, maxFrac);

					num = parseFiniteFromKeypay(keyPay);

					var pctLabelEl = null;
					if (isTax) {
						pctLabelEl = modalCalc.querySelector('[data-tax-percent]');
					} else if (isDisc) {
						pctLabelEl = modalCalc.querySelector('[data-disc-percent]');
					}

					if (isTax) {
						if (isFinite(num) && num > 100) {
							keyPay = keyPay.slice(0, -1);
							return;
						}
						if (isFinite(num)) {
							bill.taxnum = num;
							pctLabelEl.textContent = '(' + num + '%)';
							if (calcTimeout) clearTimeout(calcTimeout);
							calcTimeout = setTimeout(function () { recalculateFromServer(); }, 300);
						} else {
							var showPct = keyPay === '.' ? '0.' : keyPay;
							pctLabelEl.textContent = '(' + showPct + '%)';
						}
					}
					if (isDisc) {
						if (isFinite(num) && num > 100) {
							keyPay = keyPay.slice(0, -1);
							return;
						}
						if (isFinite(num)) {
							bill.discnum = num;
							pctLabelEl.textContent = '(' + num + '%)';
							if (calcTimeout) clearTimeout(calcTimeout);
							calcTimeout = setTimeout(function () { recalculateFromServer(); }, 300);
						} else {
							var showPct2 = keyPay === '.' ? '0.' : keyPay;
							pctLabelEl.textContent = '(' + showPct2 + '%)';
						}
					}
					if (inputAmt.hasAttribute('data-pay')) {
						var trailingPayDot = /\.$/.test(keyPay);
						var payParsed;
						if (keyPay === '' || keyPay === '.') {
							payParsed = 0;
						} else if (trailingPayDot) {
							payParsed = parseFloat(keyPay.slice(0, -1) || '0');
						} else {
							payParsed = parseFloat(keyPay);
						}
						if (!isFinite(payParsed)) {
							payParsed = 0;
						}
						if (keyPay === '.' || keyPay === '') {
							inputAmt.textContent = paidDisplayWhileTyping(keyPay || '.');
							bill.amt = 0;
							bill.bal = bill.grand;
							inputBal.textContent = currency(bill.bal);
							return;
						}
						if (payParsed > payAmountMax) {
							keyPay = keyPay.slice(0, -1);
							return;
						}
						bill.amt = payParsed;
						inputAmt.textContent = trailingPayDot ? paidDisplayWhileTyping(keyPay) : currency(bill.amt);
						inputPay = modalCalc.querySelector('[data-pay]');
						bill.bal = bill.grand - bill.amt;
						inputBal.textContent = currency(bill.bal);
					}
				})
			})
			pagePos.querySelector('#btn_to_pay').addEventListener('click', function(e) {
				e.preventDefault()
				resetPanelPay()
				modalPay.show();
			})
			modalCalc.querySelector('[to-ledger]').addEventListener('click', function(e) {
				e.preventDefault()
				let dp = {
					paid: bill,
					_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				}
				if (bill.amt == 0) return;
				if (bill.bal > 0) return;
				axios.post(APP_URL + 'counter/' + bill.oid + '/pos', dp).then(res => {
					let data = res.data;
					modalPay.hide();
					mdb_salexpen.sales(data.receipt);
					if (!data.success) {
						console.log(data);
						return;
					}

					if (typeof publishOrderPaid === 'function') {
						publishOrderPaid(bill.oid);
					}

					refreshDeskGrid();
					resetBtnPay()
					resetPanelPay()
				}).catch(e => console.error(e.message))
			})

			function resetPanelPay() {
				keyPay = ''
				const sub = Number(bill.total) || 0
				inputSubtotal.textContent = currency(sub);
				// inputTotal.textContent = currency(sub);
				inputGrand.textContent = currency(sub);
				inputPay.textContent = currency(0);
				inputTax.textContent = currency(0);
				inputDisc.textContent = currency(0);
				inputBal.textContent = currency(sub);
				modalEl.querySelector('[data-tax-percent]').textContent = '(0%)';
				modalEl.querySelector('[data-disc-percent]').textContent = '(0%)';
				bill.amt = 0
				bill.tax = 0
				bill.disc = 0
				bill.net = sub
				bill.grand = sub
				bill.bal = sub
				bill.taxnum = 0;
				bill.discnum = 0;

				window.discountFieldUnlocked = false

				modalEl.querySelectorAll('.input-active').forEach(e => e.classList.remove('input-active'))
				modalEl.querySelector('[data-pay]').classList.add('input-active')
			}
		}

		function resetBtnPay() {
			// pagePos.querySelector('[data-table-name]').innerHTML = ''
			pagePos.querySelector('.table-to-pay.body tbody.billing').innerHTML = '';
			pagePos.querySelector('#btn_to_pay').setAttribute('disabled', 'disabled')
			pagePos.querySelector('.table-to-pay.footer [data-subt]').textContent = '0.00';

			return false;
		}
		async function subscribe() {
			let url = APP_URL + "ordering/status"
			let sec = 1000
			try {
				let response = await axios(url);
				if (response.status === 200) {
					if (response.data === 1) {
						pagePos.querySelector('[data-table-name]').innerHTML = '&nbsp;'
						refreshDeskGrid().then(() => resetBtnPay())
					}
					// Reconnect in 10 second
					await new Promise(resolve => setTimeout(resolve, sec));
					await subscribe();
				} else {
					// Got message
					// let message = await response.text();
					console.error(response.statusText)
					await new Promise(resolve => setTimeout(resolve, sec));
					await subscribe();
				}
			} catch (err) {
				// catches errors both in fetch and response.json
				// let's reconnect
				console.error('Error throw! ' + err)
				await new Promise(resolve => setTimeout(resolve, sec));
				await subscribe();
			}
		}

		return {
			init: function() {
				pagePos = document.getElementById('pos')
				modalEl = document.getElementById('calculate')
				modalPay = new mdb.Modal(modalEl, {
					backdrop: 'static',
					keyboard: false
				})
				function blurPayBillModalFocus() {
					var ae = document.activeElement
					if (ae && modalEl.contains(ae)) ae.blur()
				}
				modalEl.addEventListener('hide.bs.modal', blurPayBillModalFocus)
				modalEl.addEventListener('hide.mdb.modal', blurPayBillModalFocus)
				masterEl = pagePos.querySelector('.billing-master')

				refreshDeskGrid()
				initPayment()
				// subscribe();
				pagePos.querySelector('#take-order').addEventListener('click', function(e) {
					e.preventDefault()
					document.getElementById('itemcart').classList.remove('d-none')
					pageNav('order')
					mdb_ordering.reset();
				})
				modalEl.querySelector('[data-tax]').addEventListener('click', function(e) {
					modalEl.querySelectorAll('.input-active').forEach(e => e.classList.remove('input-active'))
					keyPay = '';
					e.preventDefault()
					this.classList.add('input-active')
				})
				modalEl.querySelector('[data-disc]').addEventListener('click', function(e) {
					e.preventDefault()
					keyPay = ''
					var discEl = this

					function activateDisc() {
						modalEl.querySelectorAll('.input-active').forEach(function(el) {
							el.classList.remove('input-active')
						})
						discEl.classList.add('input-active')
					}
					if (window.discountFieldUnlocked) {
						activateDisc()
						return
					}
					if (typeof window.openRestroCredentialModal !== 'function') {
						alert('Credential modal tidak tersedia.')
						return
					}
					window.openRestroCredentialModal(function() {
						window.discountFieldUnlocked = true
						activateDisc()
					})
				})
				modalEl.querySelector('[data-pay]').addEventListener('click', function(e) {
					modalEl.querySelectorAll('.input-active').forEach(e => e.classList.remove('input-active'))
					keyPay = '';
					e.preventDefault()
					this.classList.add('input-active')
				})
				// print-receipt
				pagePos.querySelector('[print-receipt]').addEventListener('click', function() {
					const modalPrintEl = document.getElementById('sale_receipt')
					let html = modalPrintEl.querySelector('#receipt-container').innerHTML
					let el = pagePos.querySelector('.table-to-pay.body tbody.billing').innerHTML
					if (el == '') return
					printJS(html, 'Receipt Sales')
				})
				pagePos.querySelector('[print-tokichen]').addEventListener('click', function() {
					let orderEl = document.getElementById('print_order')
					let htmlEL = document.getElementById('order-print-container').innerHTML
					let el = pagePos.querySelector('.table-to-pay.body tbody.billing').innerHTML
					if (el == '') return
					if (!bill.oid) return
					printJS(htmlEL, 'Order Kitchen')

					axios.get(APP_URL + 'counter/' + bill.oid + '/pos').then(res => {
						const salesIds = res.data.item ? res.data.item.map(i => i.id) : []
						if (salesIds.length > 0) {
							axios.post(APP_URL + 'ordering/' + bill.oid + '/printed', {
								sales_ids: salesIds,
								_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
							}).catch(err => console.error('Mark printed error:', err))
						}
					}).catch(err => console.error('Get items error:', err))
				})
			},
			reload: async function(res) {
				bill.oid = res.data.id
				refreshDeskGrid().then(() => {
					document.querySelector('.nav-link-page.nav-counter[href="#pos"]').click()
					drawReceipt();
				})
			},
			data: bill,
		}
	}()
	mdb_table.init();
</script>
@endpush