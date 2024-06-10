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

// Jika ada parameter id_alat pada URL
if (isset($_GET['id_alat'])) {
    $id_alat = $_GET['id_alat'];

    // Query untuk mendapatkan detail alat musik berdasarkan id_alat
    $query_alatmusik = "SELECT * FROM alat_musik WHERE id_alat = '$id_alat'";
    $result_alatmusik = mysqli_query($mysqli, $query_alatmusik);
    $alatmusikData = mysqli_fetch_assoc($result_alatmusik);

    // Jika data alat musik tidak ditemukan, kembali ke halaman alat_musik.php
    if (!$alatmusikData) {
        header("Location: alat_musik.php");
        exit();
    }
} else {
    // Jika tidak ada id_alat, kembalikan ke halaman alat_musik.php
    header("Location: alat_musik.php");
    exit();
}

// Proses ketika tombol "Sewa Sekarang" ditekan
if (isset($_POST['submit'])) {
    // Ambil data dari formulir
    $id_user = $userData['id_user'];
    $id_alat = $_POST['id_alat'];
    $jumlah = $_POST['jumlah'];
    $harga = $alatmusikData['harga']; // Ambil harga dari data alat musik
    $total_pembelian = $harga * $jumlah;

    // Insert data transaksi ke dalam tabel transaksi
    $query_insert = "INSERT INTO pembelian (id_user, id_alat, jumlah, total_pembelian) VALUES ('$id_user', '$id_alat', '$jumlah', '$total_pembelian')";
    $result_insert = mysqli_query($mysqli, $query_insert);

    if ($result_insert) {
        // Redirect ke halaman riwayat.php jika transaksi berhasil
        header("Location: riwayatalat.php");
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
  <title>Sewa Alat Musik</title>
  <link rel="stylesheet" href="sewabaru.css">
  <script>
    function calculateTotal() {
        var harga = <?php echo $alatmusikData['harga']; ?>; // Ambil harga dari PHP
        var jumlah = document.getElementById('jumlah').value;
        var total = harga * jumlah;
        document.getElementById('total_pembelian').value = total;
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Detail Alat Musik</h2>
    <div class="alatmusik-detail">
      <img src="../admin/uploaded_img/<?php echo $alatmusikData['gambar']; ?>" alt="<?php echo $alatmusikData['nama']; ?>">
      <h3><?php echo $alatmusikData['nama']; ?></h3>
      <p><?php echo $alatmusikData['deskripsi']; ?></p>
      <h3>Harga: <?php echo $alatmusikData['harga']; ?></h3>
      
      <!-- Form transaksi -->
      <form action="" method="post">
        <input type="hidden" name="id_user" value="<?php echo $userData['id_user']; ?>">
        <input type="text" name="username" value="<?php echo $userData['username']; ?>" readonly>
        <input type="hidden" name="id_alat" value="<?php echo $alatmusikData['id_alat']; ?>">
        
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
