# Restro

Aplikasi pengurusan / pesanan restoran berasaskan [Laravel](https://laravel.com) 10 dan PHP 8.1+.

Repositori: [https://github.com/atiqihazizan/restro](https://github.com/atiqihazizan/restro)

---

## Sokongan platform

| Mod | Perihal |
|-----|---------|
| **Pelayar (Laravel)** | Mana-mana OS yang disokong oleh PHP 8.1+, MySQL/MariaDB, dan Node.js untuk Vite. |
| **Desktop (Electron)** | **Windows 7 ke atas** (termasuk Windows 8 / 8.1 dan Windows 10+). Binaan Windows disediakan sebagai **x64** dan **ia32** (x86). |

### Nota penting untuk desktop Windows

- Projek mempin **Electron 22.3.27** — ini ialah siri Electron **terakhir** yang masih menyokong **Windows 7 / 8 / 8.1**. Dari **Electron 23** ke atas, hanya **Windows 10+** disokong.
- **electron-builder 24.13.3** digunakan untuk membungkus aplikasi Windows.
- Sokongan rasmi untuk **Electron 22** telah tamat (EOL); gunakan pada Windows 7 hanya jika perniagaan benar-benar memerlukannya, dan pertimbangkan risiko keselamatan.
- Untuk PHP dibundel dalam `.exe`, letak binari yang sepadan dalam `runtime/php` (lihat `runtime/php/BACA_INI.txt`): **x64** untuk pakej 64-bit, **x86** untuk pakej 32-bit.

### Arahan binaan desktop (Windows)

```bash
npm install
npm run electron:build:win7    # x64 + ia32 (sesuai skop Windows 7+)
npm run electron:build:win64   # x64 sahaja
npm run electron:build:win32   # ia32 sahaja
```

Pembangunan tempatan dengan tetingkap Electron:

```bash
npm run electron
```

---

## Setup semula dari awal

Ikuti langkah ini pada komputer baharu atau selepas `git clone`.

### Prasyarat

- **PHP** 8.1.1 atau lebih tinggi (sambungan biasa: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`)
- **[Composer](https://getcomposer.org/)**
- **Node.js** dan **npm** (untuk Vite / aset frontend; dan untuk Electron jika anda bina desktop)
- **MySQL** / **MariaDB** (atau sesuaikan untuk SQLite jika anda ubah `.env`)

### 1. Dapatkan kod sumber

```bash
git clone https://github.com/atiqihazizan/restro.git
cd restro
```

Atau ekstrak zip projek ke folder pilihan anda, kemudian `cd` ke folder tersebut.

### 2. Pasang kebergantungan PHP

```bash
composer install
```

### 3. Persekitaran dan kunci aplikasi

```bash
cp .env.example .env
php artisan key:generate
```

Fail `.env` tidak disertakan dalam Git (keselamatan). Anda **mesti** salin dari `.env.example` dan lengkapkan nilai sendiri.

### 4. Pangkalan data

Sunting `.env` dan set medan pangkalan data, contoh untuk MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_pangkalan_anda
DB_USERNAME=root
DB_PASSWORD=
```

Cipta pangkalan data kosong (contohnya `CREATE DATABASE nama_pangkalan_anda;`) mengikut nama dalam `DB_DATABASE`.

Jalankan migrasi:

```bash
php artisan migrate
```

**Data contoh (pilihan):** selepas migrasi, untuk meja asas seperti meja, kategori, makanan, restro:

```bash
php artisan db:seed
```

### 5. Storage dan kebenaran (jika perlu)

Pautan simbolik untuk fail awam:

```bash
php artisan storage:link
```

Pada Linux/macOS, jika ada ralat kebenaran pada `storage/` atau `bootstrap/cache/`, laraskan pemilik/pembacaan mengikut persekitaran pelayan anda.

### 6. Aset frontend (Vite)

```bash
npm install
```

- **Pembangunan** (hot reload): `npm run dev` — jalankan bersama pelayan PHP anda.
- **Production**: `npm run build`

### 7. Jalankan aplikasi

```bash
php artisan serve
```

Buka pelayar ke alamat yang dipaparkan (biasanya `http://127.0.0.1:8000`).

---

## Ringkasan arahan (salin sekaligus selepas clone)

Selepas `DB_*` dalam `.env` diset dengan betul:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

---

## Lesen

Projek ini menggunakan rangka kerja Laravel (lesen MIT). Lihat [dokumentasi Laravel](https://laravel.com/docs) untuk butiran lanjut rangka kerja.
