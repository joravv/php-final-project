<?php
session_start();
include "db.php";

$id = $_GET['id'];

/* GET MATCH */
$result = $conn->query("SELECT * FROM matches WHERE id=$id");
$match = $result->fetch_assoc();

/* UPDATE MATCH */
if(isset($_POST['update']) && isset($_SESSION["role"]) && $_SESSION["role"]=="coach"){
    $op = $_POST['opponent'];
    $date = $_POST['date'];
    $stadium = $_POST['stadium'];

    $conn->query("UPDATE matches 
    SET opponent='$op', match_date='$date', stadium='$stadium'
    WHERE id=$id");

    header("Location: matches.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Edit Match</title>
</head>

<body>

<h1>Edit Match</h1>

<?php if(isset($_SESSION["role"]) && $_SESSION["role"]=="coach"){ ?>

<form method="POST">

<input type="text" name="opponent" value="<?php echo $match['opponent']; ?>">
<input type="date" name="date" value="<?php echo $match['match_date']; ?>">
<input type="text" name="stadium" value="<?php echo $match['stadium']; ?>">

<button name="update">Update</button>

</form>

<?php } else { ?>
<p>You are not allowed to edit matches.</p>
<?php } ?>

</body>
</html>