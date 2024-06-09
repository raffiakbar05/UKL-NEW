<?php
include '../koneksi.php';

if(isset($_POST['update'])) {
    $id_pakaian = mysqli_real_escape_string($mysqli, $_POST['id_pakaian']);
    $nama_pakaian = mysqli_real_escape_string($mysqli, $_POST['nama_pakaian']);
    $id_daerah = mysqli_real_escape_string($mysqli, $_POST['id_daerah']);
    $aksesoris_pakaian = mysqli_real_escape_string($mysqli, $_POST['aksesoris_pakaian']);
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
            $query = "UPDATE pakaian_adat SET nama_pakaian='$nama_pakaian', gambar='$gambar', id_daerah='$id_daerah', aksesoris_pakaian='$aksesoris_pakaian', deskripsi='$deskripsi' WHERE id_pakaian=$id_pakaian";
        } else {
            echo "Gagal mengunggah gambar.";
            exit();
        }
    } else {
        // Update data tanpa mengubah gambar
        $query = "UPDATE pakaian_adat SET nama_pakaian='$nama_pakaian', id_daerah='$id_daerah', aksesoris_pakaian='$aksesoris_pakaian', deskripsi='$deskripsi' WHERE id_pakaian=$id_pakaian";
    }

    $result = mysqli_query($mysqli, $query);

    if($result) {
        echo "Data berhasil diperbarui.";
        header("Location: pakaian_adat.php"); // Redirect kembali ke halaman data user
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($mysqli);
    }
}

// Mendapatkan data user yang akan diupdate
if(isset($_GET['id'])) {
    $id_pakaian = mysqli_real_escape_string($mysqli, $_GET['id']);

    $query = "SELECT pakaian_adat.*, daerah.kota FROM pakaian_adat 
              LEFT JOIN daerah ON pakaian_adat.id_daerah = daerah.id_daerah 
              WHERE id_pakaian=$id_pakaian";
    $result = $mysqli->query($query);

    if($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data pakaian tidak ditemukan.";
    }
} else {
    echo "ID pakaian tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Pakaian</title>
    <link rel="icon" type="image/png" href="img/logotitle.png">
    <link rel="stylesheet" href="styleupdate.css">
</head>
<body>
<div class="container">
    <header>
        <h1 class="title">Update Pakaian</h1>
    </header>
    <section class="form">
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id_pakaian" value="<?php echo $data['id_pakaian']; ?>">

            <label for="nama_pakaian">Nama Pakaian</label><br>
            <input type="text" id="nama_pakaian" name="nama_pakaian" value="<?php echo $data['nama_pakaian']; ?>" required><br>

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

            <label for="aksesoris_pakaian">Aksesoris Pakaian:</label><br>
            <input type="text" id="aksesoris_pakaian" name="aksesoris_pakaian" value="<?php echo $data['aksesoris_pakaian']; ?>" required><br>

            <label for="deskripsi">Deskripsi:</label><br>
            <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $data['deskripsi']; ?>" required><br>

            <input type="submit" name="update" value="Update" class="button">
        </form>
    </section>
</div>
</body>
</html>
