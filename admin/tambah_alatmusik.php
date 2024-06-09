<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Alat Musik</title>
    <link rel="stylesheet" href="../styleregister.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Tambah Alat Musik</h1><br>
        <form class="form" action="tambah_alatmusik.php" method="post" enctype="multipart/form-data">
            <label>Nama Alat musik:</label>
            <input type="text" name="nama" placeholder="Nama Alat Musik" required>

            <label>Harga:</label>
            <input type="text" name="nama" placeholder="Harga" required>

            <label>Tarian Yang Akan Diiringi:</label>
            <select name="nama_tarian" id="id_tarian" required>
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
            
            <label>Gambar:</label>
            <input type="file" id="gambar" name="gambar" required>

            <label>Jenis:</label>
            <input type="text" name="jenis" placeholder="Jenis" required>

            <label>Asal Daerah</label>
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

            <label>Deskripsi:</label>
            <input type="text" name="deskripsi" placeholder="Deskripsi" required>

            <button class="button" name="submit" type="submit">Tambah Alat Musik</button>
        </form>

        <?php
        // Include file koneksi, untuk menghubungkan ke database
        include "../koneksi.php";

        // Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Cek apakah ada kiriman form dari method POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = input($_POST["nama"]);
            $harga = input($_POST["harga"]);
            $nama_tarian = input($_POST["nama_tarian"]);
            $gambar = $_FILES['gambar']['name'];
            $gambar_tmp_nama = $_FILES['gambar']['tmp_name'];
            $gambar_folder = 'uploaded_img/' . $gambar;
            $jenis = input($_POST["jenis"]);
            $id_daerah = input($_POST["id_daerah"]); // Menyimpan id_daerah dari select option
            $deskripsi = input($_POST["deskripsi"]);

            // Validasi apakah direktori tujuan ada
            if (!file_exists('uploaded_img/')) {
                mkdir('uploaded_img/', 0777, true);
            }

            // Query untuk menginput data ke dalam tabel alat_musik
            $sql = "INSERT INTO alat_musik (id_tarian, id_daerah, nama, harga, gambar, jenis, deskripsi) VALUES ('$nama_tarian', '$id_daerah', '$nama', '$harga', '$gambar', '$jenis', '$deskripsi')";

            if (mysqli_query($mysqli, $sql)) {
                // Jika berhasil memasukkan data, pindahkan gambar ke folder yang ditentukan
                if (move_uploaded_file($gambar_tmp_nama, $gambar_folder)) {
                    echo "<div class='alert alert-success'> Data berhasil disimpan.</div>";
                    header("Location: alat_musik.php");
                } else {
                    echo "<div class='alert alert-danger'> Gagal mengunggah gambar.</div>";
                }
                // Kosongkan nilai input setelah pengiriman sukses
                $_POST = array();
            } else {
                echo "<div class='alert alert-danger'> Data Gagal disimpan. Error: " . mysqli_error($mysqli) . "</div>";
            }
        }
        ?>
    </div>
</body>
</html>
