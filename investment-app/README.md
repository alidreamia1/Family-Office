# Investment Management App (Express + Prisma + MySQL)

## Prasyarat
- Node.js 18+
- MySQL 8+ berjalan secara lokal atau via Docker

## Instalasi
1. Install dependencies:
```bash
npm install
```
2. Salin dan sesuaikan `.env`:
```bash
cp .env .env.local # lalu edit kredensial DB
```
3. Jalankan MySQL (contoh Docker):
```bash
docker run --name mysql -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=investment_app -p 3306:3306 -d mysql:8
```
4. Update `DATABASE_URL` di `.env` sesuai kredensial.
5. Generate Prisma Client dan migrasi skema:
```bash
npx prisma generate
npx prisma migrate dev --name init_schema
```
6. Seed data contoh:
```bash
npm run seed
```
7. Jalankan server dev:
```bash
npm run dev
```

## Fitur Utama
- Autentikasi JWT (admin, investor), OTP via email (placeholder)
- CRUD Investor + upload KYC (placeholder endpoints)
- Transaksi investasi (deposit/withdraw)
- Pembagian dividen per periode (placeholder endpoints)
- Laporan dan ekspor (CSV/Excel/PDF) (placeholder)
- Integrasi Google Sheets & Webhook (placeholder)
- UI responsif via EJS + Bootstrap (scaffold)

## Struktur Direktori
```
src/
  config/
  middleware/
  routes/
  public/
  views/
prisma/
  schema.prisma
  seed/
```

## Catatan
Endpoints inti masih placeholder. Implementasi lanjutan dapat dilakukan bertahap pada controller dan service masing-masing modul.