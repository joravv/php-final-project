<?php
include "db.php";

if(isset($_POST["register"])){

    $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role)
    VALUES(?,?,?,?)");

    $stmt->execute([
        $_POST["name"],
        $_POST["email"],
        $_POST["password"],
        $_POST["role"]
    ]);

    echo "Registered!";
}
?>

<form method="POST">
<input name="name" placeholder="Name">
<input name="email" placeholder="Email">
<input name="password" placeholder="Password">
<select name="role">
<option>Admin</option>
<option>Coach</option>
<option>Medical</option>
<option>Media</option>
</select>
<button name="register">Register</button>
</form>