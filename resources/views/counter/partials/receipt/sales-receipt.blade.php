<style>
.receipt-header-info {
    vertical-align: top;
    font-size: 10pt;
}
.receipt-header-info-right {
    vertical-align: top;
    font-size: 10pt;
    text-align: right;
}
</style>

<div sales-receipt style="display: none">
    <div class="receipt-sale-info">
        <table style="margin-right: 0; padding-right: 0; width: 100%">
            <tr>
                <td class="receipt-sale-paid_at paid_at receipt-header-info" colspan="3"></td>
            </tr>
            <tr>
                <td class="receipt-sale-table_no table_no receipt-header-info"></td>
                <td class="receipt-sale-receipt_no receipt_no receipt-header-info-right"></td>
            </tr>
        </table>
    </div>
    <hr class="receipt-sale-separator">
    <table class="receipt-sale-item">
        <tbody class="clone-row"></tbody>
    </table>
    <hr class="receipt-sale-separator" style="margin: 0; margin-top: .7rem;margin-bottom: .7rem;">
    {{-- Slot jumlah baris selepas separator: hanya POS pratontun/print sidebar (`posLineSubtotalSlot`). Default disembunyikan. --}}
    <div class="receipt-pos-line-subtotal d-none" data-receipt-pos-line-subtotal>
        <table class="receipt-sale-item receipt-sale-item-subtotal" style="width: 100%; margin: 0; margin-bottom: 1rem;">
            <tbody class="receipt-items-subtotal-tbody"></tbody>
        </table>
    </div>

    @include('counter.partials.receipt.summary-table', [
        'type' => 'sales',
        'showPayment' => true,
        'showThankYou' => true
    ])
</div>
