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

// Jika ada parameter id_pakaian pada URL
if(isset($_GET['id_pakaian'])) {
    $id_pakaian = $_GET['id_pakaian'];

    // Query untuk mendapatkan detail pakaian adat berdasarkan id_pakaian
    $query_pakaian = "SELECT * FROM pakaian_adat WHERE id_pakaian = '$id_pakaian'";
    $result_pakaian = mysqli_query($mysqli, $query_pakaian);
    $pakaianData = mysqli_fetch_assoc($result_pakaian);
} else {
    // Jika tidak ada id_pakaian, kembalikan ke halaman sebelumnya atau halaman lain
    header("Location: pakaian_adat.php");
    exit();
}

// Proses ketika tombol "Sewa Sekarang" ditekan
if(isset($_POST['submit'])) {
    // Ambil data dari formulir
    $id_user = $userData['id_user'];
    $id_pakaian = $_POST['id_pakaian'];
    $jumlah = $_POST['jumlah'];
    $harga = $pakaianData['harga']; // Ambil harga dari data pakaian
    $total_pembelian = $harga * $jumlah;

    // Insert data transaksi ke dalam tabel transaksi
    $query_insert = "INSERT INTO transaksi (id_user, id_pakaian, jumlah, total_pembelian) VALUES ('$id_user', '$id_pakaian', '$jumlah', '$total_pembelian')";
    $result_insert = mysqli_query($mysqli, $query_insert);

    if ($result_insert) {
        // Redirect ke halaman sewa.php jika transaksi berhasil
        header("Location: riwayat.php");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan dalam proses transaksi
        echo "Error: " . mysqli_error($mysqli);
    }
}

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sewa Pakaian Adat</title>
  <link rel="stylesheet" href="sewapakaian1.css">
  <script>
    function calculateTotal() {
        var harga = <?php echo $pakaianData['harga']; ?>; // Ambil harga dari PHP
        var jumlah = document.getElementById('jumlah').value;
        var total = harga * jumlah;
        document.getElementById('total_pembelian').value = total;
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Detail Pakaian Adat</h2>
    <div class="pakaian-detail">
      <img src="../admin/uploaded_img/<?php echo $pakaianData['gambar']; ?>" alt="<?php echo $pakaianData['nama_pakaian']; ?>">
      <h3><?php echo $pakaianData['nama_pakaian']; ?></h3>
      <p><?php echo $pakaianData['deskripsi']; ?></p>
      <h3>Harga: <?php echo $pakaianData['harga']; ?></h3>
      
      <!-- Form transaksi -->
      <form action="" method="post">
        <input type="hidden" name="id_user" value="<?php echo $userData['id_user']; ?>">
        <input type="text" name="username" value="<?php echo $userData['username']; ?>" readonly>
        <input type="hidden" name="id_pakaian" value="<?php echo $pakaianData['id_pakaian']; ?>">
        
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" min="1" required onchange="calculateTotal()">

        <label for="total_pembelian">Total Pembelian</label>
        <input type="text" id="total_pembelian" name="total_pembelian" readonly>

        <input type="submit" name="submit" value="Sewa Sekarang">
      </form>
    </div>
  </div>
</body>
</html>
