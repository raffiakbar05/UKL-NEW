<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data USER</title>
    
    <link rel="stylesheet" href="styleadmin.css">
</head>
<body>
    <div class="navbar">
        <a href="user.php">user</a>
        <a href="pakaian_adat.php">Pakaian adat</a>
        <a href="tarian.php">Tarian</a>
        <a href="alat_musik.php">Alat musik</a>
        <a href="sewa.php">Sewa Pakaian</a>
        <a href="sewaalat.php">Sewa Alat</a>
</div>
        
    <section class="user">
    <h1 class="heading">Data User</h1>

 <div class="button-container">
    <a href="tambah_user.php" class="btn">Tambah User</a>
    <a href="../index.php" class="btn logout">Log Out</a>
</div>

        <br>
        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Level</th>
                <th>Action</th> <!-- Membuat kolom data user -->
                <th>Action</th> <!-- Membuat kolom  data user-->
            </tr>
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT * FROM user") or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['password']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['level']; ?></td>
                <td><a href="hapususer.php?id=<?php echo $data['id_user']; ?>" class="btn-hapus">Hapus</a> <!-- Tombol hapus --></td>
                <td><a href="updateuser.php?id=<?php echo $data['id_user']; ?>" class="btn-update">Update</a> <!-- Tombol update --></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <br>
   
    </section>
    

    <script src="main.js"></script>
</body>
</html>