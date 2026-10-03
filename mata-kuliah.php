<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="mata-kuliah.php">Mata Kuliah</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <h1>Daftar Mata Kuliah</h1>
        <a href="create.php" class="btn btn-primary mb-3">Tambah Mata Kuliah</a>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">      
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kode Mata Kuliah</th>
                            <th scope="col">Nama Mata Kuliah</th>
                            <th scope="col">Semester</th>
                            <th scope="col">SKS</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'koneksi.php';
                            try {
                                    $stmt = $koneksi->query("SELECT * FROM mata_kuliah");
                                    $data = $stmt->fetchAll();

                                    if (count($data) > 0) {
                                        $no = 1;
                                        // loop menampilkan data mata kuliah
                                        foreach ($data as $row) {
                                            echo "<tr>";
                                            echo "<th scope='row'>" . $no++ . "</th>";
                                            echo "<td>" . htmlspecialchars($row['kode']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sks'] ?? '-') . "</td>";
                                            
                                            echo "<td class='text-center'>
                                                    <a href='edit.php?kode=" . urlencode($row['kode']) . "' class='btn btn-warning btn-sm'>Edit</a>
                                                    <a href='delete.php?kode=" . urlencode($row['kode']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>Tidak ada data mata kuliah.</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='6' class='text-center text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                                }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>