<?php 
session_start();

// jika tidak ada $_SESSION['login'] maka arahkan ke login.php
// if(!isset($_SESSION['login'])) {
//   header("Location: login.php");
// }

$conn = mysqli_connect("localhost", "root", "", "db_pengaduan_masyarakat");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data) {
    global $conn;
    // ambil data yang ada pada form regist petugas
    $nama = htmlspecialchars($data['name']);
    $email = strtolower(stripcslashes($data['email']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);
    $telp = htmlspecialchars($data['telp']);

    // cek email sudah terdaftar atau belum
    $result = mysqli_query($conn, "SELECT username FROM tb_petugas WHERE username = '$email'");

    if(mysqli_fetch_assoc($result)) {
        echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
    }

    // cek konfirmasi password
    if($password != $password2) {
        echo "<script>
				alert('konfirmasi passowrd salah');
		      </script>";
		return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan ke database
    mysqli_query($conn, "INSERT INTO tb_petugas VALUES('', '$nama', '$email', '$password', '$telp')");

    return mysqli_affected_rows($conn);
    
}

function dataMasyarakat($data) {
  global $conn;
  // ambil data dari form pengaduan
  // get data masyarakat
  $nama_msk = htmlspecialchars($data['nama_msk']);
  $nik_msk = htmlspecialchars($data['nik_msk']);
  $user = htmlspecialchars($data['email']);
  $password = htmlspecialchars($data['password']);
  $telp = $data['telp'];
  $gambar = $data['gambar'];

  $gambar = upload();

  if(!$gambar) {
    return false;
  }

  // tambahkan data masyarakat
  mysqli_query($conn, "INSERT INTO tb_masyarakat VALUES('', '$nama_msk', '$nik_msk', '$user', '$password', '$telp', '$gambar')");

  return mysqli_affected_rows($conn);

}

function upload() {
  // ambil data files
  $namaFile = $_FILES['gambar']['name'];
  $ukuranFile = $_FILES['gambar']['size'];
  $errorFile = $_FILES['gambar']['error'];
  $tmpName = $_FILES['gambar']['tmp_name'];

  // cek apakah tidak ada gambar yang di upload
  if($errorFile === 4) {
    echo "<script>
      alert('Anda tidak memasukkan gambar,
      Silahkan masukkan!');
    </script>";
    return false;
  }

  // cek apakah yg diupload adalah gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>
      alert('Yang anda upload bukan gambar, 
      Silahkan masukkan gambar (jpg/jpeg/png)!');
    </script>";
    return false;
  }

  // cek ukuran dari gambar yang diupload
  if($ukuranFile > 1000000) {
    echo "<script>
      alert('Ukuran gambar terlalu besar, Silahkan masukkan!');
    </script>";
    return false;
  }

  // generate nama file baru, gambar siap di upload
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;

  move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

  return $namaFileBaru;
}

function tanggapan($data) {
    global $conn;
    // ambil data dari form tanggapan
    $nama_pts = $data['name'];
    $id_pengaduan = $data['id_pengaduan'];
    $tgl_tanggapan = $data['date'];
    $isi_tanggapan = $data['isi_tanggapan'];
    $id_petugas = $data['id_pts'];

    // query insert
    mysqli_query($conn, "INSERT INTO tb_tanggapan VALUES('', '$id_pengaduan', '$tgl_tanggapan', '$isi_tanggapan', '$id_petugas', '$nama_pts')");

    return mysqli_affected_rows($conn);
}



// jika tombol login di tekan
function login($data) {
  global $conn;
  if(isset($data['login'])) {
    // ambil data dari form login
    $email = $data['email'];
    $password = $data['password'];
  
    // cek username
    $result = mysqli_query($conn, "SELECT * FROM tb_petugas WHERE username_pts = '$email'");
    if(mysqli_num_rows($result) > 0) {
      // cek password
      $row = mysqli_fetch_assoc($result);
      $passwordHash = $row['password_pts'];
        // var_dump($passwordHash);
        if(password_verify($password, $passwordHash)) {
          // set session
          $_SESSION['id_pts'] = $row['id_pts'];
          $_SESSION['login'] = true;
            header("Location: table.php");
            exit;
        }
    }
  }
}


// jika tombol konfirm di tekan
function loginMsk($data) {
  global $conn;
  if(isset($data['login'])) {
    // ambil data dari form login
    $email = $data['email'];
    $password = $data['password'];
  
    // cek username
    $result = mysqli_query($conn, "SELECT * FROM tb_masyarakat WHERE username_msk = '$email'");
    if(mysqli_num_rows($result) > 0) {
      // cek password
      $row = mysqli_fetch_assoc($result);
      // $passwordHash = $row['password_msk'];
        // var_dump($passwordHash);
        $_SESSION['id_msk'] = $row['id_msk'];
        $_SESSION['nik_msk'] = $row['nik'];
        if($password === $row['password_msk']) {
          // set session
            header("Location: pengaduan.php");
            exit;
        }
    }
  }
}

?>