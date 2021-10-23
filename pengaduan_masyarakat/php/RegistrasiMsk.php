<?php 
include 'functions.php';


// jika ada tombol kirim
if(isset($_POST['kirim'])) {
    // $nik = $_POST['nik_msk'];
    // panggil fungsi pengaduan
    if(dataMasyarakat($_POST) > 0) {
        echo "<script>
				alert('Berhasil terdaftar!');
                document.location.href = 'loginMsk.php';
		      </script>";
        // echo "berhasil";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <!-- <link rel="stylesheet" href="../css/registrasi.css"> -->
    <style>
    * {
        margin: 0;
        padding: 0;
        outline: 0;
        font-family: 'Open Sans', sans-serif;
    }

    body {
        height: 100vh;
        /* background: #f2f5f7; */
        background-image: url('../img/22159282_363265847442891_4596585639264124928_n.jpg');
        /* background: lightblue; */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    h1 {
        padding-top: 70px;
        text-align: center;
        color: #fafafa;
        text-shadow: 0 0 7px rgba(0,0,0,.7);
        font-size: 40px;
    }

    .container {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        padding: 20px 25px;
        width: 500px;
        background-color: rgba(0,0,0,.7);
        box-shadow: 0 0 10px rgba(255,255,255,3);
        /* box-sizing: border-box; */
    }

    .container h2 {
        margin-top: 20px;
        text-align: center;
        color: #fafafa;
        margin-bottom: 30px;
        text-transform: uppercase;
        /* border-bottom: 4px solid #2979ff; */
        font-size: 30px;
    }

    .container label {
        /* text-align: center; */
        margin-left: 70px;
        color: #777;
        /* font-weight: bold; */
        font-size: 19px;
    }

    .container form input {
        width: calc(100% - 10%);    
        padding: 8px 10px;
        margin-bottom: 15px;
        border: none;
        background-color: transparent;
        border-bottom: 2px solid #2979ff;
        color: #fff;
        font-size: 20px;
        margin-left: 15%;
        transition: .7s;
    }

    .container form input:hover {
        border-color: #3bff29;
        /* box-shadow: 2px 2px 6px #3bff29; */
    }

    /* .container form input:file {
        color: #2979ff;
    } */

    .container form button {
        /* width: 100%;
        padding: 5px 0;
        border: none;
        background-color: #2979ff;
        font-size: 18px;
        color: #fafafa;
        margin-bottom: 13px;
        transition: .2s;
        font-weight: bold; */
        width: 160px;
        padding: 10px 0;
        border: 2px solid #2979ff;
        background-color: #2979ff;
        font-size: 15px;
        color: #fafafa;
        /* margin-bottom: 30px; */
        transition: .2s;
        font-weight: bold;
        border-radius: 50px;
        text-align: center;
        transition: .2s;
        margin-left: -240px;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .container form button:hover {
        box-shadow: 0 0 3px 1px #3bff29;
        /* background-color: rgb(61, 139, 240);  */
        background-color: #2979ff;
        /* font-size: 18px; */
        font-weight: bold;
        font-style: italic;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Masyarakat</h2>
        <div class="form">
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><input type="text" name="nama_msk" id="nama-msk" required placeholder="Nama"></td>
                    </tr>
                    <tr>
                        <td><input type="tel" name="nik_msk" id="nik" required placeholder="Nik"></td>
                    </tr>
                    <tr>
                        <td><input type="email" name="email" id="email" placeholder="Email"></td>
                    </tr>
                    <tr>
                        <td><input type="password" name="password" id="password" placeholder="Password"></td>
                    </tr>
                    <tr>
                        <td><input type="tel" name="telp" id="telp" required placeholder="Telp"></td>
                    </tr>
                    <tr>
                        <td><label for="gambar">Foto </label><br>
                        <input type="file" name="gambar" id="gambar" class="file" placeholder="Foto"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="kirim" class="button">Sign Up</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>