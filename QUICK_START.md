# 🚀 Quick Start Guide - Sekolah API

Panduan cepat untuk menjalankan Sekolah API dalam waktu 5 menit!

## ✅ Prerequisites

Pastikan Anda sudah menginstall:
- ✅ PHP >= 8.2
- ✅ Composer
- ✅ MySQL/MariaDB
- ✅ (Optional) Postman/Insomnia untuk testing

## 📋 Setup Steps

### 1. Install Dependencies
```bash
composer install
```

### 2. Setup Environment
```bash
# Copy .env.example to .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Konfigurasi Database

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Buat Database

Buka MySQL/phpMyAdmin dan jalankan:
```sql
CREATE DATABASE sekolah_api;
```

Atau via command line:
```bash
mysql -u root -p -e "CREATE DATABASE sekolah_api;"
```

### 5. Migrate & Seed Database
```bash
php artisan migrate:fresh --seed
```

Output yang diharapkan:
```
INFO  Preparing database.
  Creating migration table .......................... 264ms DONE
INFO  Running migrations.
  0001_01_01_000000_create_users_table ............... 50ms DONE
  0001_01_01_000001_create_cache_table ............... 12ms DONE
  0001_01_01_000002_create_jobs_table ................ 25ms DONE
  2026_03_02_000001_create_guru_table ................ 30ms DONE
  2026_03_02_000002_create_kelas_table ............... 15ms DONE
  2026_03_02_000003_create_mapel_table ............... 15ms DONE
  2026_03_02_000004_create_siswa_table ............... 20ms DONE
  2026_03_02_000005_create_jadwal_table .............. 22ms DONE
INFO  Running seeders.
  Database\Seeders\DatabaseSeeder ................... 100ms DONE
```

### 6. Jalankan Development Server
```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

---

## 🧪 Testing API

### Method 1: Using Browser
Buka browser dan akses:
```
http://localhost:8000/api/guru
```

### Method 2: Using curl
```bash
curl http://localhost:8000/api/guru
```

### Method 3: Using Postman
1. Buka Postman
2. Create new request: `GET http://localhost:8000/api/guru`
3. Send

---

## 👤 Default Login Accounts

Setelah seeding berhasil, Anda dapat menggunakan akun berikut:

### Admin Account
```
Username: admin
Password: admin123
Type: admin
```

### Guru Accounts
```
Username: budi.guru
Password: guru123
Type: guru

Username: siti.guru
Password: guru123
Type: guru

Username: ahmad.guru
Password: guru123
Type: guru
```

---

## 📊 Sample Data

Setelah seeding, database akan terisi dengan:

✅ **1 Admin + 3 Guru Accounts**
✅ **3 Data Guru**
- Budi Santoso, S.Pd (Matematika)
- Siti Nurhaliza, S.Pd (Fisika)
- Ahmad Dahlan, S.Pd (Biologi)

✅ **4 Kelas**
- X-IPA-1, X-IPA-2
- XI-IPS-1
- XII-IPA-1

✅ **5 Mata Pelajaran**
- Matematika, Fisika, Biologi, Kimia, Bahasa Inggris

✅ **4 Siswa**
- Andi Prakoso (X-IPA-1)
- Dewi Lestari (X-IPA-1)
- Rizki Ramadhan (X-IPA-2)
- Sari Wahyuni (XI-IPS-1)

✅ **6 Jadwal Pelajaran**
- Senin: Matematika & Fisika (X-IPA-1)
- Selasa: Biologi (X-IPA-1), Matematika (X-IPA-2)
- Rabu: Fisika (X-IPA-2)
- Kamis: Bahasa Inggris (XI-IPS-1)

---

## 🔗 Available Endpoints

Base URL: `http://localhost:8000/api`

| Resource | GET (List) | POST (Create) | GET (Detail) | PUT/PATCH (Update) | DELETE |
|----------|------------|---------------|--------------|-------------------|---------|
| Guru | ✅ `/guru` | ✅ `/guru` | ✅ `/guru/{id}` | ✅ `/guru/{id}` | ✅ `/guru/{id}` |
| Siswa | ✅ `/siswa` | ✅ `/siswa` | ✅ `/siswa/{id}` | ✅ `/siswa/{id}` | ✅ `/siswa/{id}` |
| Kelas | ✅ `/kelas` | ✅ `/kelas` | ✅ `/kelas/{id}` | ✅ `/kelas/{id}` | ✅ `/kelas/{id}` |
| Mapel | ✅ `/mapel` | ✅ `/mapel` | ✅ `/mapel/{id}` | ✅ `/mapel/{id}` | ✅ `/mapel/{id}` |
| Jadwal | ✅ `/jadwal` | ✅ `/jadwal` | ✅ `/jadwal/{id}` | ✅ `/jadwal/{id}` | ✅ `/jadwal/{id}` |

---

## 📝 Example Requests

### GET All Guru
```bash
curl http://localhost:8000/api/guru
```

### GET Guru by ID
```bash
curl http://localhost:8000/api/guru/1
```

### POST Create New Mapel
```bash
curl -X POST http://localhost:8000/api/mapel \
  -H "Content-Type: application/json" \
  -d '{
    "kode_mapel": "SEJ01",
    "nama_mapel": "Sejarah"
  }'
```

### POST Create New Siswa
```bash
curl -X POST http://localhost:8000/api/siswa \
  -H "Content-Type: application/json" \
  -d '{
    "nis": "2023005",
    "nama": "Ahmad Hidayat",
    "gender": "laki-laki",
    "email": "ahmad.hidayat@student.com",
    "kelas_id": 1
  }'
```

### PUT Update Kelas
```bash
curl -X PUT http://localhost:8000/api/kelas/1 \
  -H "Content-Type: application/json" \
  -d '{
    "kode_kelas": "X-IPA-1",
    "nama_kelas": "Kelas 10 IPA 1 (Updated)"
  }'
```

### DELETE Jadwal
```bash
curl -X DELETE http://localhost:8000/api/jadwal/1
```

---

## 🐛 Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database

**Solusi:** Database belum dibuat. Jalankan:
```bash
mysql -u root -p -e "CREATE DATABASE sekolah_api;"
```

### Error: SQLSTATE[HY000] [2002] Connection refused

**Solusi:** MySQL belum running. Start MySQL service:
```bash
# Windows
net start mysql

# macOS
brew services start mysql

# Linux
sudo service mysql start
```

### Error: Class "Composer\..." not found

**Solusi:** Dependencies belum terinstall:
```bash
composer install
```

### Error: No application encryption key

**Solusi:** Generate app key:
```bash
php artisan key:generate
```

### Error: Table 'users' doesn't exist

**Solusi:** Jalankan migrasi:
```bash
php artisan migrate:fresh --seed
```

---

## 🔄 Reset Database

Jika ingin reset database dan mulai dari awal:

```bash
# Drop all tables, re-migrate, and reseed
php artisan migrate:fresh --seed
```

**⚠️ WARNING:** Perintah ini akan **menghapus semua data**!

---

## 📚 Additional Resources

- 📖 [README.md](README.md) - Dokumentasi lengkap
- 📊 [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) - Struktur database detail
- 🔧 [COLLECTION_JSON_DOCUMENTATION.md](COLLECTION_JSON_DOCUMENTATION.md) - Format API
- 💡 [COLLECTION_JSON_EXAMPLES.md](COLLECTION_JSON_EXAMPLES.md) - Contoh response

---

## ✅ Checklist

Pastikan semua langkah berikut sudah dilakukan:

- [ ] PHP 8.2+ terinstall
- [ ] Composer terinstall
- [ ] MySQL running
- [ ] Database `sekolah_api` sudah dibuat
- [ ] File `.env` sudah dikonfigurasi
- [ ] `composer install` berhasil
- [ ] `php artisan key:generate` berhasil
- [ ] `php artisan migrate:fresh --seed` berhasil
- [ ] `php artisan serve` berjalan
- [ ] Test API endpoint berhasil

---

## 🎉 Selesai!

Jika semua checklist sudah ✅, aplikasi Anda sudah siap digunakan!

**Next Steps:**
1. Explore API endpoints dengan Postman
2. Baca dokumentasi Collection+JSON
3. Customize sesuai kebutuhan Anda
4. Deploy ke production (optional)

---

**Need Help?**
- 📧 Contact: [your-email@example.com]
- 🐛 Issues: [GitHub Issues]
- 📖 Docs: [README.md](README.md)

Happy Coding! 🚀
