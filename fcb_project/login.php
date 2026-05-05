<?php
session_start();
include "db.php";

if(isset($_SESSION["user"])){
    header("Location: index.php");
    exit();
}

$error = "";

if(isset($_POST["login"])){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $res = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if($res->num_rows > 0){
        $user = $res->fetch_assoc();

        $_SESSION["user"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        header("Location: index.php");
        exit();

    } else {
        $error = "Wrong email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">

<div class="login-box">

    <h2>FCB Staff Login</h2>

    <?php if($error != ""){ ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button name="login">Login</button>

    </form>

</div>

</body>
</html>