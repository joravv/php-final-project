<?php
session_start();
include "db.php";

if(isset($_POST["login"])){
    $email=$_POST["email"];
    $password=$_POST["password"];

    $res=$conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
    if($res->num_rows>0){
        $user=$res->fetch_assoc();
        $_SESSION["user"]=$user["name"];
        $_SESSION["role"]=$user["role"];
        header("Location: dashboard.php");
    } else {
        echo "Wrong login";
    }
}



?>

<form method="POST">
<input name="email" placeholder="Email">
<input name="password" placeholder="Password">
<button name="login">Login</button>
</form>