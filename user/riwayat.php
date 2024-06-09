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

// Query untuk mendapatkan riwayat transaksi user
$id_user = $userData['id_user'];
$query_riwayat = "SELECT t.*, p.nama_pakaian, p.gambar 
                  FROM transaksi t 
                  JOIN pakaian_adat p ON t.id_pakaian = p.id_pakaian 
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
  <link rel="stylesheet" href="riwayatpakaian1.css">
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
    <h2>Riwayat Sewa Pakaian Adat</h2>
    <a href="pakaian adat.php" class="btn">Sewa Pakaian</a>
    <br>
    <div class="riwayat-grid">
      <?php
      if (mysqli_num_rows($result_riwayat) > 0) {
          while ($row = mysqli_fetch_assoc($result_riwayat)) {
              echo '<div class="riwayat-item">';
              echo '<div class="riwayat-img">';
              echo '<img src="../admin/uploaded_img/' . $row['gambar'] . '" alt="' . $row['nama_pakaian'] . '">';
              echo '</div>';
              echo '<div class="riwayat-info">';
              echo '<h3>' . $row['nama_pakaian'] . '</h3>';
              echo '<p>Jumlah: ' . $row['jumlah'] . '</p>';
              echo '<p>Total Pembelian: ' . $row['total_pembelian'] . '</p>';
              echo '<p>Waktu: ' . $row['waktu'] . '</p>';
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
