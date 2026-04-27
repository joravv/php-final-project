<?php
session_start();
include "db.php";

if(isset($_POST["login"])){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->execute([$email,$password]);

    if($stmt->rowCount() > 0){
        $user = $stmt->fetch();
        $_SESSION["user"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        header("Location: dashboard.php");
    } else {
        $error = "Wrong login";
    }
}
?>

<form method="POST">
<input name="email" placeholder="Email">
<input name="password" type="password" placeholder="Password">
<button name="login">Login</button>
</form>

<?php if(isset($error)) echo $error; ?>