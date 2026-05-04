<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Function Search Buku</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    </head>
    <body>
        <div class="container mt-5">
            <h1 class="mb-4"><i class="bi bi-search"></i> Function Search Buku</h1>

        <?php 

        // Data buku
        $buku_list = [
            ["kode"=>"BK-001","judul"=>"Pemrograman PHP untuk Pemula","kategori"=>"Programming","pengarang"=>"Budi Raharjo","tahun"=>2023,"harga"=>75000,"stok"=>10],
            ["kode"=>"BK-002","judul"=>"Mastering MySQL Database","kategori"=>"Database","pengarang"=>"Andi Nugroho","tahun"=>2022,"harga"=>95000,"stok"=>5],
            ["kode"=>"BK-003","judul"=>"Laravel Framework Advanced","kategori"=>"Programming","pengarang"=>"Siti Aminah","tahun"=>2024,"harga"=>125000,"stok"=>8],
            ["kode"=>"BK-004","judul"=>"PHP Web Services","kategori"=>"Programming","pengarang"=>"Budi Raharjo","tahun"=>2023,"harga"=>85000,"stok"=>12],
            ["kode"=>"BK-005","judul"=>"PostgreSQL Advanced","kategori"=>"Database","pengarang"=>"Rina Wijaya","tahun"=>2024,"harga"=>110000,"stok"=>3]
        ];

        // 1. Cari buku by kode
        function cari_by_kode($buku_list, $kode) {
            foreach ($buku_list as $buku) {
                if ($buku["kode"] == $kode) {
                    return $buku;
                }
            }
            return null;
        }

        // 2. Cari buku by judul
        function cari_by_judul($buku_list, $keyword) {
            $hasil = [];
            foreach ($buku_list as $buku) {
                if (stripos($buku["judul"], $keyword) !== false) {
                    $hasil[] = $buku;
                }
            }
            return $hasil;
        }

        // 3. Cari buku by kategori
        function cari_by_kategori($buku_list, $kategori) {
            $hasil = [];
            foreach ($buku_list as $buku) {
                if ($buku["kategori"] == $kategori) {
                    $hasil[] = $buku;
                }
            }
            return $hasil;
        }

        // 4. Cari buku by pengarang
        function cari_by_pengarang($buku_list, $pengarang) {
            $hasil = [];
            foreach ($buku_list as $buku) {
                if (stripos($buku["pengarang"], $pengarang) !== false) {
                    $hasil[] = $buku;
                }
            }
            return $hasil;
        }

        // 5. Cari buku by range harga
        function cari_by_range_harga($buku_list, $min, $max) {
            $hasil = [];
            foreach ($buku_list as $buku) {
                if ($buku["harga"] >= $min && $buku["harga"] <= $max) {
                    $hasil[] = $buku;
                }
            }
            return $hasil;
        }

        // 6. Buku tersedia
        function cari_buku_tersedia($buku_list) {
            $hasil = [];
            foreach ($buku_list as $buku) {
                if ($buku["stok"] > 0) {
                    $hasil[] = $buku;
                }
            }
            return $hasil;
        }

        // 7. Buku terbaru
        function cari_buku_terbaru($buku_list, $tahun) {
            $hasil = [];
            foreach ($buku_list as $buku) {
                if ($buku["tahun"] >= $tahun) {
                    $hasil[] = $buku;
                }
            }
            return $hasil;
        }

        // tampilkan hasil
        function tampilkan_hasil($hasil, $judul) {
            if (count($hasil) > 0) {
                echo "<div class='alert alert-success'><strong>$judul:</strong> Ditemukan ".count($hasil)." buku</div>";
                echo "<table class='table table-bordered'><thead><tr>
                <th>No</th><th>Kode</th><th>Judul</th><th>Kategori</th><th>Pengarang</th><th>Tahun</th><th>Harga</th><th>Stok</th>
                </tr></thead><tbody>";

                $no=1;
                foreach($hasil as $buku){
                    echo "<tr>
                    <td>$no</td>
                    <td>{$buku['kode']}</td>
                    <td>{$buku['judul']}</td>
                    <td>{$buku['kategori']}</td>
                    <td>{$buku['pengarang']}</td>
                    <td>{$buku['tahun']}</td>
                    <td>Rp ".number_format($buku['harga'],0,',','.')."</td>
                    <td>{$buku['stok']}</td>
                    </tr>";
                    $no++;
                }
                echo "</tbody></table>";
            } else {
                echo "<div class='alert alert-warning'>$judul: Tidak ditemukan</div>";
            }
        }
        ?>

        <!-- Contoh penggunaan -->
        <?php
        tampilkan_hasil(cari_by_judul($buku_list,"PHP"), "Cari Judul PHP");
        tampilkan_hasil(cari_by_kategori($buku_list,"Programming"), "Kategori Programming");
        tampilkan_hasil(cari_by_pengarang($buku_list,"Budi"), "Pengarang Budi");
        tampilkan_hasil(cari_by_range_harga($buku_list,70000,100000), "Harga 70k-100k");
        tampilkan_hasil(cari_buku_terbaru($buku_list,2024), "Buku Terbaru");
        ?>

        </div>
    </body>
</html>