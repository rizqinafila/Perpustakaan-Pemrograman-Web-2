-- =========================================
-- 1. STATISTIK BUKU
-- =========================================

-- 1. Total semua buku
SELECT COUNT(*) AS total_buku 
FROM buku;

-- 2. Total nilai inventaris (harga × stok)
SELECT SUM(harga * stok) AS total_inventaris 
FROM buku;

-- 3. Rata-rata harga buku
SELECT AVG(harga) AS rata_rata_harga 
FROM buku;

-- 4. Buku termahal
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC 
LIMIT 1;

-- 5. Buku dengan stok terbanyak
SELECT judul, stok 
FROM buku 
ORDER BY stok DESC 
LIMIT 1;

-- =========================================
-- 2. FILTER DAN PENCARIAN
-- =========================================

-- 6. Buku kategori Programming dengan harga < 100.000
SELECT * FROM buku 
WHERE kategori = 'Programming' AND harga < 100000;

-- 7. Buku dengan judul mengandung PHP atau MySQL
SELECT * FROM buku 
WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';

-- 8. Buku terbit tahun 2024
SELECT * FROM buku 
WHERE tahun_terbit = 2024;

-- 9. Buku dengan stok antara 5 sampai 10
SELECT * FROM buku 
WHERE stok BETWEEN 5 AND 10;

-- 10. Buku dengan pengarang Budi Raharjo
SELECT * FROM buku 
WHERE pengarang = 'Budi Raharjo';

-- =========================================
-- 3. GROUPING DAN AGREGASI
-- =========================================

-- 11. Jumlah buku per kategori + total stok
SELECT 
    kategori,
    COUNT(*) AS jumlah_buku,
    SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;

-- 12. Rata-rata harga per kategori
SELECT 
    kategori,
    AVG(harga) AS rata_rata_harga
FROM buku
GROUP BY kategori;

-- 13. Kategori dengan nilai inventaris terbesar
SELECT 
    kategori,
    SUM(harga * stok) AS total_inventaris
FROM buku
GROUP BY kategori
ORDER BY total_inventaris DESC
LIMIT 1;

-- =========================================
-- 4. UPDATE DATA
-- =========================================

-- 14. Naikkan harga buku Programming 5%
UPDATE buku 
SET harga = harga * 1.05
WHERE kategori = 'Programming';

-- 15. Tambah stok 10 jika stok < 5
UPDATE buku 
SET stok = stok + 10
WHERE stok < 5;

-- =========================================
-- 5. LAPORAN KHUSUS
-- =========================================

-- 16. Buku yang perlu restocking (stok < 5)
SELECT * FROM buku 
WHERE stok < 5;

-- 17. Top 5 buku termahal
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC 
LIMIT 5;