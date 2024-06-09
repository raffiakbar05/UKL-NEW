
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
    <h1 class="heading">Data Sewa Alat</h1>
    <br>
        <a href="../index.php" class="btn">Log Out</a>
        <br>
        <br>
        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Username</th>
                <th>Nama Alat</th>
                <th>Waktu</th>
                <th>Jumlah</th>
                <th>total pembelian</th>
                <th>Aksi</th>
            </tr>
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT pembelian.*, user.username, alat_musik.nama 
                                                  FROM pembelian 
                                                  JOIN user ON pembelian.id_user = user.id_user 
                                                  JOIN alat_musik ON pembelian.id_alat = alat_musik.id_alat") 
                                                  or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['waktu']; ?></td>
                <td><?php echo $data['jumlah']; ?></td>
                <td><?php echo $data['total_pembelian']; ?></td>
                <td><a href="hapus_sewaalat.php?id=<?php echo $data['id']; ?>" class="btn-hapus">Hapus</a></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <br>
    </section>
    

    <script src="main.js"></script>
</body>
</html>
