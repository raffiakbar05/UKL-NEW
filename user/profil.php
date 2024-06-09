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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>

    <link rel="stylesheet" href="profil.css">

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
<br><br><br><br><br><br><br>
    <div class="profile-container">
        
        <div class="profile-info">
            <h3>Profil Pengguna</h3>
            <table class="user-table">
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($userData['username']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($userData['email']); ?></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><?php echo htmlspecialchars($userData['password']); ?></td>
                </tr>
            </table>
        </div>
        <a href="edit_profil.php" class="edit-button">Edit Profil</a>
        <a href="../index.php" class="logout-button">Log out</a>
    </div>

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
<?php
