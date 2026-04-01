# Komen Kod Untuk Perubahan

## Lokasi Perubahan Utama

### 1. initDaily() - Baris 345-383

```javascript
// PERUBAHAN 30/03/2026: Buang pengiraan total di klien
// Sebelum: let total = 0; loop tambah s.amount.replace(',', '') * 1
// Selepas: Guna terus man.subtotal, man.tax, man.total dari API
// Sebab: Elak masalah parse koma & pembundaran per kategori

async function initDaily() {
    // ... kod asal kekal ...
    
    // TIDAK LAGI: let total = 0
    tbody.innerHTML = det.map((s, n) => {
        // TIDAK LAGI: total += s.amount.replace(',', '') * 1
        return `<tr>...</tr>`
    }).join('')
    
    // PERUBAHAN: Footer guna nilai siap dari API
    footer.innerHTML = `
        <tr><th>Subtotal</th><th>RM ${currency(ledgerNum(man.subtotal))}</th></tr>
        <tr><th>Tax Amount</th><th>RM ${currency(ledgerNum(man.tax))}</th></tr>
        <tr><th>Grand Total</th><th>RM ${currency(ledgerNum(man.total))}</th></tr>
    `
}
```

### 2. initMonthly() - Baris 384-421

```javascript
// PERUBAHAN 30/03/2026: Sama seperti initDaily()
// Buang pengiraan total di klien, guna nilai dari API

async function initMonthly() {
    // ... struktur sama dengan initDaily ...
    // Footer guna man.subtotal, man.tax, man.total
}
```

### 3. initYearly() - Baris 422-459

```javascript
// PERUBAHAN 30/03/2026: Sama seperti initDaily()
// Buang pengiraan total di klien, guna nilai dari API

async function initYearly() {
    // ... struktur sama dengan initDaily ...
    // Footer guna man.subtotal, man.tax, man.total
}
```

### 4. reportPreview() - Baris 461-482

```javascript
// PERUBAHAN 30/03/2026: Buang pengiraan subt di klien
// Sebelum: let subt = 0; loop tambah r.amount.replace(',', '') * 1
// Selepas: Guna terus man.subtotal, man.tax, man.total dari API
// Sebab: Pastikan cetakan konsisten dengan paparan skrin

function reportPreview() {
    // ... kod asal kekal ...
    
    // TIDAK LAGI: let subt = 0
    reportEl.querySelector('.receipt-sale-item tbody').innerHTML = item.map((r, n) => {
        // TIDAK LAGI: subt += r.amount.replace(',', '') * 1
        return `<tr>...</tr>`
    }).join('')
    
    // PERUBAHAN: Guna nilai siap dari API
    reportEl.querySelector('.subtotal').innerHTML = currency(ledgerNum(man.subtotal))
    reportEl.querySelector('.tax').innerHTML = currency(ledgerNum(man.tax))
    reportEl.querySelector('.total').innerHTML = currency(ledgerNum(man.total))
}
```

## Nota Penting

1. **Fungsi ledgerNum()** - Kekal digunakan untuk parse nilai dengan betul
2. **Fungsi ledgerGrand()** - Masih wujud tetapi tidak dipanggil lagi dalam laporan
3. **Label "Subtotal"** - Lebih tepat dari segi perakaunan berbanding "Total"
4. **Konsistensi** - Semua nilai (skrin & cetak) dari sumber yang sama: API

## Kenapa Perubahan Ini Penting

- ✅ Elak bug parse koma (replace tunggal vs global)
- ✅ Elak beza pembundaran (per kategori vs keseluruhan)
- ✅ Satu sumber kebenaran (API)
- ✅ Mudah maintain dan debug
