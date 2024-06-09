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
    <title>kultural</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->

    <link rel="stylesheet" href= "web_saya.css">
  </head>

  <body>
    <!-- Navbar start -->
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
    <!-- Navbar end -->

    <!-- Hero Section start -->
    <section class="hero" id="home">
      <main class="content">
        <h1>Keberagaman <span>Sosial Budaya</span></h1>
        <a href="pakaian adat.php" class="cta">Lihat</a>
      </main>
    </section>
    <!-- Hero Section end -->


    <!-- Footer start -->
    <footer>

      <div class="credit">
        <p>Created by <a href="">Raffi Akbar</a>. | &copy; 2023.</p>
      </div>
    </footer>
    
    <!-- Footer end -->

    <!-- Feather Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Javascript -->
    <script src="js/script.js"></script>
  </body>
</html>
