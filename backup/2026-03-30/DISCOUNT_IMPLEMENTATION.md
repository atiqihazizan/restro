# Implementasi Ciri Discount - Ringkasan Perubahan

**Tarikh:** 30 Mac 2026  
**Status:** ✅ SELESAI

## Ringkasan

Ciri discount telah berjaya diimplementasikan pada sistem POS. Discount dimasukkan secara manual oleh cashier melalui numpad (seperti tax), disimpan dalam database, dan dipaparkan dalam resit serta laporan.

## Formula Pengiraan

```
Subtotal = sum(items)
Tax Amount = Subtotal * (tax% / 100)
Net = Subtotal + Tax Amount
Discount Amount = Net * (discount% / 100)
Grand Total = Net - Discount Amount
```

**Contoh:** Subtotal RM100, Tax 6%, Discount 10%
- Subtotal: 100.00
- Tax: 6.00
- Net: 106.00
- Discount: 10.60 (10% dari 106)
- Grand Total: 95.40

## Perubahan Database

### 1. Migration File
**File:** `database/migrations/2026_03_30_122508_add_discount_fields_to_billings_ledger_managers_restros_tables.php`

**Table `billings`:**
- `discount` TINYINT default 0 - peratusan discount (0-100)
- `discamt` DECIMAL(10,2) default 0 - nilai RM discount

**Table `ledger_managers`:**
- `discount` DECIMAL(12,2) default 0 - jumlah RM discount untuk tempoh laporan

**Table `restros`:**
- `discount` TINYINT default 0 - default discount % (optional preset)

## Perubahan Backend

### 1. CounterController.php
**Method `paid()`** - Baris 45-66
- Terima data `disc` dan `discnum` dari frontend
- Simpan ke `bill->discount` dan `bill->discamt`
- Simpan `grandtotal` (bukan `net` lagi)

### 2. ReportTrait.php
**Ketiga-tiga method:** `reportMan()`, `reportManMonth()`, `reportManYear()`
- Tambah pengiraan: `$discount = $bill->sum('discamt')`
- Formula total: `$total = $lfamt + $tax - $discount`
- Simpan discount dalam LedgerManager

## Perubahan Frontend

### 1. pos.blade.php - Payment Numpad

**HTML (Baris 83-111):**
Tambah baris baru dalam modal payment:
```
Tax        0.00    (clickable, input %)
Total      0.00    (auto: subtotal + tax = net)
Discount   0.00    (clickable, input %)  ← BARU
Grand      0.00    (auto: net - discount)
Paid       0.00
Balance    0.00
```

**JavaScript `initPayment()` (Baris 226-350):**
- Tambah handling untuk field `[data-disc]`
- Kira discount dari net: `bill.disc = (bill.net * discnum) / 100`
- Kira grand total: `bill.grand = bill.net - bill.disc`
- Balance dikira dari grand total: `bill.bal = bill.grand - bill.amt`
- POST data tambah: `disc` dan `discnum`

**Event Listeners (Baris 430-441):**
- Tambah click handler untuk field discount (sama pattern seperti tax)

### 2. salexpen.blade.php - Receipt & Reports

**Receipt HTML (Baris 134-160):**
Tambah baris discount dalam receipt:
```
Subtotal   100.00
Tax          6.00
Total      106.00    (net)
Discount   -10.60    ← BARU
Grand Total 95.40
Paid       100.00
Change       4.60
```

**Report Receipt HTML (Baris 172-192):**
Tambah baris discount dalam report print

**JavaScript `receiptPaid()` (Baris 250-290):**
- Kira net total: `netTotal = subtotal + tax`
- Papar discount jika > 0 (dengan tanda minus)
- Sembunyikan baris discount jika 0

**JavaScript `salesReportSummaryFooterHtml()` (Baris 222-252):**
- Tambah baris "Total" (net = subtotal + tax)
- Tambah baris "Discount" (jika > 0)
- "Grand Total" adalah nilai akhir

**JavaScript `reportPreview()` (Baris 410-426):**
- Handle discount pada report print
- Sembunyikan baris discount jika 0

## Cara Penggunaan

### Untuk Cashier:

1. **Take Order** seperti biasa
2. Klik butang **Pay**
3. Modal payment akan muncul dengan numpad
4. Klik field **Tax**, masukkan peratusan tax (cth: 6)
5. Klik field **Discount**, masukkan peratusan discount (cth: 10)
6. Sistem auto-kira Grand Total
7. Klik field **Paid**, masukkan jumlah bayaran
8. Klik **Enter** untuk selesai

### Untuk Admin (Optional):

Boleh set default discount % dalam table `restros`:
```sql
UPDATE restros SET discount = 5 WHERE id = 1;
```
Ini akan menjadi nilai awal, tapi cashier masih boleh override.

## Testing Checklist

- [x] Migration berjaya (discount fields wujud dalam DB)
- [ ] Payment dengan discount 0% (tiada discount)
- [ ] Payment dengan discount 10% (ada discount)
- [ ] Receipt print menunjukkan discount dengan betul
- [ ] Report daily menunjukkan total discount
- [ ] Report monthly menunjukkan total discount
- [ ] Report yearly menunjukkan total discount
- [ ] Reprint resit lama (sebelum discount) masih berfungsi
- [ ] Balance calculation betul (grand - paid)

## Fail Yang Diubah

1. ✅ `database/migrations/2026_03_30_122508_add_discount_fields_to_billings_ledger_managers_restros_tables.php` (BARU)
2. ✅ `app/Http/Controllers/CounterController.php`
3. ✅ `app/Http/Traits/ReportTrait.php`
4. ✅ `resources/views/counter/pos.blade.php`
5. ✅ `resources/views/counter/salexpen.blade.php`

## Nota Penting

- Discount dikira dari **Net** (subtotal + tax), bukan dari subtotal sahaja
- Discount disimpan sebagai % dan RM untuk audit trail
- Jika discount = 0, baris discount akan disembunyikan dalam receipt
- Report akan tunjuk jumlah keseluruhan discount untuk tempoh tersebut
- Backward compatible - resit lama tanpa discount masih boleh di-reprint

## Sokongan

Jika ada masalah, semak:
1. Database - pastikan migration berjaya
2. Browser console - check for JavaScript errors
3. Network tab - check API response ada field `disc`, `discnum`, `grand`
