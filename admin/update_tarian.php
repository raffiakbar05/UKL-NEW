<?php
include '../koneksi.php';

if(isset($_POST['update'])) {
    $id_tarian = mysqli_real_escape_string($mysqli, $_POST['id_tarian']);
    $nama_tarian = mysqli_real_escape_string($mysqli, $_POST['nama_tarian']);
    $id_daerah = mysqli_real_escape_string($mysqli, $_POST['id_daerah']);
    $jenis_tarian = mysqli_real_escape_string($mysqli, $_POST['jenis_tarian']);
    $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi']);

    // Penanganan file gambar
    if(isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
        $gambar = mysqli_real_escape_string($mysqli, $_FILES['gambar']['name']);
        $gambar_tmp_nama = $_FILES['gambar']['tmp_name'];
        $gambar_folder = 'uploaded_img/' . $gambar;

        if (!file_exists('uploaded_img/')) {
            mkdir('uploaded_img/', 0777, true);
        }

        // Pindahkan file gambar ke folder tujuan
        if (move_uploaded_file($gambar_tmp_nama, $gambar_folder)) {
            // Update data termasuk gambar
            $query = "UPDATE tarian_adat SET nama_tarian='$nama_tarian', gambar='$gambar', id_daerah='$id_daerah', jenis_tarian='$jenis_tarian', deskripsi='$deskripsi' WHERE id_tarian=$id_tarian";
        } else {
            echo "Gagal mengunggah gambar.";
            exit();
        }
    } else {
        // Update data tanpa mengubah gambar
        $query = "UPDATE tarian_adat SET nama_tarian='$nama_tarian', id_daerah='$id_daerah', jenis_tarian='$jenis_tarian', deskripsi='$deskripsi' WHERE id_tarian=$id_tarian";
    }

    $result = mysqli_query($mysqli, $query);

    if($result) {
        echo "Data berhasil diperbarui.";
        header("Location: tarian.php"); // Redirect kembali ke halaman data user
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($mysqli);
    }
}

// Mendapatkan data user yang akan diupdate
if(isset($_GET['id'])) {
    $id_tarian = mysqli_real_escape_string($mysqli, $_GET['id']);

    $query = "SELECT tarian_adat.*, daerah.kota FROM tarian_adat 
              LEFT JOIN daerah ON tarian_adat.id_daerah = daerah.id_daerah 
              WHERE id_tarian=$id_tarian";
    $result = $mysqli->query($query);

    if($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data tarian tidak ditemukan.";
    }
} else {
    echo "ID tarian tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update tarian</title>
    <link rel="icon" type="image/png" href="img/logotitle.png">
    <link rel="stylesheet" href="styleupdate.css">
</head>
<body>
<div class="container">
    <header>
        <h1 class="title">Update tarian</h1>
    </header>
    <section class="form">
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id_tarian" value="<?php echo $data['id_tarian']; ?>">

            <label for="nama_tarian">Nama tarian</label><br>
            <input type="text" id="nama_tarian" name="nama_tarian" value="<?php echo $data['nama_tarian']; ?>" required><br>

            <label for="gambar">Gambar:</label><br>
            <input type="file" id="gambar" name="gambar"><br>
            <?php if ($data['gambar']) { ?>
                <img src="uploaded_img/<?php echo $data['gambar']; ?>" alt="gambar" width="100"><br>
            <?php } ?>

            <label for="id_daerah">Kota:</label><br>
            <select id="id_daerah" name="id_daerah" required>
                <option value="" disabled selected>Pilih Kota</option>
                <?php
                $query_daerah = "SELECT id_daerah, kota FROM daerah";
                $result_daerah = mysqli_query($mysqli, $query_daerah);
                while ($daerah = mysqli_fetch_assoc($result_daerah)) {
                    $selected = ($daerah['id_daerah'] == $data['id_daerah']) ? 'selected' : '';
                    echo '<option value="' . $daerah['id_daerah'] . '" ' . $selected . '>' . $daerah['kota'] . '</option>';
                }
                ?>
            </select><br>

            <label for="jenis_tarian">jenis tarian:</label><br>
            <input type="text" id="jenis_tarian" name="jenis_tarian" value="<?php echo $data['jenis_tarian']; ?>" required><br>

            <label for="deskripsi">Deskripsi:</label><br>
            <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $data['deskripsi']; ?>" required><br>

            <input type="submit" name="update" value="Update" class="button">
        </form>
    </section>
</div>
</body>
</html>
