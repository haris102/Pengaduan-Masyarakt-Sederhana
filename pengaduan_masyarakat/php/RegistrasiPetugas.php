<?php 
include 'functions.php';

// jika tidak ada $_SESSION['login'] maka arahkan ke login.php
if(isset($_SESSION['login'])) {
    header("Location: table.php");
}

// jika tombol regist di tekan
if(isset($_POST['regist'])) {
    if(registrasi($_POST) > 0 ) {
        echo "<script>
            alert('petugas baru berhasil mendaftar!');
        </script>";
    } else {
        echo "<script>
            alert('petugas baru gagal mendaftar!');
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi Petugas</title>
    <link rel="stylesheet" href="../css/registrasi.css">
</head>
<body>
    <div class="container">
        <h2>Sign Up Petugas</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <!-- <td><label for="nama">Nama </label></td> -->
                    <td><input type="text" name="name" id="nama" placeholder="Nama" autocomplete="off"></td>
                </tr>
                <tr>
                    <!-- <td><label for="telp">No Telp </label></td> -->
                    <td><input type="tel" name="telp" id="telp" placeholder="Telp" autocomplete="off"></td>
                </tr>
                <tr>
                    <!-- <td><label for="email">Email </label></td> -->
                    <td><input type="email" name="email" id="email" placeholder="Email" autocomplete="off">></td>
                </tr>
                <tr>
                    <!-- <td><label for="password">Password </label></td> -->
                    <td><input type="password" name="password" id="password" placeholder="Password" autocomplete="off"></td>
                </tr>
                <tr>
                    <!-- <td><label for="password2">Konfirmasi Password </label></td> -->
                    <td><input type="password" name="password2" id="password2" placeholder="Konfirmasi Password" autocomplete="off"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" name="regist">Regist!</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>