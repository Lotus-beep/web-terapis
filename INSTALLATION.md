# Panduan Instalasi Lengkap - Rumah Bekam Salam Insani

Panduan instalasi step-by-step untuk sistem Rumah Bekam Salam Insani di Windows 10/11 menggunakan Laragon atau XAMPP.

## 📋 Persyaratan Sistem

### Software yang Dibutuhkan
- ✅ PHP 8.2.12 atau lebih tinggi
- ✅ Composer (latest version)
- ✅ Node.js & NPM (v18 atau lebih tinggi)
- ✅ MySQL 8.0 atau MariaDB 10.x
- ✅ Laragon atau XAMPP
- ✅ Git (opsional)

### Ekstensi PHP yang Diperlukan
- ✅ OpenSSL
- ✅ PDO
- ✅ Mbstring
- ✅ Tokenizer
- ✅ XML
- ✅ Ctype
- ✅ JSON
- ✅ BCMath
- ✅ Fileinfo

## 🚀 Instalasi dengan Laragon

### Step 1: Install Laragon
1. Download Laragon dari https://laragon.org/download/
2. Install Laragon Full (sudah include PHP, MySQL, Node.js)
3. Jalankan Laragon

### Step 2: Verifikasi PHP & Composer
```bash
# Buka Laragon Terminal (klik kanan icon Laragon → Terminal)
php -v
# Output: PHP 8.2.12 (atau lebih tinggi)

composer -V
# Output: Composer version 2.x.x
```

### Step 3: Setup Project
```bash
# Navigasi ke folder project
cd c:\Users\Fdil\Documents\web_terapis\rumah-bekam

# Install dependencies PHP
composer install

# Install dependencies JavaScript
npm install

# Build assets
npm run build
```

### Step 4: Konfigurasi Database
1. Buka Laragon → klik "Database" → buka HeidiSQL/phpMyAdmin
2. Buat database baru dengan nama `rumah_bekam`
3. File `.env` sudah dikonfigurasi dengan benar:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rumah_bekam
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Generate Application Key
```bash
php artisan key:generate
```

### Step 6: Jalankan Migration & Seeder
```bash
# Jalankan migration dan seeder sekaligus
php artisan migrate:fresh --seed
```

Output yang diharapkan:
```
Migration table created successfully.
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table
Migrating: 2024_01_01_000001_create_terapis_table
Migrated:  2024_01_01_000001_create_terapis_table
...
Seeding: Database\Seeders\AdminSeeder
Seeded:  Database\Seeders\AdminSeeder
...
```

### Step 7: Jalankan Server
```bash
php artisan serve
```

Atau gunakan Laragon virtual host:
1. Klik kanan icon Laragon → Apache → httpd.conf
2. Tambahkan virtual host untuk project
3. Akses via `http://rumah-bekam.test`

### Step 8: Akses Aplikasi
Buka browser dan akses:
- `http://localhost:8000` (jika menggunakan artisan serve)
- `http://rumah-bekam.test` (jika menggunakan Laragon virtual host)

## 🔧 Instalasi dengan XAMPP

### Step 1: Install XAMPP
1. Download XAMPP dari https://www.apachefriends.org/
2. Install XAMPP dengan PHP 8.2.x
3. Jalankan Apache dan MySQL dari XAMPP Control Panel

### Step 2: Install Composer
1. Download Composer dari https://getcomposer.org/download/
2. Install Composer (pilih PHP dari XAMPP: `C:\xampp\php\php.exe`)
3. Restart terminal/command prompt

### Step 3: Install Node.js & NPM
1. Download Node.js dari https://nodejs.org/
2. Install Node.js (pilih LTS version)
3. Verifikasi instalasi:
```bash
node -v
npm -v
```

### Step 4: Setup Project
```bash
# Buka Command Prompt atau PowerShell
cd c:\Users\Fdil\Documents\web_terapis\rumah-bekam

# Install dependencies
composer install
npm install
npm run build
```

### Step 5: Konfigurasi Database
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Buat database baru: `rumah_bekam`
3. Pastikan `.env` sudah benar:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rumah_bekam
DB_USERNAME=root
DB_PASSWORD=
```

### Step 6: Generate Key & Migration
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

### Step 7: Jalankan Server
```bash
php artisan serve
```

Akses: `http://localhost:8000`

## 🔐 Akun Default untuk Testing

### Admin
```
Email: admin@bekam.com
Password: password
URL: http://localhost:8000/login
```

### Terapis
```
Email: ahmad@bekam.com
Password: password

Email: budi@bekam.com
Password: password

Email: citra@bekam.com
Password: password
```

### Customer
```
Email: andi@customer.com
Password: password

Email: siti@customer.com
Password: password
```

## ✅ Verifikasi Instalasi

### 1. Cek Database
```bash
php artisan migrate:status
```

Output harus menunjukkan semua migration sudah "Ran".

### 2. Cek Seeder
Login sebagai admin dan verifikasi:
- Ada 1 admin
- Ada 3 terapis
- Ada 3 lokasi
- Ada 5 service
- Ada 2 customer

### 3. Test Login
1. Akses `http://localhost:8000/login`
2. Login dengan akun admin: `admin@bekam.com` / `password`
3. Harus redirect ke `/admin/dashboard`

### 4. Test Middleware
1. Logout dari admin
2. Login sebagai customer: `andi@customer.com` / `password`
3. Harus redirect ke `/customer/dashboard`
4. Coba akses `/admin/dashboard` → harus error 403

## 🐛 Troubleshooting

### Error: "Class 'PDO' not found"
**Penyebab**: Ekstensi PDO tidak aktif  
**Solusi**:
1. Buka `php.ini` (di Laragon: `C:\laragon\bin\php\php-8.2.12\php.ini`)
2. Uncomment baris: `extension=pdo_mysql`
3. Restart Apache/Laragon

### Error: "SQLSTATE[HY000] [2002] No connection could be made"
**Penyebab**: MySQL tidak berjalan  
**Solusi**:
1. Buka Laragon/XAMPP Control Panel
2. Start MySQL service
3. Jalankan ulang `php artisan migrate`

### Error: "npm ERR! code ENOENT"
**Penyebab**: Node.js/NPM belum terinstall  
**Solusi**:
1. Install Node.js dari https://nodejs.org/
2. Restart terminal
3. Jalankan `npm install` lagi

### Error: "Vite manifest not found"
**Penyebab**: Assets belum di-build  
**Solusi**:
```bash
npm run build
```

### Error: "419 Page Expired" saat submit form
**Penyebab**: CSRF token expired atau session tidak berfungsi  
**Solusi**:
1. Pastikan `SESSION_DRIVER=database` di `.env`
2. Jalankan `php artisan migrate` (untuk tabel sessions)
3. Clear cache: `php artisan cache:clear`
4. Refresh halaman dan coba lagi

### Error: "Class 'App\Http\Middleware\AdminMiddleware' not found"
**Penyebab**: Autoload belum di-refresh  
**Solusi**:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Error: "Access denied for user 'root'@'localhost'"
**Penyebab**: Password MySQL salah  
**Solusi**:
1. Cek password MySQL di XAMPP/Laragon
2. Update `DB_PASSWORD` di `.env`
3. Jalankan ulang migration

## 🔄 Update & Maintenance

### Update Dependencies
```bash
# Update Composer packages
composer update

# Update NPM packages
npm update

# Rebuild assets
npm run build
```

### Reset Database
```bash
# Reset database dan jalankan ulang seeder
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📊 Performance Optimization

### Production Mode
```bash
# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets untuk production
npm run build
```

### Database Optimization
```bash
# Optimize database
php artisan db:seed --class=DatabaseSeeder
php artisan optimize
```

## 🎯 Next Steps

Setelah instalasi berhasil:
1. ✅ Test semua fitur login (admin, customer, terapis)
2. ✅ Test CRUD operations di admin panel
3. ✅ Test booking flow dari customer
4. ✅ Test konfirmasi booking dari terapis
5. ✅ Customize UI sesuai kebutuhan
6. ✅ Deploy ke production server

## 📞 Support

Jika mengalami masalah saat instalasi:
1. Cek log error di `storage/logs/laravel.log`
2. Pastikan semua requirement terpenuhi
3. Ikuti troubleshooting guide di atas
4. Hubungi tim development

---

**Happy Coding! 🚀**
