{{-- 
    Component untuk jadual ringkasan resit (summary table)
    
    Parameters:
    - $type: 'sales' atau 'report'
    - $showPayment: boolean (default: false) - papar baris Paid/Change
    - $showThankYou: boolean (default: false) - papar mesej Thank You
--}}
@php
    $isReport = $type === 'report';
    $tableClass = $isReport ? 'receipt-sale-infopaid receipt-sale-report-summary' : 'receipt-sale-infopaid to-hide';
    $discountRowClass = $isReport ? 'discount-row-report' : 'discount-row';
    $labelClass = $isReport ? 'receipt-summary-label receipt-summary-label-bold' : 'receipt-summary-label';
    $valueClass = $isReport ? 'receipt-summary-value receipt-summary-value-bold' : 'receipt-summary-value';
@endphp

<style>
.receipt-summary-label {
    text-align: left;
}
.receipt-summary-value {
    text-align: right;
}
.receipt-summary-label, .receipt-summary-value {
    vertical-align: top;
    padding-top: 5px;
    font-size: 11pt !important;
    font-weight: 500;
    color: black;
}
.receipt-summary-label-bold {
    font-weight: 700;
}
.receipt-summary-value-bold {
    font-weight: 700;
}
</style>

<table class="{{ $tableClass }}">
    <tr>
        <td class="{{ $labelClass }}">Subtotal</td>
        <td class="subtotal {{ $valueClass }}">0.00</td>
    </tr>
    <tr>
        <td class="{{ $labelClass }}">Tax</td>
        <td class="tax {{ $valueClass }}">0.00</td>
    </tr>
    <tr>
        <td class="{{ $labelClass }}">Net Total</td>
        <td class="total {{ $valueClass }}">0.00</td>
    </tr>
    <tr class="{{ $discountRowClass }}">
        <td class="{{ $labelClass }}">Discount</td>
        <td class="discount {{ $valueClass }}">0.00</td>
    </tr>
    <tr>
        <td class="{{ $labelClass }}">Total</td>
        <td class="grand {{ $valueClass }}">0.00</td>
    </tr>
    @if($showPayment ?? false)
    <tr>
        <td class="receipt-summary-label">Paid</td>
        <td class="paid receipt-summary-value">0.00</td>
    </tr>
    <tr>
        <td class="receipt-summary-label">Change</td>
        <td class="bal receipt-summary-value">0.00</td>
    </tr>
    @endif
</table>

@if($showThankYou ?? false)
<hr class="receipt-sale-separator to-hide">
<p class="to-hide" style="width: 100%; text-align: center">Thank You</p>
@endif
