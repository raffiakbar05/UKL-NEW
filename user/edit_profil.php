<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "user") {
    header("Location: ../login");
    exit();
}

// Menyertakan file koneksi database
include '../koneksi.php';

// Memastikan koneksi berhasil
if (!$mysqli) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mengambil data pengguna dari database berdasarkan sesi username
$username = $_SESSION['username'];
$query = "SELECT username, password, email FROM user WHERE username = '$username'";
$result = $mysqli->query($query);

// Memastikan query berhasil dijalankan
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Gagal mengambil data profil pengguna.";
    exit();
}

// Mengupdate data pengguna jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $new_email = $_POST['email'];

    $update_query = "UPDATE user SET username = '$new_username', password = '$new_password', email = '$new_email' WHERE username = '$username'";

    if ($mysqli->query($update_query) === TRUE) {
        $_SESSION['username'] = $new_username;  // Update session username jika diubah
        echo "Profil berhasil diperbarui.";
        header("Location: profil.php");  // Redirect ke halaman profil
        exit();
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>

    <link rel="stylesheet" href="edit_profil.css">

</head>


<boddy>
    <nav class="navbar">
        <a href="#home" class="navbar-logo">Sosial<span>Budaya</span>.</a>
        <div class="navbar-nav">
            <a href="web saya.php">Home</a>
            <a href="pakaian adat.php">Pakaian Adat</a>
            <a href="tarian adat.php">Tarian</a>
            <a href="alat musik.php">Alat musik</a>
            <a href="../index.php">Log Out</a>
        </div>
    </nav>
    <br><br><br><br><br><br>

    <div class="edit-profile-container">
        <h3>Edit Profil</h3>
        <form class="edit-profile-form" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <button type="submit">Update Profil</button>
        </form>
    </div>
</body>
</html>
<?php
// Close the connection
$mysqli->close();
?>
