<?php
include "db.php";

$id = $_GET['id'];

/* GET PLAYER */
$result = $conn->query("SELECT * FROM players WHERE id=$id");
$player = $result->fetch_assoc();

/* UPDATE PLAYER */
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $position = $_POST['position'];
    $age = $_POST['age'];

    $conn->query("UPDATE players 
    SET name='$name', position='$position', age='$age'
    WHERE id=$id");

    header("Location: players.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Edit Player</title>
</head>
<body>

<h1>Edit Player</h1>

<form method="POST">

<input type="text" name="name" value="<?php echo $player['name']; ?>">
<input type="text" name="position" value="<?php echo $player['position']; ?>">
<input type="number" name="age" value="<?php echo $player['age']; ?>">

<button name="update">Update</button>

</form>

</body>
</html>