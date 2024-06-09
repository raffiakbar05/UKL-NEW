<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah User </title>
    <link rel="stylesheet" href="../styleregister.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Tambah User</h1><br>
        <form class="form" action="tambah_user.php" method="post">
            <input type="email" name="email" placeholder="Email"> 
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button class="button" name="sumbit" type="submit">Tambah User</button>
            <?php
            if(isset($_POST['sumbit'])){
                $email= $_POST['email'];
                $username= $_POST['username'];
                $password= $_POST['password'];
                $level='user';

                include_once("koneksi.php");

                $result = mysqli_query($mysqli,
                "INSERT INTO user(email,username,password,level) VALUES ('$email','$username','$password','user')");

                header("location: user.php");
            }
            ?>
        </form>
        <div class="forgot">
            <p>Do you have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>