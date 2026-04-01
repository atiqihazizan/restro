<style>
.receipt-header-report {
    vertical-align: top;
    font-size: 9pt;
    font-weight: 700;
}
</style>

<div report-receipt style="display: none">
    <div class="receipt-sale-info">
        <table style="margin-right: 0; padding-right: 0; width: 100%">
            <tr>
                <td class="receipt-sale-date_at date_at receipt-header-report"></td>
            </tr>
        </table>
    </div>
    <hr class="receipt-sale-separator">
    <table class="receipt-sale-item">
        <tbody></tbody>
    </table>
    <hr class="receipt-sale-separator" style="margin: 0; margin-top: .7rem; margin-bottom: .7rem;">
    
    @include('counter.partials.receipt.summary-table', [
        'type' => 'report',
        'showPayment' => false,
        'showThankYou' => false
    ])
</div>
