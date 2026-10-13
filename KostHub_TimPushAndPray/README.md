# KostHub - Platform Manajemen Kost & Tagihan Terintegrasi Berbasis Web

KostHub adalah sistem informasi manajemen rumah kost berbasis web yang dirancang untuk mendigitalisasi proses administrasi antara Pemilik Kost dan Penghuni. Sistem ini mengotomatisasi pembuatan tagihan bulanan, memfasilitasi unggah bukti transfer pembayaran, serta menyediakan dashboard pemantauan kondisi kamar dan keuangan secara transparan.

---

## 🌟 Fitur Utama (Progres MVP Saat Ini)

### 👑 Modul Pemilik Kost (Owner)
- **Dashboard Ringkasan Properti**:
  - Kartu statistik real-time: Total Kamar, Kamar Terisi, Kamar Kosong, dan Pendapatan Bulan Ini[cite: 5, 8, 9].
  - Visual peta kondisi kamar berbasis grid warna (Hijau: Tersedia, Merah: Terisi)[cite: 5, 8, 9].
- **Verifikasi Pembayaran**:
  - Halaman peninjauan bukti transfer yang diunggah oleh penghuni[cite: 5, 8, 9].
  - Mekanisme persetujuan (*approve*) atau penolakan (*reject*) bukti pembayaran[cite: 5, 8, 9].

### 🏠 Modul Penghuni Kost (Tenant)
- **Dashboard Penghuni**:
  - Informasi rincian tagihan sewa aktif periode berjalan[cite: 5, 8, 9].
  - Penanda status pembayaran (`UNPAID`, `PENDING`, `PAID`)[cite: 5, 8, 9].
- **Unggah Bukti Pembayaran**:
  - Form unggah file foto/gambar bukti transfer bank[cite: 5, 6, 8, 9].

### ⚙️ Fitur Sistem Otomatis
- **Role-Based Access Control (RBAC)**: Pembatasan hak akses rute terpisah antara Pemilik (`/owner/*`) dan Penghuni (`/tenant/*`)[cite: 6, 8].
- **Task Scheduler Penagihan Otomatis**: Perintah Artisan `invoices:generate` yang berjalan terjadwal setiap tanggal 1 bulan berjalan untuk memunculkan tagihan sewa bulanan bagi seluruh penghuni aktif[cite: 6, 8].

---

## 🛠️ Tech Stack & Dependencies

- **Framework**: Laravel 11 (PHP 8.3)[cite: 6]
- **Database**: MySQL 8.0[cite: 6, 7]
- **Authentication**: Laravel Breeze (Blade View Engine)[cite: 6, 8, 13]
- **Frontend Styling**: Tailwind CSS & Alpine.js via Vite[cite: 6, 8]
- **Storage**: Laravel Local Storage Link (`storage:link`)[cite: 6, 8]

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat Sistem
Pastikan perangkat kamu telah terinstall:
- PHP >= 8.2[cite: 6, 14]
- Composer[cite: 14]
- Node.js & NPM[cite: 14]
- MySQL Server[cite: 6, 14]

### 2. Kloning Repository & Setup
```bash
# Clone repository ini
git clone [https://github.com/dhanyrolas21/kosthub.git](https://github.com/dhanyrolas21/kosthub.git)
cd kosthub

# Install dependencies PHP & Node
composer install
npm install