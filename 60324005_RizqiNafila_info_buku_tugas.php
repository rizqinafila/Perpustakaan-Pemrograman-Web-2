<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>

        <?php 
        $dataBuku = [
            [
                "judul" => "Laravel: From Beginner to Advanced",
                "pengarang" =>"Rizqi Nafila",
                "penerbit" => "Informatika",
                "tahun_terbit" => 2025,
                "harga" => 125000,
                "stok" => 8,
                "isbn" => "978-602-1234-56-7",
                "kategori" => "Pemrograman",
                "bahasa" => "Indonesia",
                "jumlah_halaman" => 350,
                "berat" => "450 gram"
            ],
            [
                "judul" => "Pemrograman Basis Data Berbasis Web Menggunakan PHP & MySQL",
                "pengarang" =>"Yeni Kustiyaningsih",
                "penerbit" => "Graha Ilmu",
                "tahun_terbit" => 2011,
                "harga" => 85000,
                "stok" => 17,
                "isbn" => "978-979-756-715-6",
                "kategori" => "Database",
                "bahasa" => "Indonesia",
                "jumlah_halaman" => 230,
                "berat" => "350 gram" 
            ],
            [
                "judul" => "Desain dan Pemrograman Web: HTML, CSS, PHP, MySQL & Bootstrap",
                "pengarang" =>"Moch. Kholil",
                "penerbit" => "Klik Media",
                "tahun_terbit" => 2021,
                "harga" => 120000,
                "stok" => 27,
                "isbn" => "978-623-244-456-7",
                "kategori" => "Web Design",
                "bahasa" => "Indonesia",
                "jumlah_halaman" => 255,
                "berat" => "400 gram"
            ],
            [
                "judul" => "Buku Sakti Pemrograman Web: HTML, CSS, PHP, MySQL & JavaScript",
                "pengarang" =>"Didik Setiawan",
                "penerbit" => "Start Up",
                "tahun_terbit" => 2018,
                "harga" => 70000,
                "stok" => 14,
                "isbn" => "978-602-6673-34-3",
                "kategori" => "Pemrograman",
                "bahasa" => "Indonesia",
                "jumlah_halaman" => 216,
                "berat" => "300 gram"
            ],
        ];
        ?>

        <?php 
        for ($i = 0; $i < count($dataBuku); $i++){?>
            <div class="card mb-3">
                <div class="card-header <?php 
                    if ($dataBuku[$i]["kategori"] == "Pemrograman"){
                        echo "bg-primary";
                    } elseif ($dataBuku[$i]["kategori"] == "Database"){
                        echo "bg-warning";
                    } elseif ($dataBuku [$i]["kategori"] == "Web Design"){
                        echo "bg-secondary";
                    }
                ?> text-white">
                    <h5 class="mb-0"><?php echo $dataBuku[$i]["judul"]; ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-boorderless">
                        <tr>
                            <th width="200">Pengarang</th>
                            <td>: <?php echo $dataBuku[$i]["pengarang"]; ?></td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>: <?php echo $dataBuku[$i]["penerbit"]; ?></td>
                        </tr>
                        <tr>
                            <th>Tahun Terbit</th>
                            <td>: <?php echo $dataBuku[$i]["tahun_terbit"]; ?></td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>: Rp <?php echo number_format ($dataBuku[$i]["harga"], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>: <?php echo $dataBuku[$i]["stok"]; ?></td>
                        </tr>
                        <tr>
                            <th>ISBN</th>
                            <td>: <?php echo $dataBuku[$i]["isbn"]; ?></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: <?php echo $dataBuku[$i]["kategori"]; ?></td>
                        </tr>
                        <tr>
                            <th>Bahasa</th>
                            <td>: <?php echo $dataBuku[$i]["bahasa"]; ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Halaman</th>
                            <td>: <?php echo $dataBuku[$i]["jumlah_halaman"]; ?></td>
                        </tr>
                        <tr>
                            <th>Berat</th>
                            <td>: <?php echo $dataBuku[$i]["berat"]; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php }
         ?> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>