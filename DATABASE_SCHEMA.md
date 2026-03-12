# Database Schema - Sekolah API

## Diagram Relasi Database (ERD)

```
┌─────────────┐
│    users    │
│─────────────│
│ id          │◄──┐
│ type        │   │
│ username    │   │
│ password    │   │
└─────────────┘   │
                  │ 1:1
                  │
┌─────────────┐   │
│    guru     │   │
│─────────────│   │
│ id          │   │
│ user_id     │───┘
│ nip         │
│ nama        │
│ email       │◄──┐
│ ...         │   │
└─────────────┘   │
       │          │
       │ 1:N      │
       │          │
       ▼          │
┌─────────────┐   │
│   jadwal    │   │
│─────────────│   │
│ id          │   │
│ kelas_id    │───┐
│ mapel_id    │───┼──┐
│ guru_id     │───┘  │
│ hari        │      │
│ jam         │      │
└─────────────┘      │
       ▲             │
       │             │
       │             │
  ┌────┴────┐        │
  │         │        │
  │ 1:N     │ 1:N    │
  │         │        │
┌─▼─────────┐  ┌────▼──────┐
│   kelas   │  │   mapel   │
│───────────│  │───────────│
│ id        │  │ id        │
│ kode      │  │ kode      │
│ nama      │  │ nama      │
└───────────┘  └───────────┘
       ▲
       │ 1:N
       │
┌──────▼──────┐
│    siswa    │
│─────────────│
│ id          │
│ nis         │
│ nama        │
│ kelas_id    │
│ email       │
│ ...         │
└─────────────┘
```

## Detail Tabel

### 1. Table: `users`
**Fungsi:** Menyimpan akun login untuk admin dan guru

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik user |
| type | ENUM('admin', 'guru') | NOT NULL | Tipe pengguna |
| username | VARCHAR(255) | UNIQUE, NOT NULL | Username login |
| password | VARCHAR(255) | NOT NULL | Password (hashed) |
| remember_token | VARCHAR(100) | NULL | Token untuk "remember me" |
| created_at | TIMESTAMP | NULL | Timestamp dibuat |
| updated_at | TIMESTAMP | NULL | Timestamp update |

**Relasi:**
- `users.id` → `guru.user_id` (One-to-One)

**Contoh Data:**
```json
{
  "id": 1,
  "type": "admin",
  "username": "admin",
  "password": "$2y$12$...",
  "created_at": "2026-03-12 08:00:00"
}
```

---

### 2. Table: `guru`
**Fungsi:** Menyimpan data lengkap guru

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID guru |
| user_id | BIGINT | FOREIGN KEY, UNIQUE | Referensi ke users.id |
| nip | VARCHAR(255) | UNIQUE | Nomor Induk Pegawai |
| nama | VARCHAR(255) | NOT NULL | Nama lengkap guru |
| tempat_lahir | VARCHAR(255) | NULL | Tempat lahir |
| tgl_lahir | DATE | NULL | Tanggal lahir |
| gender | ENUM('laki-laki','perempuan') | NOT NULL | Jenis kelamin |
| phone_number | VARCHAR(15) | NULL | Nomor telepon |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email guru |
| alamat | TEXT | NULL | Alamat lengkap |
| pendidikan | VARCHAR(255) | NULL | Pendidikan terakhir |
| created_at | TIMESTAMP | NULL | Timestamp dibuat |
| updated_at | TIMESTAMP | NULL | Timestamp update |

**Relasi:**
- `guru.user_id` → `users.id` (Belongs To)
- `guru.id` ← `jadwal.guru_id` (Has Many)

**Contoh Data:**
```json
{
  "id": 1,
  "user_id": 2,
  "nip": "198501012010011001",
  "nama": "Budi Santoso, S.Pd",
  "tempat_lahir": "Jakarta",
  "tgl_lahir": "1985-01-01",
  "gender": "laki-laki",
  "phone_number": "081234567890",
  "email": "budi.santoso@sekolah.com",
  "alamat": "Jl. Pendidikan No. 10, Jakarta",
  "pendidikan": "S1 Pendidikan Matematika"
}
```

---

### 3. Table: `siswa`
**Fungsi:** Menyimpan data siswa

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID siswa |
| nis | VARCHAR(255) | UNIQUE | Nomor Induk Siswa |
| nama | VARCHAR(255) | NOT NULL | Nama lengkap siswa |
| gender | ENUM('laki-laki','perempuan') | NOT NULL | Jenis kelamin |
| tempat_lahir | VARCHAR(255) | NULL | Tempat lahir |
| tgl_lahir | DATE | NULL | Tanggal lahir |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email siswa |
| nama_ortu | VARCHAR(255) | NULL | Nama orang tua |
| alamat | TEXT | NULL | Alamat lengkap |
| phone_number | VARCHAR(15) | NULL | Nomor telepon |
| kelas_id | BIGINT | FOREIGN KEY, NULL | Referensi ke kelas.id |
| created_at | TIMESTAMP | NULL | Timestamp dibuat |
| updated_at | TIMESTAMP | NULL | Timestamp update |

**Relasi:**
- `siswa.kelas_id` → `kelas.id` (Belongs To)

**Cascade:** ON DELETE SET NULL, ON UPDATE CASCADE

**Contoh Data:**
```json
{
  "id": 1,
  "nis": "2023001",
  "nama": "Andi Prakoso",
  "gender": "laki-laki",
  "tempat_lahir": "Jakarta",
  "tgl_lahir": "2007-05-15",
  "email": "andi.prakoso@student.com",
  "nama_ortu": "Bapak Prakoso",
  "alamat": "Jl. Merdeka No. 20, Jakarta",
  "phone_number": "081298765432",
  "kelas_id": 1
}
```

---

### 4. Table: `kelas`
**Fungsi:** Menyimpan data kelas

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID kelas |
| kode_kelas | VARCHAR(255) | UNIQUE, NOT NULL | Kode kelas (X-IPA-1) |
| nama_kelas | VARCHAR(255) | NOT NULL | Nama lengkap kelas |
| created_at | TIMESTAMP | NULL | Timestamp dibuat |
| updated_at | TIMESTAMP | NULL | Timestamp update |

**Relasi:**
- `kelas.id` ← `siswa.kelas_id` (Has Many Siswa)
- `kelas.id` ← `jadwal.kelas_id` (Has Many Jadwal)

**Contoh Data:**
```json
{
  "id": 1,
  "kode_kelas": "X-IPA-1",
  "nama_kelas": "Kelas 10 IPA 1"
}
```

---

### 5. Table: `mapel`
**Fungsi:** Menyimpan mata pelajaran

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID mapel |
| kode_mapel | VARCHAR(255) | UNIQUE, NOT NULL | Kode mata pelajaran |
| nama_mapel | VARCHAR(255) | NOT NULL | Nama mata pelajaran |
| created_at | TIMESTAMP | NULL | Timestamp dibuat |
| updated_at | TIMESTAMP | NULL | Timestamp update |

**Relasi:**
- `mapel.id` ← `jadwal.mapel_id` (Has Many Jadwal)

**Contoh Data:**
```json
{
  "id": 1,
  "kode_mapel": "MAT01",
  "nama_mapel": "Matematika"
}
```

---

### 6. Table: `jadwal`
**Fungsi:** Menyimpan jadwal pelajaran (tabel pivot dengan data tambahan)

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID jadwal |
| kelas_id | BIGINT | FOREIGN KEY, NOT NULL | Referensi ke kelas.id |
| mapel_id | BIGINT | FOREIGN KEY, NOT NULL | Referensi ke mapel.id |
| guru_id | BIGINT | FOREIGN KEY, NOT NULL | Referensi ke guru.id |
| hari | ENUM | NOT NULL | Hari (senin sampai sabtu) |
| jam_pelajaran | VARCHAR(255) | NOT NULL | Jam mulai - selesai |
| created_at | TIMESTAMP | NULL | Timestamp dibuat |
| updated_at | TIMESTAMP | NULL | Timestamp update |

**Enum Values untuk `hari`:**
- 'senin'
- 'selasa'
- 'rabu'
- 'kamis'
- 'jumat'
- 'sabtu'

**Relasi:**
- `jadwal.kelas_id` → `kelas.id` (Belongs To)
- `jadwal.mapel_id` → `mapel.id` (Belongs To)
- `jadwal.guru_id` → `guru.id` (Belongs To)

**Cascade:** ON DELETE CASCADE, ON UPDATE CASCADE

**Contoh Data:**
```json
{
  "id": 1,
  "kelas_id": 1,
  "mapel_id": 1,
  "guru_id": 1,
  "hari": "senin",
  "jam_pelajaran": "07:00 - 08:30"
}
```

**Interpretasi:**
"Kelas X-IPA-1 belajar Matematika dengan Pak Budi pada hari Senin pukul 07:00 - 08:30"

---

## Tabel Sistem Laravel (Built-in)

### 7. Table: `password_reset_tokens`
Menyimpan token untuk reset password

| Kolom | Tipe |
|-------|------|
| email | VARCHAR(255) PRIMARY |
| token | VARCHAR(255) |
| created_at | TIMESTAMP |

---

### 8. Table: `sessions`
Menyimpan data session pengguna

| Kolom | Tipe |
|-------|------|
| id | VARCHAR(255) PRIMARY |
| user_id | BIGINT FOREIGN |
| ip_address | VARCHAR(45) |
| user_agent | TEXT |
| payload | LONGTEXT |
| last_activity | INTEGER |

---

### 9. Table: `cache` & `cache_locks`
Menyimpan cache aplikasi (Laravel built-in)

---

### 10. Table: `jobs`, `job_batches`, `failed_jobs`
Untuk queue system Laravel (Laravel built-in)

---

## Business Rules & Logic

### Rule 1: User Account
- ✅ Setiap guru **harus memiliki** akun user dengan type='guru'
- ✅ Admin tidak terkait dengan guru (type='admin')
- ✅ Username harus unique di seluruh sistem

### Rule 2: Guru
- ✅ Satu guru hanya punya 1 akun user (one-to-one)
- ✅ Guru bisa mengajar di banyak jadwal
- ✅ Email dan NIP harus unique

### Rule 3: Siswa
- ✅ Siswa harus berada di satu kelas
- ✅ Jika kelas dihapus, siswa tetap ada (kelas_id = NULL)
- ✅ Email dan NIS harus unique

### Rule 4: Jadwal
- ✅ Satu jadwal = kombinasi unik (kelas + mapel + guru + hari + jam)
- ✅ Jika guru/kelas/mapel dihapus, jadwal ikut terhapus (cascade)
- ❌ Tidak ada validasi bentrok jadwal (bisa ditambahkan di controller)

---

## Query Examples

### Ambil jadwal lengkap dengan relasi
```php
$jadwal = Jadwal::with(['kelas', 'mapel', 'guru'])
    ->where('hari', 'senin')
    ->get();
```

### Ambil semua siswa di kelas tertentu
```php
$siswa = Siswa::where('kelas_id', 1)->get();
```

### Ambil jadwal mengajar guru tertentu
```php
$jadwal = Jadwal::with(['kelas', 'mapel'])
    ->where('guru_id', 1)
    ->where('hari', 'senin')
    ->get();
```

### Ambil kelas dengan jumlah siswa
```php
$kelas = Kelas::withCount('siswas')->get();
```

---

## Indexes & Performance

### Recommended Indexes (sudah ada sebagian)

```sql
-- Foreign keys (auto-indexed)
ALTER TABLE guru ADD INDEX idx_user_id (user_id);
ALTER TABLE siswa ADD INDEX idx_kelas_id (kelas_id);
ALTER TABLE jadwal ADD INDEX idx_kelas_id (kelas_id);
ALTER TABLE jadwal ADD INDEX idx_mapel_id (mapel_id);
ALTER TABLE jadwal ADD INDEX idx_guru_id (guru_id);

-- Unique constraints (auto-indexed)
ALTER TABLE users ADD UNIQUE idx_username (username);
ALTER TABLE guru ADD UNIQUE idx_nip (nip);
ALTER TABLE guru ADD UNIQUE idx_email (email);
ALTER TABLE siswa ADD UNIQUE idx_nis (nis);
ALTER TABLE kelas ADD UNIQUE idx_kode_kelas (kode_kelas);
ALTER TABLE mapel ADD UNIQUE idx_kode_mapel (kode_mapel);

-- Composite index untuk query jadwal
ALTER TABLE jadwal ADD INDEX idx_hari_kelas (hari, kelas_id);
```

---

## Database Size Estimation

Asumsi untuk 1 tahun akademik:
- Users: ~50 records (1 admin + ~50 guru)
- Guru: ~50 records
- Siswa: ~300 records (10 kelas × 30 siswa)
- Kelas: ~10 records
- Mapel: ~15 records
- Jadwal: ~300 records (10 kelas × 30 jam/minggu)

**Total estimated size:** < 5 MB (sangat kecil)

---

## Security Considerations

1. ✅ Password di-hash menggunakan bcrypt (Laravel default)
2. ✅ Foreign key constraints untuk data integrity
3. ✅ Unique constraints untuk mencegah duplikasi
4. ⚠️ Belum ada: API authentication (JWT/Sanctum)
5. ⚠️ Belum ada: Role-based access control (RBAC)
6. ⚠️ Belum ada: Audit log untuk perubahan data

---

## Migration Order (Penting!)

Urutan migrasi harus tepat karena foreign key dependencies:

1. ✅ `0001_01_01_000000_create_users_table`
2. ✅ `0001_01_01_000001_create_cache_table`
3. ✅ `0001_01_01_000002_create_jobs_table`
4. ✅ `2026_03_02_000001_create_guru_table` (depends on users)
5. ✅ `2026_03_02_000002_create_kelas_table`
6. ✅ `2026_03_02_000003_create_mapel_table`
7. ✅ `2026_03_02_000004_create_siswa_table` (depends on kelas)
8. ✅ `2026_03_02_000005_create_jadwal_table` (depends on kelas, mapel, guru)

**Catatan:** Timestamp di nama file menentukan urutan eksekusi.

---

## Backup Strategy

Recommended backup schedule:
- **Daily:** Full database backup (automated)
- **Weekly:** Verification restore test
- **Before migration:** Manual backup

```bash
# Backup
mysqldump -u root -p sekolah_api > backup_$(date +%Y%m%d).sql

# Restore
mysql -u root -p sekolah_api < backup_20260312.sql
```

---

✅ **Struktur database ini sudah production-ready dengan catatan:**
- Tambahkan authentication ke API
- Implement validation di controller
- Setup scheduled backup
- Consider adding soft deletes untuk audit trail

📌 **Last Updated:** March 12, 2026
