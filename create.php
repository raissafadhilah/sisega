<?php
include 'koneksi.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode     = trim($_POST['kode'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $semester = $_POST['semester'] ?? '';
    $sks      = $_POST['sks'] ?? '';

    if (!empty($kode) && !empty($nama) && !empty($semester)) {
        try {
           
            $sql  = "INSERT INTO mata_kuliah (kode, nama, semester, sks) VALUES (:kode, :nama, :semester, :sks)";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute([
                ':kode'     => $kode,
                ':nama'     => $nama,
                ':semester' => (int)$semester,
                ':sks'      => !empty($sks) ? (int)$sks : null
            ]);

            header("Location: mata-kuliah.php");
            exit();
        } catch (PDOException $e) {
            $error_message = "Gagal menyimpan data: " . $e->getMessage();
        }
    } else {
        $error_message = "Kode, Nama, dan Semester wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Tambah Mata Kuliah</h1>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="kode" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="kode" name="kode" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <input type="number" class="form-control" id="semester" name="semester" min="1" max="14" required>
            </div>
            <div class="mb-3">
                <label for="sks" class="form-label">SKS</label>
                <input type="number" class="form-control" id="sks" name="sks" min="1">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="mata-kuliah.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>