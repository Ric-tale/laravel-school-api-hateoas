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

## Instalasi & Setup

### 1. Install Dependencies
```bash
composer install
```

### 2. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database
Edit file `.env` dan sesuaikan dengan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_api
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seeding Database
```bash
php artisan migrate:fresh --seed
```

### 5. Jalankan Server
```bash
php artisan serve
```

API akan berjalan di `http://localhost:8000`

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
- Browser - Untuk GET requests

## Dokumentasi Format

- [Collection+JSON Specification](http://amundsen.com/media-types/collection/format/)
- Lihat file `COLLECTION_JSON_DOCUMENTATION.md` untuk detail lengkap
- Lihat file `COLLECTION_JSON_EXAMPLES.md` untuk contoh response

## Tech Stack

- **Laravel 11** - PHP Framework
- **MySQL** - Database
- **Collection+JSON** - API Format

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

📚 **Dokumentasi Database Lengkap**

Lihat dokumentasi lengkap struktur database dan relasi di file dokumentasi Anda.

🔧 **Support**

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.


In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
