<?php
include '../koneksi.php';

$id_alat = $_GET['id']; // Ambil id user dari parameter URL

// Hapus data user dari database
$hapus = mysqli_query($mysqli, "DELETE FROM pembelian WHERE id = '$id_alat'") or die(mysqli_error($mysqli));

if($hapus) {
    // Redirect kembali ke halaman user.php setelah berhasil menghapus
    header("location:sewaalat.php");
    exit();
} else {
    echo "Gagal menghapus user.";
}
?>