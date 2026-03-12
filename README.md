# Sekolah API - Sistem Informasi Sekolah

API untuk sistem informasi sekolah yang dibangun dengan Laravel menggunakan format Collection+JSON.

## Deskripsi Sistem

Sistem ini dirancang untuk mengelola data sekolah meliputi:
- **Users** - Akun login untuk admin dan guru
- **Guru** - Data pengajar
- **Siswa** - Data peserta didik
- **Kelas** - Data kelas sekolah
- **Mapel** - Mata pelajaran
- **Jadwal** - Jadwal pelajaran harian

## Struktur Database

### 1. Tabel `users`
Menyimpan akun pengguna sistem dengan tipe admin atau guru.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| type | enum('admin','guru') | Jenis user |
| username | varchar(255) | Username login |
| password | varchar(255) | Password (hashed) |
| remember_token | varchar(100) | Token login |
| created_at, updated_at | timestamp | Timestamp |

### 2. Tabel `guru`
Menyimpan data guru yang memiliki relasi ke user.

**Relasi**: `guru.user_id → users.id`

### 3. Tabel `siswa`
Menyimpan data siswa yang berada di kelas tertentu.

**Relasi**: `siswa.kelas_id → kelas.id`

### 4. Tabel `kelas`
Menyimpan data kelas (contoh: X-IPA-1, XI-IPS-2).

**Relasi**: Memiliki banyak siswa dan jadwal.

### 5. Tabel `mapel`
Menyimpan mata pelajaran (contoh: Matematika, Fisika, Biologi).

**Relasi**: Digunakan dalam jadwal.

### 6. Tabel `jadwal`
Tabel inti yang menghubungkan kelas, mapel, dan guru.

**Relasi**:
- `jadwal.kelas_id → kelas.id`
- `jadwal.mapel_id → mapel.id`
- `jadwal.guru_id → guru.id`

## Prerequisites

Pastikan Anda sudah menginstall:
- **PHP >= 8.2**
- **Composer**
- **MySQL/MariaDB** (version 5.7+)
- **Git** (untuk clone repository)
- **Node.js & npm** (optional, untuk compile frontend assets)
- **Postman/Insomnia** (optional, untuk testing API)

### Cek Versi
```bash
# Cek PHP
php -v

# Cek Composer
composer --version

# Cek MySQL
mysql --version
```

## Instalasi & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd sekolah-api-Local
```

### 2. Install Dependencies

**Install PHP Dependencies:**
```bash
composer install
```

**Install Node Dependencies (Optional):**
```bash
npm install
```

### 3. Konfigurasi Environment

**Windows:**
```bash
copy .env.example .env
```

**Linux/macOS:**
```bash
cp .env.example .env
```

**Generate Application Key:**
```bash
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan dengan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

**Penting:** Ganti `your_password` dengan password MySQL Anda.

### 5. Buat Database

Sebelum migrasi, buat database terlebih dahulu:

**Via MySQL Command Line:**
```bash
mysql -u root -p -e "CREATE DATABASE sekolah_api;"
```

**Via phpMyAdmin:**
1. Buka phpMyAdmin di browser
2. Klik tab "Database" atau "New"
3. Masukkan nama database: `sekolah_api`
4. Klik "Create"

**Via MySQL Workbench:**
1. Buka MySQL Workbench
2. Connect ke server
3. Run SQL: `CREATE DATABASE sekolah_api;`

### 6. Migrasi & Seeding Database
```bash
php artisan migrate:fresh --seed
```

Output yang diharapkan:
```
INFO  Preparing database.
INFO  Running migrations.
INFO  Running seeders.
  Database\Seeders\DatabaseSeeder ................... DONE
```

### 7. Jalankan Development Server
```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

### 8. Test Instalasi

Verifikasi instalasi berhasil dengan mengakses endpoint:

**Via Browser:**
```
http://localhost:8000/api/guru
```

**Via curl:**
```bash
curl http://localhost:8000/api/guru
```

**Via PowerShell:**
```powershell
Invoke-RestMethod -Uri http://localhost:8000/api/guru
```

Jika berhasil, Anda akan melihat response JSON dengan daftar guru.

### 9. Compile Frontend Assets (Optional)

Jika ingin menggunakan Vite untuk compile assets:
```bash
# Development mode
npm run dev

# Production build
npm run build
```

## Default User Accounts

Setelah seeding, Anda dapat login dengan akun berikut:

**Admin:**
- Username: `admin`
- Password: `admin123`

**Guru:**
- Username: `budi.guru`
- Password: `guru123`

## API Endpoints

Semua endpoint menggunakan format Collection+JSON.

### Base URL
```
http://localhost:8000/api
```

### Available Endpoints

| Endpoint | Method | Deskripsi |
|----------|--------|-----------|
| `/api/guru` | GET | Daftar semua guru |
| `/api/guru` | POST | Tambah guru baru |
| `/api/guru/{id}` | GET | Detail guru |
| `/api/guru/{id}` | PUT/PATCH | Update guru |
| `/api/guru/{id}` | DELETE | Hapus guru |
| `/api/siswa` | GET | Daftar semua siswa |
| `/api/siswa` | POST | Tambah siswa baru |
| `/api/siswa/{id}` | GET | Detail siswa |
| `/api/siswa/{id}` | PUT/PATCH | Update siswa |
| `/api/siswa/{id}` | DELETE | Hapus siswa |
| `/api/kelas` | GET | Daftar semua kelas |
| `/api/kelas` | POST | Tambah kelas baru |
| `/api/kelas/{id}` | GET | Detail kelas |
| `/api/kelas/{id}` | PUT/PATCH | Update kelas |
| `/api/kelas/{id}` | DELETE | Hapus kelas |
| `/api/mapel` | GET | Daftar semua mapel |
| `/api/mapel` | POST | Tambah mapel baru |
| `/api/mapel/{id}` | GET | Detail mapel |
| `/api/mapel/{id}` | PUT/PATCH | Update mapel |
| `/api/mapel/{id}` | DELETE | Hapus mapel |
| `/api/jadwal` | GET | Daftar semua jadwal |
| `/api/jadwal` | POST | Tambah jadwal baru |
| `/api/jadwal/{id}` | GET | Detail jadwal |
| `/api/jadwal/{id}` | PUT/PATCH | Update jadwal |
| `/api/jadwal/{id}` | DELETE | Hapus jadwal |

## Contoh Request

### GET All Guru
```bash
curl http://localhost:8000/api/guru
```

### POST Create Siswa
```bash
curl -X POST http://localhost:8000/api/siswa \
  -H "Content-Type: application/json" \
  -d '{
    "nis": "2023010",
    "nama": "Budi Santoso",
    "gender": "laki-laki",
    "email": "budi@student.com",
    "kelas_id": 1
  }'
```

## Fitur Collection+JSON

API ini mengimplementasikan Collection+JSON yang menyediakan:
- **Template** - Form untuk membuat data baru
- **Queries** - Endpoint pencarian
- **Links** - Navigasi ke resource terkait
- **Error Handling** - Format error yang konsisten

## Sample Data

Setelah seeding, database akan berisi:
- 1 Admin account
- 3 Guru accounts
- 4 Kelas (X-IPA-1, X-IPA-2, XI-IPS-1, XII-IPA-1)
- 5 Mata Pelajaran
- 4 Siswa
- 6 Jadwal pelajaran

## Testing

Anda dapat menggunakan tools berikut untuk testing:
- **Postman** - Import collection dari dokumentasi
- **curl** - Command line testing
- **Insomnia** - REST client
- **PowerShell** - `Invoke-RestMethod` untuk Windows
- Browser - Untuk GET requests

## Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database 'sekolah_api'

**Penyebab:** Database belum dibuat.

**Solusi:**
```bash
mysql -u root -p -e "CREATE DATABASE sekolah_api;"
```

### Error: SQLSTATE[HY000] [2002] Connection refused

**Penyebab:** MySQL service belum running.

**Solusi:**

**Windows:**
```bash
net start mysql
# atau
net start mysql80
```

**Linux:**
```bash
sudo service mysql start
# atau
sudo systemctl start mysql
```

**macOS:**
```bash
brew services start mysql
```

### Error: Class "Composer\..." not found

**Penyebab:** Dependencies belum terinstall.

**Solusi:**
```bash
composer install
```

### Error: No application encryption key has been specified

**Penyebab:** Application key belum digenerate.

**Solusi:**
```bash
php artisan key:generate
```

### Error: SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'

**Penyebab:** Password MySQL salah di file `.env`.

**Solusi:**
1. Periksa password MySQL Anda
2. Edit file `.env` dan sesuaikan `DB_PASSWORD`
3. Jika MySQL tanpa password, kosongkan: `DB_PASSWORD=`

### Error: Table 'sekolah_api.users' doesn't exist

**Penyebab:** Migrasi belum dijalankan.

**Solusi:**
```bash
php artisan migrate:fresh --seed
```

### Reset Database

Jika ingin reset database dan mulai dari awal:
```bash
php artisan migrate:fresh --seed
```

**WARNING:** Perintah ini akan **menghapus semua data**!

## Dokumentasi Lainnya

- **[QUICK_START.md](QUICK_START.md)** - Panduan cepat setup dalam 5 menit
- **[DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)** - Struktur database detail & ERD
- **[COLLECTION_JSON_DOCUMENTATION.md](COLLECTION_JSON_DOCUMENTATION.md)** - Format API lengkap
- **[COLLECTION_JSON_EXAMPLES.md](COLLECTION_JSON_EXAMPLES.md)** - Contoh request & response
- **[COLLECTION_JSON_HATEOAS.md](COLLECTION_JSON_HATEOAS.md)** - HATEOAS implementation
- **[IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)** - Ringkasan implementasi

## Dokumentasi Format

- [Collection+JSON Specification](http://amundsen.com/media-types/collection/format/)
- Lihat file `COLLECTION_JSON_DOCUMENTATION.md` untuk detail lengkap
- Lihat file `COLLECTION_JSON_EXAMPLES.md` untuk contoh response

## Tech Stack

- **Laravel 11** - PHP Framework
- **MySQL** - Database
- **Collection+JSON** - API Media Type Format
- **PHP 8.2+** - Programming Language
- **Composer** - Dependency Manager

## Project Structure

```
sekolah-api-Local/
├── app/
│   ├── Http/Controllers/    # API Controllers
│   ├── Models/              # Eloquent Models
│   └── Traits/              # Reusable Traits
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── routes/
│   └── api.php              # API routes definition
├── .env.example             # Environment template
└── README.md                # This file
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

