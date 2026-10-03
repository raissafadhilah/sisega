<?php
include 'koneksi.php';

$error_message = '';
$succes_message = '';

$kode_param = $_GET['kode'] ?? '';
if (empty($kode_param)) {
    header("Location: mata-kuliah.php");
    exit();
}   
try {
    $stmt = $koneksi->prepare("SELECT * FROM mata_kuliah WHERE kode = :kode");
    $stmt->execute([':kode' => $kode_param]);
    $mata_kuliah = $stmt->fetch();

    if (!$mata_kuliah) {
        header("Location: mata-kuliah.php");
        exit();
    }
} catch (PDOException $e) {
    die("Gagal mengambil data: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode     = trim($_POST['kode'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $semester = $_POST['semester'] ?? '';
    $sks      = $_POST['sks'] ?? '';

    if (!empty($kode) && !empty($nama) && !empty($semester)) {
        try {
            $sql  = "UPDATE mata_kuliah SET kode = :kode, nama = :nama, semester = :semester, sks = :sks WHERE kode = :old_kode";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute([
                ':kode'     => $kode,
                ':nama'     => $nama,
                ':semester' => (int)$semester,
                ':sks'      => !empty($sks) ? (int)$sks : null,
                ':old_kode' => $mata_kuliah['kode']
            ]);

            header("Location: mata-kuliah.php");
            exit();
        } catch (PDOException $e) {
            $error_message = "Gagal memperbarui data: " . $e->getMessage();
        }
    } else {
        $error_message = "Kode, Nama, dan Semester wajib diisi!";
    }
} else {    
    $kode     = $mata_kuliah['kode'];
    $nama     = $mata_kuliah['nama'];
    $semester = $mata_kuliah['semester'];
    $sks      = $mata_kuliah['sks'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Edit Mata Kuliah</h1>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="kode" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="kode" name="kode" value="<?= htmlspecialchars($kode); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($nama); ?>" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <input type="number" class="form-control" id="semester" name="semester" value="<?= htmlspecialchars($semester); ?>" required>
            </div>
            <div class="mb-3">
                <label for="sks" class="form-label">SKS</label>
                <input type="number" class="form-control" id="sks" name="sks" value="<?= htmlspecialchars($sks); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="mata-kuliah.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>