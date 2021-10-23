<?php 
// session_start();
require 'functions.php';

// jika ada $_SESSION['login'] maka arahkan ke index.php
if(isset($_SESSION['login'])) {
    header("Location: pengaduan.php");
}

// memanggil method login
loginMsk($_POST);
  

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <h1>Sign In Pengaduan</h1>
    <div class="container">
        <h2>Login</h2>
        <?php if(isset($error)) : ?>
            <p style="color: red; font-weight: italic">username / password salah!</p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="email">Email </label>
            <br>
            <input type="email" name="email" id="email">
            <br>
            <label for="password">Password </label>
            <br>
            <input type="password" name="password" id="password">
            <br>
            <button type="submit" name="login">Log in</button>
            <a href="RegistrasiMsk.php" class="registrasi">Sign Up</a><br>
        </form>
    </div>
</body>
</html>