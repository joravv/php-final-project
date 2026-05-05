<?php
session_start();
include "db.php";

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role"];


if(isset($_POST["add"]) && $role=="coach"){
    $op = $_POST["opponent"];
    $date = $_POST["date"];
    $stadium = $_POST["stadium"];

    $conn->query("INSERT INTO matches(opponent, match_date, stadium)
    VALUES('$op','$date','$stadium')");
}


if(isset($_GET["delete"]) && $role=="coach"){
    $id = $_GET["delete"];
    $conn->query("DELETE FROM matches WHERE id=$id");
}


$res = $conn->query("SELECT * FROM matches ORDER BY match_date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Matches</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>


<div class="sidebar">

    <h2>FCB PANEL</h2>

    <div class="user">
        Logged in as<br>
        <b><?php echo $_SESSION["user"]; ?></b><br>
        <small><?php echo $role; ?></small>
    </div>

    <a href="index.php"> Dashboard</a>
    <a href="players.php"> Players</a>
    <a href="matches.php"> Matches</a>
    <a href="injuries.php"> Injuries</a>

    <a class="logout" href="logout.php"> Logout</a>
</div>

<div class="main">

<h1> Match Center</h1>

<?php if($role=="staff"){ ?>
<p>You can only view matches (read-only access).</p>
<?php } ?>


<?php if($role=="coach"){ ?>
<div class="edit-container">
    <h3>Add New Match</h3>

    <form method="POST" class="edit-form">
        <label>Opponent</label>
        <input name="opponent" required>

        <label>Date</label>
        <input name="date" type="date" required>

        <label>Stadium</label>
        <input name="stadium" required>

        <button name="add">Add Match</button>
    </form>
</div>
<?php } ?>

<table>
<tr>
    <th>Opponent</th>
    <th>Date</th>
    <th>Stadium</th>
    <th>Actions</th>
</tr>

<?php while($r = $res->fetch_assoc()){ ?>
<tr>
    <td><?php echo $r["opponent"]; ?></td>
    <td><?php echo $r["match_date"]; ?></td>
    <td><?php echo $r["stadium"]; ?></td>

    <td>
        <?php if($role=="coach"){ ?>
            <a href="editmatches.php?id=<?php echo $r['id']; ?>">Edit</a> |
            <a href="matches.php?delete=<?php echo $r['id']; ?>">Delete</a>
        <?php } else { ?>
            View only
        <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>