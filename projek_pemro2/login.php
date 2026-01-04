<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "
        SELECT * FROM users 
        WHERE username='$username' 
        AND password='$password'
    ");

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | SPK PROMETHEE</title>
    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
        }
        .login-box{
            width:300px;
            margin:100px auto;
            background:#fff;
            padding:20px;
            box-shadow:0 0 10px #ccc;
        }
        input{
            width:100%;
            padding:8px;
            margin-bottom:10px;
        }
        button{
            width:100%;
            padding:8px;
            background:#007bff;
            color:white;
            border:none;
        }
        .error{
            color:red;
            text-align:center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h3 align="center">Login Sistem</h3>

    <?php if(isset($error)){ ?>
        <p class="error"><?= $error ?></p>
    <?php } ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>
