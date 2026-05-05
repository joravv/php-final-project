<?php
session_start();
include "db.php";

$id = $_GET['id'];

/* GET INJURY */
$result = $conn->query("SELECT * FROM injuries WHERE id=$id");
$injury = $result->fetch_assoc();

/* UPDATE INJURY */
if(isset($_POST['update']) && isset($_SESSION["role"]) && $_SESSION["role"]=="medical"){
    $player = $_POST['player'];
    $status = $_POST['status'];

    $conn->query("UPDATE injuries 
    SET player_name='$player', status='$status'
    WHERE id=$id");

    header("Location: injuries.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Edit Injury</title>
</head>

<body>

<h1>Edit Injury</h1>

<?php if(isset($_SESSION["role"]) && $_SESSION["role"]=="medical"){ ?>

<form method="POST">

<input type="text" name="player" value="<?php echo $injury['player_name']; ?>">

<select name="status">
    <option <?php if($injury['status']=="Injured") echo "selected"; ?>>Injured</option>
    <option <?php if($injury['status']=="Recovering") echo "selected"; ?>>Recovering</option>
    <option <?php if($injury['status']=="Fit") echo "selected"; ?>>Fit</option>
</select>

<button name="update">Update</button>

</form>

<?php } else { ?>
<p>You are not allowed to edit injuries.</p>
<?php } ?>

</body>
</html>