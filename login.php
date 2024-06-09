<?php
session_start();
include 'koneksi.php';

$username = $_POST['Username'];
$password = $_POST['Password'];

$login = mysqli_query($mysqli, "SELECT * FROM user WHERE username='$username' AND password='$password'");

// Periksa apakah query berhasil dieksekusi
if ($login) {
    $cek = mysqli_num_rows($login);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($login);

        if ($data['level'] == "admin") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "admin";
            header("Location: admin/user.php");
        } else if ($data['level'] == "user") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "user";
            header("Location: user/web saya.php");
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: index.php?pesan=gagal");
    }
} else {
    // Tampilkan pesan error jika query tidak berhasil dieksekusi
    echo "Error: " . mysqli_error($mysqli);
}
?>