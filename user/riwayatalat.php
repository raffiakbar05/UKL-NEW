<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

// Ambil data user dari sesi
$username = $_SESSION['username'];
$query_user = "SELECT * FROM user WHERE username = '$username'";
$result_user = mysqli_query($mysqli, $query_user);
$userData = mysqli_fetch_assoc($result_user);

// Pastikan userData berhasil diambil
if (!$userData) {
    die("User data not found: " . mysqli_error($mysqli));
}

// Query untuk mendapatkan riwayat transaksi user
$id_user = $userData['id_user'];
$query_riwayat = "SELECT t.*, a.nama, a.gambar 
                  FROM pembelian t
                  JOIN alat_musik a ON t.id_alat = a.id_alat 
                  WHERE t.id_user = '$id_user'
                  ORDER BY t.waktu DESC";
$result_riwayat = mysqli_query($mysqli, $query_riwayat);

if (!$result_riwayat) {
    die("Query failed: " . mysqli_error($mysqli));
}

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Sewa</title>
  <link rel="stylesheet" href="riwayatalat1.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-nav">
        <a href="riwayat.php">Riwayat Sewa Pakaian</a>
        <a href="riwayatalat.php">Riwayat Sewa Alat</a>
        <a href="profil.php">Profil</a>
    </div>
</nav>

<div class="container">
  <h2>Riwayat Sewa Alat Musik</h2>
  <a href="alat musik.php" class="btn">Sewa Alat Musik</a>
  <br>
  <div class="riwayat-grid">
    <?php
    if (mysqli_num_rows($result_riwayat) > 0) {
        while ($row = mysqli_fetch_assoc($result_riwayat)) {
            echo '<div class="riwayatalat-item">';
            echo '<div class="riwayatalat-img">';
            echo '<img src="../admin/uploaded_img/' . htmlspecialchars($row['gambar']) . '" alt="' . htmlspecialchars($row['nama']) . '">';
            echo '</div>';
            echo '<div class="riwayatalat-info">';
            echo '<h3>' . htmlspecialchars($row['nama']) . '</h3>';
            echo '<p>Jumlah: ' . htmlspecialchars($row['jumlah']) . '</p>';
            echo '<p>Total Pembelian: ' . htmlspecialchars($row['total_pembelian']) . '</p>';
            echo '<p>Waktu: ' . htmlspecialchars($row['waktu']) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Tidak ada riwayat sewa.</p>';
    }
    ?>
  </div>
</div>
</body>
</html>
