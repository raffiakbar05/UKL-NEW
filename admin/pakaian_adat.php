

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
        <a href="user.php">User</a>
        <a href="pakaian_adat.php">Pakaian Adat</a>
        <a href="tarian.php">Tarian</a>
        <a href="alat_musik.php">Alat Musik</a>
        <a href="sewa.php">Sewa</a>
        <a href="profil.php">profil</a>
        <a href="sewa.php">Sewa Pakaian</a>
        <a href="sewaalat.php">Sewa Alat</a>
    </div>
        
    <section class="user">
    <h1 class="heading">Data Pakaian Adat</h1>

    <div class="button-container">
        <a href="tambah_pakaian.php" class="btn tambah-user">Tambah Pakaian</a>
        <a href="../index.php" class="btn logout">Log Out</a>
    </div>

        <br>
        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Nama Pakaian</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Kota</th>
                <th>Aksesoris Pakaian</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
                <th>Aksi</th>

            </tr>
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT pakaian_adat.*, daerah.kota 
                                                  FROM pakaian_adat 
                                                  JOIN daerah ON pakaian_adat.id_daerah = daerah.id_daerah") 
                                                  or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['nama_pakaian']; ?></td>
                <td><?php echo $data['harga']; ?></td>
                <td><img src="uploaded_img/<?php echo $data['gambar']; ?>" alt="" width="100"></td>
                <td><?php echo $data['kota']; ?></td>
                <td><?php echo $data['aksesoris_pakaian']; ?></td>
                <td><?php echo $data['deskripsi']; ?></td>
                <td><a href="hapus_pakaian.php?id=<?php echo $data['id_pakaian']; ?>" class="btn-hapus">Hapus</a></td>
                <td><a href="update_pakaian.php?id=<?php echo $data['id_pakaian']; ?>" class="btn-update">Update</a></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <br>
    </section>
    

    <script src="main.js"></script>
</body>
</html>