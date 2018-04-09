<?php 
session_start();

if( isset($_COOKIE['login']) ) {
    if( $_COOKIE['login'] == 'true' ) {
        $_SESSION['login'] = true;
    }
}

if( isset($_SESSION['login']) ) {
    header('Location: index.php');
    exit;
}
require "functions.php";
if( isset($_POST['login']) ) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if( mysqli_num_rows($result) === 1 ) {
        
        $row = mysqli_fetch_assoc($result);

        echo password_verify($password, $row['password']);
        if( password_verify($password, $row['password']) ) {
            // set session
            $_SESSION['login'] = true;

            // cek remember me
               if( isset($_POST['remember']) ){
                   setcookie('login', 'true', time()+60);
               } 

            header('Location: index.php');
            exit;
        }
    }

    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h1>Halaman Login</h1>

    <?php if( isset($error) ) : ?>
        <p style="color:red; font-style:italic;">username / password salah!</p>
    <?php endif; ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </li>
            <li>
                <button type="submit" name="login">Login</button>
            </li>
        </ul>
    </form>
</body>
</html>