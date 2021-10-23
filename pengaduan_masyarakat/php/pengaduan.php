<?php 
require 'functions.php';

// ambil id_msk dan nik_msk masukkan ke variabel
$id_msk = $_SESSION['id_msk'];
$nik_msk = $_SESSION['nik_msk'];

// jika ada tombol kirim
if(isset($_POST['kirim'])) {
    // panggil fungsi pengaduan
    $tgl_pengaduan = $_POST['date'];
    $isi_laporan = $_POST['isi_pengaduan'];

    // tambahkan ke database
    mysqli_query($conn, "INSERT INTO tb_pengaduan VALUES('', '$tgl_pengaduan', '$nik_msk', '$isi_laporan', '$id_msk')");

    if(mysqli_affected_rows($conn) > 0 ) {
        echo "<script>
				alert('Data Pengaduan Berhasil Terkirim');
                document.location.href = 'index.php';
		      </script>";
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pengaduan Masyarakat</title>
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
        width: 385px;
        background-color: rgba(0,0,0,.7);
        box-shadow: 0 0 10px rgba(255,255,255,3);
        /* box-sizing: border-box; */
    }

    .container h2 {
        margin-top: 10px;
        text-align: center;
        color: #fafafa;
        margin-bottom: 30px;
        text-transform: uppercase;
        border-bottom: 4px solid #2979ff;
        font-size: 30px;
    }

    .container label {
        /* text-align: center; */
        margin-left: 50px;
        color: #777;
        /* font-weight: bold; */
        font-size: 19px;
    }

    .container form input {
        width: calc(100% - 25%);    
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

    textarea {
        margin-top: 10px;
        font-size: 15px;
        background-color: #222;
        color: #fafafa;
        border: 2px solid #2979ff;
        outline: none;
        resize: none;
        width: 300px;
        height: 200px;
        margin-left: 40px;
    }

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
        margin-bottom: 10px;
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
        <h2>Pengaduan</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <td><label for="date">Tanggal Pengaduan : </label><br><input type="date" name="date" id="date"></td>
                </tr>
                <tr>
                    <td><label for="isi_pengaduan">Pengaduan : </label><br>
                    <textarea name="isi_pengaduan" id="isi_pengaduan" placeholder="Isi disini!"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" name="kirim">Kirim</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>