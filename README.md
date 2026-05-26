# Rumah Bekam Salam Insani

Sistem manajemen klinik bekam berbasis web menggunakan Laravel 11 dengan fitur booking, manajemen terapis, dan pembayaran.

## 🚀 Tech Stack

- **Framework**: Laravel 11.x
- **PHP**: 8.2.12
- **Database**: MySQL
- **Frontend**: Blade Templates + Bootstrap 5
- **Authentication**: Laravel Breeze (Session-based)
- **Server**: Laragon / XAMPP (Windows 10/11)

## 📋 Fitur Utama

### Role Customer
- ✅ Registrasi dan Login
- ✅ Lihat daftar layanan bekam
- ✅ Booking layanan
- ✅ Upload bukti pembayaran
- ✅ Cancel booking
- ✅ Riwayat booking
- ✅ Rating & komentar terapis
- ✅ Edit profil

### Role Admin
- ✅ Dashboard statistik
- ✅ CRUD User
- ✅ CRUD Terapis
- ✅ CRUD Service
- ✅ CRUD Location
- ✅ Kelola booking
- ✅ Konfirmasi pembayaran
- ✅ Lihat komentar customer

### Role Terapis
- ✅ Dashboard terapis
- ✅ Lihat booking masuk
- ✅ Konfirmasi booking
- ✅ Update status service
- ✅ Lihat jadwal
- ✅ Lihat rating & komentar

## 🗄️ Database Schema

### Tabel Users
- id, username, email, password, no_telepon, alamat, role_users (customer/admin/terapis)

### Tabel Terapis
- id, username, email, password, no_telepon, alamat, rating

### Tabel Location
- id, name_location

### Tabel Service
- id, name_service, date_service, time_service, price, id_terapis, id_location

### Tabel Booking
- id, id_customer, id_terapis, id_service, date_booking, time_booking, status_payment, status_service, payment_proof

### Tabel Comment
- id, id_customer, id_terapis, rating, comment

## 🛠️ Instalasi

### 1. Clone / Download Project
```bash
# Project sudah ada di: c:\Users\Fdil\Documents\web_terapis\rumah-bekam
```

### 2. Install Dependencies
```bash
cd c:\Users\Fdil\Documents\web_terapis\rumah-bekam
composer install
npm install
npm run build
```

### 3. Konfigurasi Database
Buat database MySQL dengan nama `rumah_bekam`, kemudian file `.env` sudah dikonfigurasi:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rumah_bekam
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migration & Seeder
```bash
php artisan migrate:fresh --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👤 Akun Default

### Admin
- Email: `admin@bekam.com`
- Password: `password`

### Terapis
- Email: `ahmad@bekam.com` / `budi@bekam.com` / `citra@bekam.com`
- Password: `password`

### Customer
- Email: `andi@customer.com` / `siti@customer.com`
- Password: `password`

## 📁 Struktur Folder

```
rumah-bekam/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Admin/
│   │   │   ├── Customer/
│   │   │   └── Terapis/
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── CustomerMiddleware.php
│   │   │   └── TerapisMiddleware.php
│   │   └── Requests/
│   └── Models/
│       ├── User.php
│       ├── Terapis.php
│       ├── Location.php
│       ├── Service.php
│       ├── Booking.php
│       └── Comment.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       ├── admin/
│       ├── customer/
│       └── terapis/
└── routes/
    └── web.php
```

## 🔐 Middleware

- `admin`: Hanya untuk role admin
- `customer`: Hanya untuk role customer
- `terapis`: Hanya untuk role terapis

## 🎨 UI Design

- Bootstrap 5
- Responsive mobile-first
- Modern gradient design
- Bootstrap Icons
- Clean dashboard layout

## 📝 Routing

```php
// Public
GET / → Landing page

// Auth
GET /login → Login page
POST /login → Process login
GET /register → Register page
POST /register → Process register
POST /logout → Logout

// Admin (middleware: auth, admin)
/admin/dashboard
/admin/users
/admin/terapis
/admin/services
/admin/locations
/admin/bookings
/admin/comments

// Customer (middleware: auth, customer)
/customer/dashboard
/customer/services
/customer/bookings
/customer/profile

// Terapis (middleware: auth, terapis)
/terapis/dashboard
/terapis/bookings
/terapis/schedule
/terapis/ratings
/terapis/profile
```

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test

# Test specific file
php artisan test --filter=UserTest
```

## 📦 Dependencies

### Composer
- laravel/framework: ^11.0
- laravel/breeze: ^2.4

### NPM
- bootstrap: ^5.3.0
- bootstrap-icons: ^1.11.0

## 🔧 Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database
**Solusi**: Buat database `rumah_bekam` di MySQL terlebih dahulu

### Error: Class 'App\Http\Middleware\AdminMiddleware' not found
**Solusi**: Jalankan `composer dump-autoload`

### Error: npm run build gagal
**Solusi**: Hapus folder `node_modules` dan `package-lock.json`, lalu jalankan `npm install` lagi

### Error: Session tidak berfungsi
**Solusi**: Pastikan `SESSION_DRIVER=database` di `.env` dan jalankan migration

## 📄 License

Project ini dibuat untuk keperluan pembelajaran dan pengembangan sistem manajemen klinik bekam.

## 👨‍💻 Developer

Dikembangkan menggunakan Laravel 11 dengan arsitektur MVC, RESTful API, dan best practices.

## 📞 Support

Untuk pertanyaan dan dukungan, silakan hubungi tim development.

---

**Version**: 1.0.0  
**Last Updated**: 2025  
**PHP**: 8.2.12  
**Laravel**: 11.x
