# FamilyOffice Investment & Portfolio Management (PHP 8.3 + MySQL)

## Persyaratan
- PHP 8.3 (ekstensi: pdo_mysql, openssl, mbstring, json, gd)
- MySQL 8.x
- cPanel hosting (optional lokal: Apache/Nginx)

## Instalasi (Lokal)
1. Clone atau upload source.
2. Salin file `.env.example` menjadi `.env` dan sesuaikan kredensial DB.
3. Buat database MySQL dan import `database/schema.sql` (opsional `database/seed.sql`).
4. Jalankan `composer install` untuk mengunduh dependensi.
5. Jalankan server bawaan PHP untuk test lokal:
```bash
php -S localhost:8080 -t public
```
6. Akses `http://localhost:8080/`.

## Instalasi (cPanel)
1. Buat subdomain atau gunakan domain utama.
2. Set document root ke folder `public/`.
3. Upload semua file ke server, jalankan "Composer" di cPanel atau upload vendor.
4. Buat database dan user di MySQL, lalu import `database/schema.sql` via phpMyAdmin.
5. Buat file `.env` di root berisi kredensial DB dan konfigurasi aplikasi.

## Cron Backup (opsional)
Tambahkan Cron Job di cPanel (harian):
```
DB_HOST=localhost DB_USER=username DB_PASS=secret DB_NAME=leohome1_invest bash /home/xxx/familyoffice-php/scripts/backup.sh > /home/xxx/backups/fo_backup.log 2>&1
```

## Konfigurasi `.env`

```
APP_ENV=production
APP_URL=https://yourdomain.com
APP_NAME=FamilyOffice
APP_DEBUG=false

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=leohome1_invest
DB_USERNAME=dbuser
DB_PASSWORD=dbpass

SESSION_NAME=FOSESSID
ENCRYPTION_KEY=base64:your_32bytes_base64_key
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET=
SMTP_HOST=
SMTP_PORT=587
SMTP_USER=
SMTP_PASS=
```

## Modul (Roadmap Implementasi)
- User & Role Management, KYC
- Saham (BEI): buy/sell, P/L, posisi
- Dividen: cash/stock, alokasi porsi kepemilikan
- Modal keluarga: setoran/penarikan
- Multi-asset: properti, obligasi, reksadana, bisnis
- Akuntansi: L/R, Neraca, Arus kas
- Pajak: perhitungan & ekspor PDF/Excel
- Dashboard: Bootstrap 5 + Chart.js

## Keamanan
- Password hashing (argon2/bcrypt)
- Enkripsi data sensitif (AES-256)
- 2FA (opsional via email OTP)
- Log aktivitas user
- Backup database

## Catatan
- File `public/.htaccess` sudah mengarahkan ke `public/index.php` sebagai front controller.
- Tambahkan implementasi controller dan view lanjutan sesuai kebutuhan modul.
```