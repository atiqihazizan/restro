# Refactor Receipt Components

## Tarikh: 30 Mac 2026

## Masalah Asal

Fail `salexpen.blade.php` mengandungi banyak kod yang berulang (code duplication) untuk 2 jenis resit:
1. **Sales Receipt** - Resit jualan biasa (POS)
2. **Report Receipt** - Resit laporan jualan

Kedua-dua resit mempunyai struktur yang hampir sama dengan perbezaan kecil sahaja.

## Penyelesaian

Kod telah di-refactor dengan membuat **Blade Partial Components** yang modular dan boleh digunakan semula (reusable).

## Struktur Baru

### 1. Partial Components Baru

#### a) `resources/views/counter/partials/receipt/header.blade.php`
- Header resit yang dikongsi bersama
- Mengandungi: Nama syarikat, logo text, alamat

#### b) `resources/views/counter/partials/receipt/summary-table.blade.php`
- Jadual ringkasan yang dikongsi bersama
- Parameter:
  - `$type`: 'sales' atau 'report'
  - `$showPayment`: boolean - papar baris Paid/Change
  - `$showThankYou`: boolean - papar mesej Thank You
- Mengandungi: Subtotal, Tax, Total, Discount, Grand Total, Paid, Change

#### c) `resources/views/counter/partials/receipt/sales-receipt.blade.php`
- Template untuk resit jualan
- Mengandungi: Table No, Receipt No, Paid At, item list
- Menggunakan `summary-table` dengan parameter sales

#### d) `resources/views/counter/partials/receipt/report-receipt.blade.php`
- Template untuk resit laporan
- Mengandungi: Date At, item list
- Menggunakan `summary-table` dengan parameter report

### 2. Fail Yang Diubah

#### `resources/views/counter/salexpen.blade.php`
**Sebelum:** 112 baris kod berulang (baris 110-205)

**Selepas:** 5 baris sahaja
```blade
<div class="receipt-sale-frame">
    @include('counter.partials.receipt.header', ['comp' => $comp])
    @include('counter.partials.receipt.sales-receipt')
    @include('counter.partials.receipt.report-receipt')
</div>
```

## Kelebihan Refactoring

1. **Kod Lebih Ringkas** - Dari 112 baris kepada 5 baris
2. **Mudah Maintain** - Perubahan pada satu tempat sahaja
3. **Reusable** - Boleh digunakan di fail lain (contoh: pos.blade.php)
4. **Konsisten** - Pastikan semua resit mempunyai format yang sama
5. **Mudah Faham** - Struktur lebih jelas dan teratur

## Backup

Fail asal telah di-backup ke:
```
backup/2026-03-30/salexpen copy.blade.php.bak
```

## Fungsi JavaScript

Tiada perubahan pada fungsi JavaScript. Semua selector dan class name kekal sama:
- `.receipt-sale-frame`
- `[sales-receipt]`
- `[report-receipt]`
- `.subtotal`, `.tax`, `.total`, `.discount`, `.grand`
- `.paid`, `.bal`
- `.discount-row`, `.discount-row-report`

## Testing

Perlu test:
1. Print resit jualan dari Sales tab
2. Print laporan dari Daily tab
3. Print laporan dari Monthly tab
4. Print laporan dari Yearly tab
5. Pastikan discount row muncul/hilang dengan betul
6. Pastikan format dan styling kekal sama

## Nota

- Semua class CSS dan selector JavaScript kekal sama
- Tiada perubahan pada logik atau functionality
- Hanya struktur HTML yang diubah untuk lebih modular

---

## Update 1: Betulkan Font Size & Alignment (30 Mac 2026)

### Masalah Ditemui
1. Font size item list (11pt) lebih besar dari summary table (9pt)
2. Alignment tidak konsisten - guna `text-align:top` sepatutnya `vertical-align:top`
3. Qty column tidak center aligned

### Penyelesaian
Betulkan fungsi `receiptPaid()` dalam JavaScript (salexpen.blade.php):
- Tukar font size dari **11pt** kepada **9pt**
- Tukar `text-align:top` kepada `vertical-align:top`
- Tambah `text-align: center` untuk qty column

**Backup:** `backup/2026-03-30/salexpen copy2.blade.php.bak`

---

## Update 2: Betulkan Vertical Alignment Semua Row (30 Mac 2026)

### Masalah Ditemui
Semua row dalam resit tidak mempunyai `vertical-align: top` yang konsisten.

### Penyelesaian
Tambah `vertical-align: top;` dan `text-align: right;` untuk semua `<td>` dalam:
1. summary-table.blade.php - Semua row
2. sales-receipt.blade.php - Header info
3. report-receipt.blade.php - Header info

---

## Update 3: Tambah Padding Top dengan Variable (30 Mac 2026)

### Penambahbaikan
Tambah `padding-top: 5px;` untuk semua row dalam summary table menggunakan variable.

### Perubahan
Dalam `summary-table.blade.php`:

```php
$fontSize = 'font-size:9pt;';
$paddingTop = 'padding-top:5px;';
```

Guna dalam semua `<td>`:
```blade
<td style="vertical-align: top; text-align: left; {{ $paddingTop }} {{ $fontSize }}">Subtotal</td>
```

### Kelebihan
- ✅ Mudah tukar nilai padding/font size di satu tempat sahaja
- ✅ Kod lebih konsisten dan maintainable
- ✅ Spacing antara row lebih selesa untuk dibaca

---

## Update 4: Buat Class Khas untuk Summary Table (30 Mac 2026)

### Penambahbaikan
Tukar dari inline style kepada CSS class untuk summary table supaya lebih mudah maintain.

### Perubahan

#### Class CSS Baru:
```css
.receipt-summary-label {
    vertical-align: top;
    text-align: left;
    padding-top: 5px;
    font-size: 9pt;
}
.receipt-summary-value {
    vertical-align: top;
    text-align: right;
    padding-top: 5px;
    font-size: 9pt;
}
.receipt-summary-label-bold {
    font-weight: 700;
}
.receipt-summary-value-bold {
    font-weight: 700;
}
```

#### Penggunaan:
```blade
<!-- SEBELUM (inline style panjang) -->
<td style="vertical-align: top; text-align: left; padding-top:5px; font-size:9pt; font-weight: 700;">Subtotal</td>

<!-- SELEPAS (class ringkas) -->
<td class="receipt-summary-label receipt-summary-label-bold">Subtotal</td>
```

### Kelebihan
- ✅ Kod HTML lebih ringkas dan bersih
- ✅ Mudah maintain - tukar style di satu tempat sahaja
- ✅ Reusable - boleh guna class di tempat lain
- ✅ Konsisten - semua row guna class yang sama
- ✅ Mudah debug - class name yang jelas dan deskriptif

### Variable PHP:
```php
$labelClass = $isReport ? 'receipt-summary-label receipt-summary-label-bold' : 'receipt-summary-label';
$valueClass = $isReport ? 'receipt-summary-value receipt-summary-value-bold' : 'receipt-summary-value';
```

Report receipt akan dapat class `-bold`, manakala sales receipt tidak.

---

## Update 5: Buat Class Khas untuk Header Info (30 Mac 2026)

### Penambahbaikan
Tukar dari inline style kepada CSS class untuk header info (paid_at, table_no, receipt_no, date_at).

### Perubahan

#### Class CSS Baru untuk Sales Receipt:
```css
.receipt-header-info {
    vertical-align: top;
    font-size: 8pt;
}
.receipt-header-info-right {
    vertical-align: top;
    font-size: 8pt;
    text-align: right;
}
```

#### Class CSS Baru untuk Report Receipt:
```css
.receipt-header-report {
    vertical-align: top;
    font-size: 9pt;
    font-weight: 700;
}
```

### Penggunaan

**Sales Receipt (sales-receipt.blade.php):**
```blade
<!-- SEBELUM -->
<td class="paid_at" style="vertical-align: top; font-size: 8pt;"></td>
<td class="receipt_no" style="vertical-align: top; font-size: 8pt; text-align: right;"></td>

<!-- SELEPAS -->
<td class="paid_at receipt-header-info"></td>
<td class="receipt_no receipt-header-info-right"></td>
```

**Report Receipt (report-receipt.blade.php):**
```blade
<!-- SEBELUM -->
<td class="date_at" style="vertical-align: top; font-size: 9pt; font-weight: 700;"></td>

<!-- SELEPAS -->
<td class="date_at receipt-header-report"></td>
```

### Bug Fix
Betulkan font size di sales-receipt dari **11pt** (salah) kepada **8pt** (betul).

### Kelebihan
- ✅ Kod HTML lebih ringkas
- ✅ Konsisten dengan summary-table yang juga guna class
- ✅ Mudah maintain dan update style
- ✅ Betulkan font size yang salah (11pt → 8pt)

---

## Update 6: Tambah Paparan Peratus untuk Tax dan Discount (30 Mac 2026)

### Penambahbaikan
Tambah paparan peratus (%) untuk Tax dan Discount dalam resit.

### Perubahan

#### 1. HTML (summary-table.blade.php)

Tambah `<span>` untuk peratus:
```blade
<td class="receipt-summary-label">Tax <span class="tax-percent receipt-percent"></span></td>
<td class="receipt-summary-label">Discount <span class="discount-percent receipt-percent"></span></td>
```

Tambah class CSS baru:
```css
.receipt-percent {
    font-size: 8pt;
    opacity: 0.8;
}
```

#### 2. JavaScript (salexpen.blade.php)

**Fungsi `receiptPaid()` - Sales Receipt:**
```javascript
// Tax percent
if (data.rest) {
    el.querySelector('.tax').innerHTML = currency(data.rest)
    let taxPercent = tax > 0 ? `(${tax}%)` : ''
    el.querySelector('.tax-percent').innerHTML = taxPercent
}

// Discount percent
if (data.discamt && data.discamt > 0) {
    el.querySelector('.discount').innerHTML = '-' + currency(data.discamt)
    let discountPercent = data.discpercent ? `(${data.discpercent}%)` : ''
    el.querySelector('.discount-percent').innerHTML = discountPercent
}
```

**Fungsi `reportPreview()` - Report Receipt:**
```javascript
// Tax percent
let taxPercent = tax > 0 ? `(${tax}%)` : ''
reportEl.querySelector('.tax-percent').innerHTML = taxPercent

// Discount percent
let discountPercent = man.discpercent ? `(${man.discpercent}%)` : ''
reportEl.querySelector('.discount-percent').innerHTML = discountPercent
```

### Paparan Resit

**Sebelum:**
```
Tax                 6.00
Discount           10.00
```

**Selepas:**
```
Tax (6%)            6.00
Discount (10%)     10.00
```

### Nota
- Peratus akan muncul dalam kurungan selepas label
- Font size peratus lebih kecil (8pt) dari label (9pt)
- Opacity 0.8 untuk buat peratus kelihatan lebih subtle
- Jika tiada peratus, span akan kosong (tidak papar apa-apa)

### Data Required
- Tax: Guna variable `tax` yang sudah ada (dari `$comp->sst`)
- Discount: Perlu field `discpercent` dalam data billing
