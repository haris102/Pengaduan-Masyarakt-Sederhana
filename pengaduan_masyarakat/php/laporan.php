<?php 
require 'functions.php';

// jika tidak ada $_SESSION['login'] maka arahkan ke login.php
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
}

// set session id_masyarakat
$_SESSION['id_msk'] = $_GET['id_msk'];
$id_msk = $_SESSION['id_msk'];
// var_dump($id_msk);

// query inner join
$query = query("SELECT nik, nama_msk, telp_msk, gambar, id_pengaduan, tgl_pengaduan, isi_laporan FROM tb_masyarakat INNER JOIN tb_pengaduan ON tb_masyarakat.id_msk = tb_pengaduan.id_msk WHERE tb_masyarakat.id_msk = '$id_msk' AND tb_pengaduan.id_msk = '$id_msk'");

// tampilkan pesan jika masyarakat tidak mengadukan
if(!$query) {
    echo "Masyarakat tidak mengadukan / Petugas telah menghapus pengaduan";
    return false;
}

// get id_pengaduan
foreach($query as $row) {
    $_SESSION['id_pengaduan'] = $row['id_pengaduan'];
}

$id_pengaduan = $_SESSION['id_pengaduan'];
// var_dump($id_pengaduan);

// query inner join tb_tanggapan dan tb_pengaduan
$getDataTanggapanDanPengaduan = query("SELECT * FROM tb_pengaduan INNER JOIN tb_tanggapan ON tb_pengaduan.id_pengaduan =  tb_tanggapan.id_pengaduan WHERE tb_pengaduan.id_pengaduan = '$id_pengaduan' AND tb_tanggapan.id_pengaduan = '$id_pengaduan'");


// query data tb_petugas
$id_pts = $_SESSION['id_pts'];
$getDataPetugas = query("SELECT nama_pts FROM tb_petugas WHERE id_pts = '$id_pts'");


// query data tb_tanggapan
$queryTgp = mysqli_query($conn, "SELECT * FROM tb_tanggapan WHERE id_pengaduan = '$id_pengaduan'");

// var_dump($_SESSION['id_pts']);

// jika tombol kirim ditekan
if(isset($_POST['kirim'])) {
    if(tanggapan($_POST) > 0) {
        echo "<script>
            alert('tanggapan berhasil ditambahkan!');
            document.location.href = 'table.php';
        </script>";
    } else {
        echo "<script>
            alert('tanggapan gagal ditambahkan!');
        </script>";
    }
}

// jika tombol drop ditekan
// drop data masyarakat tertentu
if(isset($_POST['drop'])) {
    $deleteTanggapan = mysqli_query($conn, "DELETE FROM tb_tanggapan WHERE id_pengaduan = '$id_pengaduan'");
    $deletePengaduan = mysqli_query($conn, "DELETE FROM tb_pengaduan WHERE id_pengaduan = '$id_pengaduan'");
    $deleteMasyarakat = mysqli_query($conn, "DELETE FROM tb_masyarakat WHERE id_msk = '$id_msk'");

    if($deleteMasyarakat && $deletePengaduan && $deleteTanggapan) {
        echo "<script>
            alert('Data berhasil di Drop!');
            document.location.href = 'table.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal di Drop!');
            document.location.href = 'table.php';
        </script>";
    }
}


// jika tombol delete ditekana
// delete pengaduan
if(isset($_POST['delete-pengaduan'])) {
    $delete = mysqli_query($conn, "DELETE FROM tb_pengaduan WHERE id_pengaduan = '$id_pengaduan'");
    if($delete) {
        echo "<script>
            alert('Pengaduan berhasil dihapus!');
            document.location.href = 'table.php';
        </script>";
    } else {
        echo  "<script>
            alert('Pengaduan berhasil dihapus!');
            document.location.href = 'table.php';
        </script>";
    }
}


// jika tombol delete ditekan
// delete tanggapan
if(isset($_POST['delete-tanggapan'])) {
    $delete = mysqli_query($conn, "DELETE FROM tb_tanggapan WHERE id_pengaduan = '$id_pengaduan' ");
    if($delete) {
        echo "<script>
            alert('tanggapan berhasil dihapus!');
            document.location.href = 'laporan.php';
        </script>";
    } else {
        echo "<script>
            alert('tanggapan gagal dihapus!');
            document.location.href = 'table.php';
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
    <title>Halaman Laporan</title>
    <!-- <link rel="stylesheet" href="../../css/laporan.css"> -->
    <style>
        .topnav {
            margin-top: -30px;
            margin-left: -30px;
            overflow: hidden;
            /* background-color: #35a9db; */
            background-color: #e7e7e7;
            position: fixed;
            z-index: 9999;
            width: 20%;
            border-radius: 10px;
        }

        .topnav a {
            float: left;
            display: block;
            color: #000;
            /* color: #fafafa; */
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: #000;
        }

        .topnav .drop-container {
            float: left;
        }

        .topnav input[type=text] {
            padding: 6px;
            margin-top: 8px;
            font-size: 17px;
            border: none;
            outline: none;
        }

        .topnav .drop-container button {
            float: right;
            padding: 6px;
            margin-left: 20px;
            margin-top: 8px;
            margin-right: 16px;
            background-color: #e7e7e7;
            font-size: 17px;
            border: none;
            cursor: pointer;
            transition: .3s;
        }

        .topnav .drop-container button:hover {
            background-color: rgb(220, 20, 50);
            box-shadow: 0 0 5px rgb(220, 20, 50);
        }

        @media screen and (max-width: 600px) {
            .topnav .drop-container {
                float: none;
            }
            .topnav a, .topnav input[type=text], .topnav .drop-container button {
                float: none;
                display: block;
                text-align: left;
                width: 100%;
                margin: 0;
                padding: 14px;
            }
            .topnav input[type=text] {
                border: 1px solid #ccc;
            }
        }

    .tglPengaduan {
        margin-top: -10px;
        font-style: italic;
        float: right;
    }

    body {
        /* background: #f2f5f7; */
        /* background: lightblue; */
        max-height: 1000vh;
        background-image: url('../img/smkn1.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font: 14px sans-serif;
        padding: 20px;
    }

    img {
        margin-top: 30px;
        margin-left: 20px;
        width: 80px;
        height: 80px;
        border-radius: 3px;
        box-shadow: 1px 1px 3px black;
        float: left;
    }

    .identitas {
        margin-left: 120px;
        margin-top: 30px;
        font-style: italic;
        font-weight: bold;
    }

    .identitas-pts {
        margin-left: 50px;
        margin-top: 50px;
        font-style: italic;
        font-weight: bold;
    }

    .isi {
        margin-top: 60px;
        font-size: 15.5px;
    }

    h2,h3 {
        text-align: center;
    }

    .kertas {
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        margin: 26px auto 0;
        max-width: 550px;
        min-height: 300px;
        padding: 24px;
        position: relative;
        width: 80%;
        }

    .kertas:before,
    .kertas:after {
        content: "";
        height: 98%;
        position: absolute;
        width: 100%;
        z-index: -1;
        }

    .kertas:before {
        background: #fafafa;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        left: -5px;
        top: 4px;
        transform: rotate(-2.5deg);
        }

    .kertas:after {
        background: #f6f6f6;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        right: -3px;
        top: 1px;
        transform: rotate(1.4deg);
        }

    .btn-tanggapan button {
        /* background-color: salmon; */
        margin-top: 20px;
        margin-left: 40%;
        /* margin: auto; */
    }

    td {
        display: block;
        margin-bottom: 5px;
    }

    table{
        margin: auto;
    }


    /* Button Delete Pengaduan */
    .btn-delete {
        margin: 20px auto 0;
        width: 1px;
        margin-left: 85%;
    }

    .btn-delete button {
        width: 80px;
        padding: 5px 0;
        border: 2px none #000;
        background-color: rgb(220, 10, 10);
        font-size: 15px;
        color: #fafafa;
        transition: .2s;
        font-weight: bold;
        border-radius: 50px;
        text-align: center;
        transition: .2s;
    }

    .btn-delete button:hover {
        background-color: rgb(200, 20, 20);
        box-shadow: 0 0 10px #000;
    }


    /* Button tangapan */
    .btn-tanggapan {
        margin: auto;
        width: 1px;
        padding-right: 100px;
    }
    
    .btn-tanggapan button {
        width: 100px;
        padding: 10px 0;
        border: 2px none #000;
        background-color: #3ba220;
        font-size: 15px;
        color: #fafafa;
        transition: .2s;
        font-weight: bold;
        border-radius: 50px;
        text-align: center;
        transition: .2s;
    }

    .btn-tanggapan button:hover {
        background-color: #3b9200;
        box-shadow: 0 0 10px #000;
    }


    /* Box Tanggapan Petugas */
    .box-tanggapan {
        width: 450px;
        background-color: #fafafa;
        margin: 20px auto;
        padding-top: 30px;
        border-radius: 5px;
        box-shadow: 0 0 10px #000;
    }

    .box-tanggapan label {
        /* text-align: center; */
        margin-left: 70px;
        color: #000;
        /* font-weight: bold; */
        font-size: 19px;
    }

    .box-tanggapan form input {
        width: calc(100% - 30%);    
        padding: 8px 10px;
        margin-bottom: 15px;
        margin-left: 10%;
        border: none;
        background-color: transparent;
        border-bottom: 2px solid #777;
        color: #000;
        font-size: 20px;
        transition: .7s;
    }

    .box-tanggapan form input:hover {
        border-color: #444;
        box-shadow: 2px 2px 6px #222;
    }

    /* .box-tanggapan form input:file {
        color: #2979ff;
    } */

    .box-tanggapan form button {
        width: 160px;
        padding: 10px 0;
        background-color: #777;
        font-size: 15px;
        color: #fafafa;
        margin-bottom: 20px;
        transition: .2s;
        font-weight: bold;
        border-radius: 50px;
        text-align: center;
        transition: .3s;
        margin-left: 25%;
    }

    .box-tanggapan form button:hover {
        box-shadow: 0 0 3px 1px #000;
        /* background-color: rgb(61, 139, 240);  */
        background-color: #555;
        /* font-size: 18px; */
        font-weight: bold;
        font-style: italic;
    }

    textarea {
        margin-top: 10px;
        font-size: 18px;
        background-color: #fafafa;
        color: #000;
        border: 2px solid #777;
        outline: none;
        resize: none;
        width: 300px;
        height: 200px;
        transition: .7s;
    }

    textarea:hover {
        border: 2px solid #444;
        box-shadow: 2px 2px 6px #222;
    }
    </style>
</head>
<body>

<!-- topnav -->
<div class="topnav">
    <a href="logout.php">Logout</a>
    <a href="table.php">Home</a>
    <div class="drop-container">
        <form action="" method="post">
            <button type="submit" name="drop" onclick="return confirm('Anda yakin ingin mendrop data tersebut?');">Drop</button>
        </form>
    </div>
</div>


<?php if(mysqli_num_rows($queryTgp) === 1) : ?>

    <!-- kertas laporan Pengaduan-->
    <?php foreach($query as $row) : ?>
        <div class="kertas">
            <p class="tglPengaduan">Tanggal Pengaduan : <?php echo $row['tgl_pengaduan']; ?></p>
            <img src="../img/<?= $row['gambar']; ?>">
            <div class="identitas">
                <p>Nik : <?php echo $row['nik']; ?></p>
                <p>Nama : <?php echo $row['nama_msk']; ?></p>
                <p>No telp : <?php echo $row['telp_msk']; ?></p>
            </div>
            <div class="isi">
                <h2>Laporan Pengaduan Masyarakat</h2>
                <h3>Isi Laporan</h3>
                <br/>
                <p><?php echo $row['isi_laporan']; ?></p>
            </div>
            <br>
            <form action="" method="post">
                <div class="btn-delete">
                    <button type="submit" name="delete-pengaduan" onclick="return confirm('Anda yakin ingin menghapus pengaduan <?php echo $row['nama_msk']; ?> ?'); ">Delete</button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
    
    <!-- kertas Laporan Tanggapan -->
    <?php foreach($getDataTanggapanDanPengaduan as $rowTgp) : ?>
        <div class="kertas">
            <p class="tglPengaduan">Tanggal Tanggapan : <?php echo $rowTgp['tgl_tanggapan']; ?></p>
            <div class="identitas-pts">
                <p class="nama-pts">Nama Petugas: <?php echo $rowTgp['nama_pts']; ?></p>
            </div>
            <div class="isi">
                <h2>Laporan Tanggapan Pengaduan Masyarakat</h2>
                <h3>Isi Tanggapan Petugas</h3>
                <br/>
                <p><?php echo $rowTgp['tanggapan']; ?></p>
            </div>
            <br>
            <form action="" method="post">
                <div class="btn-delete">
                    <button type="submit" name="delete-tanggapan" onclick="return confirm('Anda yakin ingin menghapus tanggapan tersebut?'); ">Delete</button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>

<!-- else, Petugas dapat menambahkan loparan tanggapan -->
<?php else : ?>
    <?php foreach($query as $row) : ?>
        <div class="kertas">
            <p class="tglPengaduan">Tanggal Pengaduan : <?php echo $row['tgl_pengaduan']; ?></p>
            <img src="../img/<?= $row['gambar']; ?>">
            <div class="identitas">
                <p>Nik : <?php echo $row['nik']; ?></p>
                <p>Nama : <?php echo $row['nama_msk']; ?></p>
                <p>No telp : <?php echo $row['telp_msk']; ?></p>
            </div>
            <div class="isi">
                <h2>Laporan Pengaduan Masyarakat</h2>
                <h3>Isi Laporan</h3>
                <br/>
                <p><?php echo $row['isi_laporan']; ?></p>
            </div>
            <br>
            <form action="" method="post">
                <div class="btn-delete">
                    <button type="submit" name="delete-pengaduan">Delete</button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>

    <!-- button tanggapan -->
    <?php if(!isset($_GET['tanggapan'])) : ?>
        <div class="btn-tanggapan">
            <form action="" method="POST">
                <button type="submit" name="tanggapan" >Tanggapan</button>
            </form>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- tanggapan petugas -->
<?php if(isset($_POST['tanggapan'])) : ?>
    <?php ?>
    <div class="box-tanggapan">
        <div class="element-tanggapan">
            <form action="" method="post">
                <input type="hidden" name="id_pts" value="<?php echo $_SESSION['id_pts']; ?>">
                <input type="hidden" name="id_pengaduan" value="<?php echo $id_pengaduan ?>">
                <table>
                    <tr>
                        <td><label for="name">Nama Petugas: </label></td>
                        <td><input type="text" name="name" id="name" required autocomplete="off"></td>
                    </tr>
                    <tr>
                        <td><label for="date">Tanggal Tanggapan: </label> </td>
                        <td><input type="date" name="date" id="date" required></td>
                    </tr>
                    <tr>
                        <td><label for="isiTanggapan">Isi Tanggapan</label></td>
                        <td><textarea name="isi_tanggapan" id="isiTanggapan" required></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="btn-konfirm"><button type="submit" name="kirim">kirim!</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php endif; ?>
</body>
</html>