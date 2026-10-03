<?php
include 'koneksi.php';


$kode_param = $_GET['kode'] ?? '';

if (!empty($kode_param)) {
    try {
        $sql = "DELETE FROM mata_kuliah WHERE kode = :kode";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([':kode' => $kode_param]);
        header("Location: mata-kuliah.php");
        exit();

    } catch (PDOException $e) {
        die("Gagal menghapus data: " . $e->getMessage());
    }
} else {
    header("Location: mata-kuliah.php");
    exit();
}
?>