# Panduan Ujian Perubahan Pengiraan Total

## Tarikh: 30 Mac 2026

---

## 1. Ujian Daily Report

### Langkah:
1. Buka halaman Sales & Expenses
2. Klik tab "日常的" (Daily)
3. Pilih tarikh yang ada data jualan
4. Semak footer bahagian bawah:
   - ✓ Subtotal: [nilai RM]
   - ✓ Tax Amount: [nilai RM]
   - ✓ Grand Total: [nilai RM]

### Apa Yang Perlu Disemak:
- [ ] Subtotal + Tax Amount = Grand Total (kira manual untuk pastikan)
- [ ] Nilai tidak ada NaN atau undefined
- [ ] Format nombor betul (ada koma ribu, 2 perpuluhan)

### Ujian Print:
5. Klik butang "Print"
6. Semak resit cetakan:
   - [ ] Subtotal sama dengan yang di skrin
   - [ ] Tax Amount sama dengan yang di skrin
   - [ ] Total sama dengan Grand Total di skrin

---

## 2. Ujian Monthly Report

### Langkah:
1. Klik tab "月收入" (Monthly)
2. Pilih bulan yang ada data jualan
3. Semak footer bahagian bawah (sama seperti Daily)

### Apa Yang Perlu Disemak:
- [ ] Subtotal + Tax Amount = Grand Total
- [ ] Nilai tidak ada NaN atau undefined
- [ ] Format nombor betul

### Ujian Print:
4. Klik butang "Print"
5. Semak resit cetakan konsisten dengan skrin

---

## 3. Ujian Yearly Report

### Langkah:
1. Klik tab "年收入" (Yearly)
2. Pilih tahun yang ada data jualan
3. Semak footer bahagian bawah (sama seperti Daily)

### Apa Yang Perlu Disemak:
- [ ] Subtotal + Tax Amount = Grand Total
- [ ] Nilai tidak ada NaN atau undefined
- [ ] Format nombor betul (terutama untuk nilai besar)

### Ujian Print:
4. Klik butang "Print"
5. Semak resit cetakan konsisten dengan skrin

---

## 4. Ujian Edge Cases

### A. Tarikh Tiada Data
1. Pilih tarikh yang tiada jualan
2. Semak:
   - [ ] Tiada error JavaScript di console
   - [ ] Footer tidak papar NaN
   - [ ] Halaman tidak crash

### B. Nilai Besar (>1,000,000)
1. Pilih bulan/tahun dengan jumlah besar
2. Semak:
   - [ ] Format koma ribu betul (contoh: 1,234,567.89)
   - [ ] Tiada masalah parse
   - [ ] Cetakan sama dengan skrin

### C. Tukar Tarikh Berulang Kali
1. Tukar tarikh/bulan/tahun beberapa kali
2. Semak:
   - [ ] Data refresh dengan betul
   - [ ] Tiada data lama tertinggal
   - [ ] Footer update mengikut data baru

---

## 5. Ujian Konsistensi

### Bandingkan Dengan Database:
1. Buka database (phpMyAdmin/MySQL Workbench)
2. Query manual:
   ```sql
   -- Untuk Daily (ganti 2026-03-30 dengan tarikh ujian)
   SELECT 
       SUM(amount) as subtotal 
   FROM ledger_food 
   WHERE dtsale = '2026-03-30';
   
   SELECT 
       SUM(rest) as tax 
   FROM billing 
   WHERE DATE(paid_at) = '2026-03-30';
   ```
3. Bandingkan:
   - [ ] Subtotal di skrin = subtotal dari query
   - [ ] Tax di skrin = tax dari query
   - [ ] Grand Total = subtotal + tax

---

## 6. Ujian Browser Lain

Uji di browser berbeza untuk pastikan konsisten:
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

---

## 7. Checklist Akhir

- [ ] Semua ujian Daily lulus
- [ ] Semua ujian Monthly lulus
- [ ] Semua ujian Yearly lulus
- [ ] Semua edge cases lulus
- [ ] Konsistensi dengan database betul
- [ ] Print preview konsisten dengan skrin
- [ ] Tiada error di browser console
- [ ] Tiada warning di browser console

---

## Jika Ada Masalah

### Rollback:
1. Pergi ke folder `/backup/2026-03-30/`
2. Copy fail `.bak` kembali ke lokasi asal
3. Buang extension `.bak`

### Fail Backup:
- `ReportTrait copy.php1.bak` → `app/Http/Traits/ReportTrait.php`
- `SalesController copy.php1.bak` → `app/Http/Controllers/SalesController.php`
- `salexpen.blade copy.php1.bak` → `resources/views/counter/salexpen.blade.php`

### Debug:
1. Buka browser console (F12)
2. Semak error JavaScript
3. Semak network tab untuk response API
4. Semak nilai `man.subtotal`, `man.tax`, `man.total` di console

---

## Nota Penting

✅ Perubahan ini TIDAK menjejaskan:
- Fungsi POS (Point of Sale)
- Resit jualan individu
- Tab "销售量" (Sales list)
- Proses pembayaran
- Data dalam database

✅ Perubahan ini HANYA menjejaskan:
- Paparan footer laporan Daily/Monthly/Yearly
- Cetakan laporan Daily/Monthly/Yearly
- Pengiraan total (sekarang dari API, bukan klien)

---

## Sokongan

Jika ada masalah atau soalan:
1. Semak fail `PERUBAHAN.md` untuk dokumentasi lengkap
2. Semak fail `RINGKASAN_PERUBAHAN.txt` untuk ringkasan
3. Semak fail `KOMEN_KOD.md` untuk penjelasan kod
