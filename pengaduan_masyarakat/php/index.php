<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login Pengaduan Masyarakat</title>
    <!-- <link rel="stylesheet" href="../css/loginlogin.css"> -->
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
        width: 300px;
        background-color: rgba(0,0,0,.7);
        box-shadow: 0 0 10px rgba(255,255,255,3);
        /* box-sizing: border-box; */
    }

    .container h2 {
        margin-top: 20px;
        text-align: center;
        color: #fafafa;
        margin-bottom: 50px;
        text-transform: uppercase;
        border-bottom: 4px solid #2979ff;
        font-size: 33px;
    }


    .container label {
        text-align: left;
        color: #90caf9;
    }

    .signin {
        width: 180px;
        padding: 10px 0;
        border: 2px solid #2979ff;
        background-color: none;
        font-size: 16px;
        color: #fafafa;
        margin-bottom: 30px;
        transition: .2s;
        font-weight: bold;
        margin: 30px auto;
        border-radius: 50px;
        text-align: center;
        transition: .2s;
        /* margin-top: -20px; */
    }
    .signin:hover {
        width: 200px;
        border-color: rgb(61, 240, 61);
        box-shadow: 0 0 5px rgb(61, 240, 61);
    }
    
    .signin a {
        color: #fafafa;
        text-decoration: none;
        transition: .1s;
    }

    .signin a:hover {
        text-shadow: 0 0 5px rgb(61, 240, 61);
    }

    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome</h2>
        <?php if(isset($error)) : ?>
            <p style="color: red; font-weight: italic">username / password salah!</p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="signin">
                <a href="login.php">Sign In Petugas</a>
            </div>
            <div class="signin">
                <a href="loginMsk.php">Sign In Pengaduan</a>
            </div>
        </form>
    </div>
</body>
</html>