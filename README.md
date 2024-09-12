# Test Case 


## Prasyarat

Sebelum memulai, pastikan Anda sudah menginstal hal-hal berikut di sistem Anda:

- PHP >= 8.1
- Composer
- MySQL 
- Git

## Langkah Instalasi

### 1. Clone Repositori

Pertama, clone repositori dari GitHub ke mesin lokal Anda dengan perintah berikut:

```bash
git clone https://github.com/malikfajr/testcase
```

### 2. Masuk ke Direktori Proyek

Pindah ke direktori proyek:

```bash
cd testcase
```

### 3. Instal Dependensi

Gunakan Composer untuk menginstal semua dependensi:

```bash
composer install
```

### 4. Salin File Environment

Salin file environment contoh dan buat file `.env` baru:

```bash
cp .env.example .env
```

### 5. Generate Application Key

Generate application key:

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Sesuaikan pengaturan database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda
```

Setelah mengonfigurasi database, jalankan migrasi dan seed database:

```bash
php artisan migrate --seed
```

### 7. Buat Storage Link
Buat symbolic link untuk folder storage:
```bash
php artisan storage:link
```

### 8. Jalankan Server Pengembangan

Sekarang, jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Aplikasi sekarang seharusnya berjalan di `http://localhost:8000`.
