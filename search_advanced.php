<?php
// DATA 
$buku_list = [
    ["kode"=>"BK-001","judul"=>"Belajar PHP Dasar","kategori"=>"Programming","pengarang"=>"Budi","penerbit"=>"Informatika","tahun"=>2023,"harga"=>75000,"stok"=>10],
    ["kode"=>"BK-002","judul"=>"Laravel Advanced","kategori"=>"Programming","pengarang"=>"Siti","penerbit"=>"Informatika","tahun"=>2024,"harga"=>120000,"stok"=>5],
    ["kode"=>"BK-003","judul"=>"MySQL Expert","kategori"=>"Database","pengarang"=>"Andi","penerbit"=>"Erlangga","tahun"=>2022,"harga"=>90000,"stok"=>0],
    ["kode"=>"BK-004","judul"=>"UI UX Design","kategori"=>"Web Design","pengarang"=>"Rina","penerbit"=>"Andi","tahun"=>2023,"harga"=>85000,"stok"=>7],
    ["kode"=>"BK-005","judul"=>"Networking Basics","kategori"=>"Networking","pengarang"=>"Dedi","penerbit"=>"Gramedia","tahun"=>2021,"harga"=>95000,"stok"=>2],
    ["kode"=>"BK-006","judul"=>"JavaScript Modern","kategori"=>"Programming","pengarang"=>"Siti","penerbit"=>"Informatika","tahun"=>2024,"harga"=>100000,"stok"=>0],
    ["kode"=>"BK-007","judul"=>"PostgreSQL Guide","kategori"=>"Database","pengarang"=>"Ahmad","penerbit"=>"Erlangga","tahun"=>2023,"harga"=>110000,"stok"=>4],
    ["kode"=>"BK-008","judul"=>"HTML CSS Mastery","kategori"=>"Web Design","pengarang"=>"Budi","penerbit"=>"Andi","tahun"=>2022,"harga"=>80000,"stok"=>6],
    ["kode"=>"BK-009","judul"=>"Cyber Security","kategori"=>"Networking","pengarang"=>"Rina","penerbit"=>"Gramedia","tahun"=>2024,"harga"=>130000,"stok"=>3],
    ["kode"=>"BK-010","judul"=>"PHP OOP","kategori"=>"Programming","pengarang"=>"Andi","penerbit"=>"Informatika","tahun"=>2023,"harga"=>95000,"stok"=>8],
];

// GET PARAM 
$keyword   = $_GET['keyword'] ?? '';
$kategori  = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun     = $_GET['tahun'] ?? '';
$status    = $_GET['status'] ?? 'semua';
$sort      = $_GET['sort'] ?? 'judul';
$page      = $_GET['page'] ?? 1;

// VALIDASI 
$errors = [];

if ($min_harga && $max_harga && $min_harga > $max_harga) {
    $errors[] = "Harga minimum tidak boleh lebih besar dari maksimum";
}

if ($tahun && ($tahun < 1900 || $tahun > date('Y'))) {
    $errors[] = "Tahun tidak valid";
}

// FILTER 
$hasil = [];

foreach ($buku_list as $buku) {
    $match = true;

    if ($keyword) {
        if (stripos($buku['judul'], $keyword) === false &&
            stripos($buku['pengarang'], $keyword) === false) {
            $match = false;
        }
    }

    if ($kategori && $buku['kategori'] != $kategori) $match = false;
    if ($min_harga && $buku['harga'] < $min_harga) $match = false;
    if ($max_harga && $buku['harga'] > $max_harga) $match = false;
    if ($tahun && $buku['tahun'] != $tahun) $match = false;

    if ($status == 'tersedia' && $buku['stok'] <= 0) $match = false;
    if ($status == 'habis' && $buku['stok'] > 0) $match = false;

    if ($match) $hasil[] = $buku;
}

// SORTING 
usort($hasil, function($a, $b) use ($sort) {
    return $a[$sort] <=> $b[$sort];
});

// PAGINATION 
$per_page = 10;
$total = count($hasil);
$total_pages = ceil($total / $per_page);
$start = ($page - 1) * $per_page;
$hasil = array_slice($hasil, $start, $per_page);

// HIGHLIGHT 
function highlight($text, $keyword) {
    if (!$keyword) return $text;
    return preg_replace("/($keyword)/i", "<mark>$1</mark>", $text);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Advanced</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Search Buku Advanced</h2>

<!-- ERROR -->
<?php if ($errors): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $e) echo "<div>$e</div>"; ?>
</div>
<?php endif; ?>

<!-- FORM -->
<form method="GET" class="row g-2 mb-3">
    <input class="form-control col" name="keyword" placeholder="Keyword" value="<?= $keyword ?>">
    
    <select name="kategori" class="form-select col">
        <option value="">Semua</option>
        <option <?= $kategori=='Programming'?'selected':'' ?>>Programming</option>
        <option <?= $kategori=='Database'?'selected':'' ?>>Database</option>
        <option <?= $kategori=='Web Design'?'selected':'' ?>>Web Design</option>
        <option <?= $kategori=='Networking'?'selected':'' ?>>Networking</option>
    </select>

    <input type="number" name="min_harga" placeholder="Min" class="form-control" value="<?= $min_harga ?>">
    <input type="number" name="max_harga" placeholder="Max" class="form-control" value="<?= $max_harga ?>">
    <input type="number" name="tahun" placeholder="Tahun" class="form-control" value="<?= $tahun ?>">

    <select name="status" class="form-select">
        <option value="semua">Semua</option>
        <option value="tersedia" <?= $status=='tersedia'?'selected':'' ?>>Tersedia</option>
        <option value="habis" <?= $status=='habis'?'selected':'' ?>>Habis</option>
    </select>

    <select name="sort" class="form-select">
        <option value="judul">Judul</option>
        <option value="harga">Harga</option>
        <option value="tahun">Tahun</option>
    </select>

    <button class="btn btn-primary">Cari</button>
</form>

<!-- HASIL -->
<h5>Total: <?= $total ?> buku</h5>

<table class="table table-bordered">
<tr>
    <th>Kode</th>
    <th>Judul</th>
    <th>Kategori</th>
    <th>Pengarang</th>
    <th>Tahun</th>
    <th>Harga</th>
    <th>Stok</th>
</tr>

<?php foreach ($hasil as $b): ?>
<tr>
    <td><?= $b['kode'] ?></td>
    <td><?= highlight($b['judul'], $keyword) ?></td>
    <td><?= $b['kategori'] ?></td>
    <td><?= highlight($b['pengarang'], $keyword) ?></td>
    <td><?= $b['tahun'] ?></td>
    <td>Rp <?= number_format($b['harga'],0,',','.') ?></td>
    <td><?= $b['stok'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- PAGINATION -->
<nav>
<?php for ($i=1; $i<=$total_pages; $i++): ?>
    <a href="?<?= http_build_query(array_merge($_GET,['page'=>$i])) ?>" 
       class="btn btn-sm <?= $i==$page?'btn-primary':'btn-secondary' ?>">
       <?= $i ?>
    </a>
<?php endfor; ?>
</nav>

</body>
</html>