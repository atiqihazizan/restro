# Dokumentasi Perubahan - 30 Mac 2026

## Ringkasan
Pembaikan pengiraan total dalam laporan jualan (Daily/Monthly/Yearly) supaya konsisten antara paparan skrin dan cetakan.

## Masalah Asal
1. **Parse koma tidak sempurna** - `replace(',', '')` hanya buang koma pertama, menyebabkan nilai besar (contoh: 1,234,567.89) jadi salah
2. **Pembundaran per kategori** - Total dikira dari jumlah yang sudah dibundar mengikut kategori, berbeza dengan subtotal sebenar dari server
3. **Dua sumber pengiraan** - Footer skrin kira sendiri, API pun kira sendiri, menyebabkan ketidakselarasan

## Penyelesaian
**Prinsip:** Kira sekali di API, hantar data siap, klien papar sahaja.

---

## Fail Yang Diubah

### 1. `/app/Http/Traits/ReportTrait.php`
**Perubahan:** Buang komen lama sahaja
- Tiada perubahan logik
- Struktur `man->subtotal`, `man->tax`, `man->total` sudah betul

### 2. `/app/Http/Controllers/SalesController.php`
**Perubahan:** Buang komen lama sahaja
- Fungsi `sales()` - buang komen validation
- Fungsi `daily()` - buang komen kaedah lama map
- Tiada perubahan logik

### 3. `/resources/views/counter/salexpen.blade.php`
**Perubahan Utama:**

#### A. Buang komen HTML/JavaScript lama
- Buang komen search input
- Buang komen payment column
- Buang komen action buttons

#### B. `initDaily()` (baris ~355-390)
**SEBELUM:**
```javascript
let total = 0;
tbody.innerHTML = det.map((s, n) => {
    total += s.amount.replace(',', '') * 1  // ← Kira sendiri, boleh salah
    return `<tr>...</tr>`
}).join('')
const grand = ledgerGrand(man, total, man.tax)  // ← Guna total yang dikira klien
footer.innerHTML = `
    <tr><th>Total</th><th>RM ${currency(total)}</th></tr>  // ← Dari klien
    <tr><th>Grand Total</th><th>RM ${currency(grand)}</th></tr>
`
```

**SELEPAS:**
```javascript
// Buang pembolehubah total, tidak kira sendiri
tbody.innerHTML = det.map((s, n) => {
    // Hanya papar, tidak tambah
    return `<tr>...</tr>`
}).join('')
// Footer guna terus nilai dari API (man)
footer.innerHTML = `
    <tr><th>Subtotal</th><th>RM ${currency(ledgerNum(man.subtotal))}</th></tr>  // ← Dari API
    <tr><th>Tax Amount</th><th>RM ${currency(ledgerNum(man.tax))}</th></tr>     // ← Dari API
    <tr><th>Grand Total</th><th>RM ${currency(ledgerNum(man.total))}</th></tr>  // ← Dari API
`
```

#### C. `initMonthly()` (baris ~400-440)
**Perubahan sama seperti initDaily:**
- Buang `let total = 0`
- Buang `total += s.amount.replace(',', '') * 1`
- Buang `const grandM = ledgerGrand(man, total, man.tax)`
- Footer guna `man.subtotal`, `man.tax`, `man.total` terus

#### D. `initYearly()` (baris ~441-481)
**Perubahan sama seperti initDaily:**
- Buang `let total = 0`
- Buang `total += s.amount.replace(',', '') * 1`
- Buang `const grandY = ledgerGrand(man, total, man.tax)`
- Footer guna `man.subtotal`, `man.tax`, `man.total` terus

#### E. `reportPreview()` (baris ~483-508)
**SEBELUM:**
```javascript
let subt = 0;
let tota = 0;
reportEl.querySelector('.receipt-sale-item tbody').innerHTML = item.map((r, n) => {
    subt += r.amount.replace(',', '') * 1  // ← Kira sendiri
    return `<tr>...</tr>`
}).join('')
tota = ledgerGrand(man, subt, man.tax)  // ← Guna subt yang dikira klien
reportEl.querySelector('.total').innerHTML = currency(tota);
```

**SELEPAS:**
```javascript
// Buang pembolehubah subt dan tota
reportEl.querySelector('.receipt-sale-item tbody').innerHTML = item.map((r, n) => {
    // Hanya papar, tidak tambah
    return `<tr>...</tr>`
}).join('')
// Guna terus nilai dari API
reportEl.querySelector('.subtotal').innerHTML = currency(ledgerNum(man.subtotal))  // ← Dari API
reportEl.querySelector('.tax').innerHTML = currency(ledgerNum(man.tax))            // ← Dari API
reportEl.querySelector('.total').innerHTML = currency(ledgerNum(man.total));       // ← Dari API
```

#### F. `initPrintPreview()` (baris ~510-530)
**Perubahan:** Buang komen sahaja
- Buang komen `// let html = pageSale.querySelector('#sales_monthly_data').innerHTML`

---

## Fungsi Yang Kekal (Tidak Diubah)

### `ledgerNum(v)` - Kekal
Fungsi helper untuk parse nilai dengan betul (buang semua koma dengan `/,/g`)

### `ledgerGrand(man, sumDet, taxVal)` - Kekal
Fungsi fallback untuk kira grand total. Sekarang tidak digunakan lagi dalam `initDaily/Monthly/Yearly` dan `reportPreview`, tetapi dikekalkan untuk keserasian kod lain.

### `receiptPaid(data)` - Tidak disentuh
Fungsi untuk papar resit jualan individu. Tidak berkaitan dengan laporan harian/bulanan/tahunan.

### `initSales()` - Tidak disentuh
Fungsi untuk senarai jualan harian. Tidak berkaitan dengan pengiraan total.

---

## Kesan Perubahan

### ✅ Kelebihan
1. **Konsisten** - Subtotal, Tax, Grand Total sama antara skrin dan cetakan
2. **Tepat** - Tiada masalah parse koma atau pembundaran per kategori
3. **Mudah maintain** - Satu sumber kebenaran (API), klien hanya papar
4. **Elak bug** - Tiada pengiraan bercabang di klien

### ⚠️ Perkara Perlu Diuji
1. Paparan Daily report - semak Subtotal, Tax, Grand Total
2. Paparan Monthly report - semak Subtotal, Tax, Grand Total
3. Paparan Yearly report - semak Subtotal, Tax, Grand Total
4. Print preview untuk ketiga-tiga laporan - pastikan nilai sama dengan skrin
5. Nilai besar (lebih 1,000,000) - pastikan format betul
6. Tarikh tiada data - pastikan tidak error

---

## Backup Fail
Semua fail asal disimpan di `/backup/2026-03-30/`:
- `ReportTrait copy.php1.bak`
- `SalesController copy.php1.bak`
- `salexpen.blade copy.php1.bak`

---

## Nota Tambahan

### Label "Total" vs "Subtotal"
- **Sebelum:** Baris pertama footer dilabel "Total" (hasil tambah kategori)
- **Selepas:** Baris pertama footer dilabel "Subtotal" (dari API, sebelum cukai)
- Ini lebih tepat dari segi perakaunan: Subtotal + Tax = Grand Total

### Fungsi `ledgerGrand` Masih Wujud
Fungsi ini tidak dibuang kerana mungkin digunakan di tempat lain atau untuk fallback. Tetapi dalam laporan harian/bulanan/tahunan, ia tidak dipanggil lagi.

### Format Nombor
Semua nilai dari API diproses dengan `ledgerNum()` sebelum `currency()` untuk pastikan parse betul walaupun ada koma atau format lain.
