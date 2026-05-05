<?php
session_start();
include "db.php";

/* PROTECT PAGE */
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role"];

/* ADD INJURY (MEDICAL ONLY) */
if(isset($_POST["add"]) && $role=="medical"){
    $p = $_POST["player"];
    $s = $_POST["status"];

    $conn->query("INSERT INTO injuries(player_name,status)
    VALUES('$p','$s')");
}

/* DELETE INJURY (MEDICAL ONLY) */
if(isset($_GET["delete"]) && $role=="medical"){
    $id = $_GET["delete"];
    $conn->query("DELETE FROM injuries WHERE id=$id");
}

/* GET DATA */
$res = $conn->query("SELECT * FROM injuries ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Injuries</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>FCB PANEL</h2>

    <div class="user">
        Logged in as<br>
        <b><?php echo $_SESSION["user"]; ?></b><br>
        <small><?php echo $role; ?></small>
    </div>

    <a href="index.php">🏠 Dashboard</a>
    <a href="players.php">👥 Players</a>
    <a href="matches.php">⚽ Matches</a>
    <a href="injuries.php">🏥 Injuries</a>

    <a class="logout" href="logout.php">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h1>🏥 Medical Center</h1>

<?php if($role!="medical"){ ?>
<p>You can only view injury reports (read-only access).</p>
<?php } ?>

<!-- ADD FORM -->
<?php if($role=="medical"){ ?>
<div class="edit-container">
    <h3>Add Injury Report</h3>

    <form method="POST" class="edit-form">
        <label>Player Name</label>
        <input name="player" required>

        <label>Status</label>
        <select name="status">
            <option>Injured</option>
            <option>Recovering</option>
            <option>Fit</option>
        </select>

        <button name="add">Add Injury</button>
    </form>
</div>
<?php } ?>

<!-- TABLE -->
<table>
<tr>
    <th>Player</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while($r = $res->fetch_assoc()){ ?>
<tr>
    <td><?php echo $r["player_name"]; ?></td>
    <td>
        <span style="color:
        <?php 
            if($r["status"]=="Injured") echo '#ff4d4d';
            elseif($r["status"]=="Recovering") echo '#ffcc00';
            else echo '#00ff99';
        ?>">
        <?php echo $r["status"]; ?>
        </span>
    </td>

    <td>
        <?php if($role=="medical"){ ?>
            <a href="editinjury.php?id=<?php echo $r['id']; ?>">Edit</a> |
            <a href="injuries.php?delete=<?php echo $r['id']; ?>">Delete</a>
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