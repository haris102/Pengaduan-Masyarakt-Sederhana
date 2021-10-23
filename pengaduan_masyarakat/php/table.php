<?php 
include 'functions.php';

// jika tidak ada $_SESSION['login'] maka arahkan ke login.php
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
}

$query = query("SELECT id_msk, nik, nama_msk, telp_msk FROM tb_masyarakat");
// $queyrPgd = query("SELECT id_pengaduan FROM tb_pengaduan");
// $queryPts = query("SELECT id_pts FROM tb_petugas");
// var_dump($_SESSION['id_pts']);


// jika ada search
if(isset($_POST['search'])) {
    $keyword = $_POST['keyword'];

    $query = query("SELECT * FROM tb_masyarakat WHERE nik LIKE '%$keyword%' OR nama_msk LIKE '%$keyword%' ");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman index</title>
    <link rel="stylesheet" href="../css/table.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            overflow: hidden;
            /* background-color: #35a9db; */
            background-color: #e7e7e7;
            position: fixed;
            margin-top: -100px;
            border-radius: 5px;
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

        .topnav .search-container {
            float: left;
        }

        .topnav input[type=text] {
            padding: 6px;
            margin-top: 8px;
            font-size: 17px;
            border: none;
            outline: none;
        }

        .topnav .search-container button {
            float: right;
            padding: 6px;
            margin-top: 8px;
            margin-right: 16px;
            background-color: #ddd;
            font-size: 17px;
            border: none;
            cursor: pointer;
        }

        .topnav .search-container button:hover {
            background-color: #ccc;
        }

        @media screen and (max-width: 600px) {
            .topnav .search-container {
                float: none;
            }
            .topnav a, .topnav input[type=text], .topnav .search-container button {
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
    </style>
</head>
<body>
    <div class="topnav">
        <a href="logout.php">Logout</a>
        <a href="table.php">Home</a>
        <div class="search-container">
            <form action="" method="post">
                <input type="text" name="keyword" placeholder="Search..">
                <button type="submit" name="search">Search</button>
            </form>
        </div>
    </div>
    <!-- <a href="logout.php" class="logout">Log out!</a> -->
    <h1 class="judul">Daftar Pengaduan Masyarakat</h1>
    <div class="container">
        <table class="table1">
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Nama</th>
                <th>No telp</th>
                <th>Pengaduan/Tanggapan</th>
            </tr>
            <form action="" method="get">
                <?php $i = 1; ?>
                <?php foreach($query as $row) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['nik']; ?></td>
                        <td class="name"><?= $row['nama_msk']; ?></td>
                        <td><?= $row['telp_msk']; ?></td>
                        <td><a href="laporan.php?id_msk=<?php echo $row['id_msk']; ?>" class="isi-laporan">Isi Laporan</a></td>
                    </tr>
                <?php endforeach; ?>
            </form>
        </table>
    </div>
            
</body>
</html>