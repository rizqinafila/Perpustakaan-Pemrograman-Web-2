CREATE DATABASE perpustakaan_lengkap;
USE perpustakaan_lengkap;

CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(20) UNIQUE NOT NULL,
    judul VARCHAR(200) NOT NULL,
    id_kategori INT,
    id_penerbit INT,
    pengarang VARCHAR(100),
    tahun_terbit INT,
    harga DECIMAL(10,2),
    stok INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
);

INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Programming', 'Buku pemrograman'),
('Database', 'Buku database'),
('Web Design', 'Desain web'),
('Networking', 'Jaringan komputer'),
('Data Science', 'Analisis data');

INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Informatika', 'Bandung', '0811111111', 'info@informatika.com'),
('Erlangga', 'Jakarta', '0822222222', 'info@erlangga.com'),
('Andi Offset', 'Yogyakarta', '0833333333', 'info@andi.com'),
('Gramedia', 'Jakarta', '0844444444', 'info@gramedia.com'),
('Graha Ilmu', 'Yogyakarta', '0855555555', 'info@graha.com');

INSERT INTO buku (kode_buku, judul, id_kategori, id_penerbit, pengarang, tahun_terbit, harga, stok) VALUES
('BK-001','Belajar PHP',1,1,'Budi Raharjo',2023,75000,10),
('BK-002','Mastering MySQL',2,5,'Andi Nugroho',2022,95000,5),
('BK-003','Laravel Advanced',1,1,'Siti Aminah',2024,125000,8),
('BK-004','Web Design UI',3,3,'Dedi Santoso',2023,85000,15),
('BK-005','Network Security',4,2,'Rina Wijaya',2023,110000,3),
('BK-006','Python Data Science',5,4,'Ahmad Yani',2024,130000,7),
('BK-007','HTML CSS Dasar',3,3,'Dedi Santoso',2022,60000,20),
('BK-008','JavaScript Modern',1,1,'Siti Aminah',2023,80000,0),
('BK-009','PostgreSQL Advanced',2,5,'Ahmad Yani',2024,115000,6),
('BK-010','Machine Learning',5,4,'Rina Wijaya',2024,150000,4),
('BK-011','Cisco Networking',4,2,'Budi Raharjo',2022,140000,2),
('BK-012','React JS Guide',1,1,'Siti Aminah',2024,120000,9),
('BK-013','Database Design',2,5,'Andi Nugroho',2023,100000,11),
('BK-014','UX Design',3,3,'Dedi Santoso',2023,90000,13),
('BK-015','Big Data Analytics',5,4,'Ahmad Yani',2024,160000,5);

-- 1. Tampilkan buku + kategori + penerbit
SELECT 
    b.judul,
    k.nama_kategori,
    p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;

-- 2. Jumlah buku per kategori
SELECT 
    k.nama_kategori,
    COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
GROUP BY k.nama_kategori;

-- 3. Jumlah buku per penerbit
SELECT 
    p.nama_penerbit,
    COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
GROUP BY p.nama_penerbit;

-- 4. Detail lengkap buku
SELECT 
    b.kode_buku,
    b.judul,
    k.nama_kategori,
    p.nama_penerbit,
    b.harga,
    b.stok
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;