<?php
include '../koneksi.php';

$id_tarian = $_GET['id']; // Ambil id user dari parameter URL

// Hapus data terkait di tabel alat_musik terlebih dahulu
$hapusTerkait = mysqli_query($mysqli, "DELETE FROM alat_musik WHERE id_tarian = '$id_tarian'") or die(mysqli_error($mysqli));

if($hapusTerkait) {
    // Hapus data user dari database
    $hapus = mysqli_query($mysqli, "DELETE FROM tarian_adat WHERE id_tarian = '$id_tarian'") or die(mysqli_error($mysqli));

    if($hapus) {
        // Redirect kembali ke halaman user.php setelah berhasil menghapus
        header("location:tarian.php");
        exit();
    } else {
        echo "Gagal menghapus tarian.";
    }
} else {
    echo "Gagal menghapus data terkait.";
}
?>
