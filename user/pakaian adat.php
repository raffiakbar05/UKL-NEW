<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';
$username = $_SESSION['username'];

$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

$userData = mysqli_fetch_assoc($result);

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kultural</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet" />

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <link rel="stylesheet" href="pakaianadat.css" />

</head>

<body>
  <nav class="navbar">
    <a href="#home" class="navbar-logo">Sosial<span>Budaya</span>.</a> 
    <div class="navbar-nav">
        <a href="web saya.php">Home</a>
        <a href="pakaian adat.php">Pakaian Adat</a>
        <a href="tarian adat.php">Tarian</a>
        <a href="alat musik.php">Alat musik</a>
        <a href="riwayat.php">Riwayat</a>
        <a href="profil.php">Profil</a>
      </div>
  </nav>

  <br><br><br>

  <section id="tarian" class="menu">
    <h2><span>Pakaian</span> Adat</h2>

    <div class="row2">
      <?php
      include '../koneksi.php';
      $query_mysql = mysqli_query($mysqli, "SELECT * FROM pakaian_adat") or die(mysqli_error($mysqli));
      while($data = mysqli_fetch_array($query_mysql)) { 
      ?>
      <div class="menu-card">
        <img src="../admin/uploaded_img/<?php echo $data['gambar']; ?>" alt="100">
        <h3 class="menu-card-title"><?php echo $data['deskripsi'];?> </h3>
        <!-- Perhatikan bagian ini: -->
        <button class="button"><a href="sewa.php?id_pakaian=<?php echo $data['id_pakaian'];?>">Sewa</a></button>
      </div>
      <?php } ?>
    </div>
  </section>

  <footer>
    <div class="credit">
      <p>Created by <a href="">Raffi Akbar</a>. | &copy; 2023.</p>
    </div>
  </footer>

  <script>
    feather.replace();
  </script>
</body>
</html>
