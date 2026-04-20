<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Registrasi Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <?php
        function sanitize($data) {
            return htmlspecialchars(trim($data));
        }

        $errors = [];
        $success = false;

        // keep value
        $nama = $email = $telepon = $alamat = $jk = $tgl = $pekerjaan = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nama = sanitize($_POST['nama'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $telepon = sanitize($_POST['telepon'] ?? '');
            $alamat = sanitize($_POST['alamat'] ?? '');
            $jk = sanitize($_POST['jk'] ?? '');
            $tgl = sanitize($_POST['tgl'] ?? '');
            $pekerjaan = sanitize($_POST['pekerjaan'] ?? '');

            // VALIDASI

            // Nama
            if (empty($nama)) {
                $errors['nama'] = "Nama wajib diisi";
            } elseif (strlen($nama) < 3) {
                $errors['nama'] = "Minimal 3 karakter";
            }

            // Email
            if (empty($email)) {
                $errors['email'] = "Email wajib diisi";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Format email tidak valid";
            }

            // Telepon
            if (empty($telepon)) {
                $errors['telepon'] = "Telepon wajib diisi";
            } elseif (!preg_match('/^08\d{8,11}$/', $telepon)) {
                $errors['telepon'] = "Format harus 08xxxxxxxxxx (10-13 digit)";
            }

            // Alamat
            if (empty($alamat)) {
                $errors['alamat'] = "Alamat wajib diisi";
            } elseif (strlen($alamat) < 10) {
                $errors['alamat'] = "Minimal 10 karakter";
            }

            // Jenis Kelamin
            if (empty($jk)) {
                $errors['jk'] = "Pilih jenis kelamin";
            }

            // Tanggal Lahir
            if (empty($tgl)) {
                $errors['tgl'] = "Tanggal lahir wajib diisi";
            } else {
                $birth = new DateTime($tgl);
                $today = new DateTime();
                $age = $today->diff($birth)->y;

                if ($age < 10) {
                    $errors['tgl'] = "Umur minimal 10 tahun";
                }
            }

            // Pekerjaan
            if (empty($pekerjaan)) {
                $errors['pekerjaan'] = "Pekerjaan wajib dipilih";
            }

            // SUCCESS
            if (count($errors) == 0) {
                $success = true;
            }
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Form Registrasi Anggota</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">

                            <!-- Nama -->
                            <div class="mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama"
                                    class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                                    value="<?= $nama ?>">
                                <div class="invalid-feedback"><?= $errors['nama'] ?? '' ?></div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" name="email"
                                    class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                    value="<?= $email ?>">
                                <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
                            </div>

                            <!-- Telepon -->
                            <div class="mb-3">
                                <label>Telepon</label>
                                <input type="text" name="telepon"
                                    class="form-control <?= isset($errors['telepon']) ? 'is-invalid' : '' ?>"
                                    value="<?= $telepon ?>">
                                <div class="invalid-feedback"><?= $errors['telepon'] ?? '' ?></div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label>Alamat</label>
                                <textarea name="alamat"
                                    class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>"><?= $alamat ?></textarea>
                                <div class="invalid-feedback"><?= $errors['alamat'] ?? '' ?></div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label>Jenis Kelamin</label><br>
                                <input type="radio" name="jk" value="Laki-laki" <?= ($jk == 'Laki-laki') ? 'checked' : '' ?>> Laki-laki
                                <input type="radio" name="jk" value="Perempuan" <?= ($jk == 'Perempuan') ? 'checked' : '' ?>> Perempuan
                                <div class="text-danger"><?= $errors['jk'] ?? '' ?></div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tgl"
                                    class="form-control <?= isset($errors['tgl']) ? 'is-invalid' : '' ?>"
                                    value="<?= $tgl ?>">
                                <div class="invalid-feedback"><?= $errors['tgl'] ?? '' ?></div>
                            </div>

                            <!-- Pekerjaan -->
                            <div class="mb-3">
                                <label>Pekerjaan</label>
                                <select name="pekerjaan"
                                    class="form-control <?= isset($errors['pekerjaan']) ? 'is-invalid' : '' ?>">
                                    <option value="">-- Pilih --</option>
                                    <option <?= $pekerjaan=='Pelajar'?'selected':'' ?>>Pelajar</option>
                                    <option <?= $pekerjaan=='Mahasiswa'?'selected':'' ?>>Mahasiswa</option>
                                    <option <?= $pekerjaan=='Pegawai'?'selected':'' ?>>Pegawai</option>
                                    <option <?= $pekerjaan=='Lainnya'?'selected':'' ?>>Lainnya</option>
                                </select>
                                <div class="invalid-feedback"><?= $errors['pekerjaan'] ?? '' ?></div>
                            </div>
                            <button class="btn btn-primary w-100">Daftar</button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- OUTPUT -->
            <div class="col-md-6">
                <?php if ($success): ?>
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        Registrasi Berhasil
                    </div>
                    <div class="card-body">
                        <p><b>Nama:</b> <?= $nama ?></p>
                        <p><b>Email:</b> <?= $email ?></p>
                        <p><b>Telepon:</b> <?= $telepon ?></p>
                        <p><b>Alamat:</b> <?= $alamat ?></p>
                        <p><b>Jenis Kelamin:</b> <?= $jk ?></p>
                        <p><b>Tanggal Lahir:</b> <?= $tgl ?></p>
                        <p><b>Pekerjaan:</b> <?= $pekerjaan ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>