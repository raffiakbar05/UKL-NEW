<?php
include '../koneksi.php';

if (isset($_POST['update'])) {
    $id_alat = mysqli_real_escape_string($mysqli, $_POST['id_alat']);
    $id_tarian = mysqli_real_escape_string($mysqli, $_POST['id_tarian']);
    $id_daerah = mysqli_real_escape_string($mysqli, $_POST['id_daerah']);
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
    $jenis = mysqli_real_escape_string($mysqli, $_POST['jenis']);
    $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi']);

    // Penanganan file gambar
    if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
        $gambar = mysqli_real_escape_string($mysqli, $_FILES['gambar']['name']);
        $gambar_tmp_nama = $_FILES['gambar']['tmp_name'];
        $gambar_folder = 'uploaded_img/' . $gambar;

        if (!file_exists('uploaded_img/')) {
            mkdir('uploaded_img/', 0777, true);
        }

        // Pindahkan file gambar ke folder tujuan
        if (move_uploaded_file($gambar_tmp_nama, $gambar_folder)) {
            // Update data termasuk gambar
            $query = "UPDATE alat_musik SET nama='$nama', id_tarian='$id_tarian',id_daerah='$id_daerah', gambar='$gambar', jenis='$jenis', deskripsi='$deskripsi' WHERE id=$id";
        } else {
            echo "Gagal mengunggah gambar.";
            exit();
        }
    } else {
        // Update data tanpa mengubah gambar
        $query = "UPDATE alat_musik SET nama='$nama', id_tarian='$id_tarian',id_daerah='$id_daerah', jenis='$jenis', deskripsi='$deskripsi' WHERE id=$id";
    }

    $result = mysqli_query($mysqli, $query);

    if ($result) {
        echo "Data berhasil diperbarui.";
        header("Location: alat_musik.php"); // Redirect kembali ke halaman data alat musik
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($mysqli);
    }
}

// Mendapatkan data alat musik yang akan diupdate
if (isset($_GET['id'])) {
    $id_alat = mysqli_real_escape_string($mysqli, $_GET['id']);

    $query = "SELECT * FROM alat_musik WHERE id_alat=$id_alat";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data alat musik tidak ditemukan.";
        exit();
    }
} else {
    echo "ID alat musik tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Alat Musik</title>
    <link rel="icon" type="image/png" href="img/logotitle.png">
    <link rel="stylesheet" href="styleupdate.css">
</head>
<body>
<div class="container">
    <header>
        <h1 class="title">Update Alat Musik</h1>
    </header>
    <section class="form">
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $data['id_alat']; ?>">

            <label for="nama">Nama </label><br>
            <input type="text" id="nama" name="nama" value="<?php echo $data['nama']; ?>"><br>

            <label for="id_tarian">Tarian Yang Diiringi </label><br>
            <select name="id_tarian" id="id_tarian" required>
                <option disabled selected>Pilih</option>
                <?php
                // Koneksi ke database
                $databaseHost = "localhost";
                $databaseName = "budaya";
                $databaseUsername = "root";
                $databasePassword = "";

                $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

                // Periksa koneksi
                if (mysqli_connect_errno()) {
                    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
                    exit();
                }

                // Query untuk mendapatkan data provinsi dan kota dari tabel daerah
                $query = "SELECT * FROM tarian_adat";
                $result = mysqli_query($mysqli, $query);

                // Buat elemen select untuk provinsi dan kota
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_tarian'] . '">' . $row['nama_tarian'] . '</option>';
                }

                // Tutup koneksi
                mysqli_close($mysqli);
                ?>
            </select>
            <br>

            <label for="gambar">Gambar </label><br>
            <input type="file" id="gambar" name="gambar"><br>

            <label for="id_daerah">Kota </label><br>
            <select name="id_daerah" id="id_daerah" required>
                <option disabled selected>Pilih</option>
                <?php
                // Koneksi ke database
                $databaseHost = "localhost";
                $databaseName = "budaya";
                $databaseUsername = "root";
                $databasePassword = "";

                $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

                // Periksa koneksi
                if (mysqli_connect_errno()) {
                    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
                    exit();
                }

                // Query untuk mendapatkan data provinsi dan kota dari tabel daerah
                $query = "SELECT * FROM daerah";
                $result = mysqli_query($mysqli, $query);

                // Buat elemen select untuk provinsi dan kota
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_daerah'] . '">' . $row['kota'] . '</option>';
                }

                // Tutup koneksi
                mysqli_close($mysqli);
                ?>
            </select>
            <br>

            <label for="jenis">Jenis</label><br>
            <input type="text" id="jenis" name="jenis" value="<?php echo $data['jenis']; ?>"><br>

            <label for="deskripsi">Deskripsi </label><br>
            <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $data['deskripsi']; ?>"><br>

            <input type="submit" name="update" value="Update" class="button">
        </form>
    </section>
</div>

</body>
</html>
