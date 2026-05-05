<?php
session_start();
include "db.php";


/* PROTECT PAGE */
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

/* ADD PLAYER (COACH ONLY) */
if(isset($_POST["add"]) && isset($_SESSION["role"]) && $_SESSION["role"]=="coach"){

    $name = $_POST["name"];
    $position = $_POST["position"];
    $age = $_POST["age"];

    $sql = "INSERT INTO players(name, position, age)
            VALUES('$name','$position','$age')";

    if(!$conn->query($sql)){
        die("Insert error: " . $conn->error);
    }
}

/* DELETE PLAYER (COACH ONLY) */
if(isset($_GET["delete"]) && isset($_SESSION["role"]) && $_SESSION["role"]=="coach"){

    $id = $_GET["delete"];

    $sql = "DELETE FROM players WHERE id=$id";

    if(!$conn->query($sql)){
        die("Delete error: " . $conn->error);
    }
}

/* GET PLAYERS */
$result = $conn->query("SELECT * FROM players");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Players</title>
    <link rel="stylesheet" href="style.css">

    <style>
    .main{
        margin-left:220px;
        padding:25px;
    }

    h1{
        color:#00c2ff;
    }

    table{
        width:100%;
        margin-top:20px;
        border-collapse:collapse;
        background:rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        color:white;
    }

    th{
        background:#00c2ff;
        color:black;
        padding:12px;
    }

    td{
        padding:12px;
        text-align:center;
        border-bottom:1px solid rgba(255,255,255,0.1);
    }

    tr:hover{
        background:rgba(0,194,255,0.1);
    }

    input, button{
        padding:10px;
        margin:5px;
        border-radius:8px;
        border:none;
    }

    button{
        background:#00c2ff;
        cursor:pointer;
    }

    a{
        text-decoration:none;
        padding:5px 10px;
        border-radius:5px;
    }

    .delete{
        background:#ff004c;
        color:white;
    }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>FCB Panel</h2>

    <a href="index.php">Dashboard</a>
    <a href="players.php">Players</a>
    <a href="matches.php">Matches</a>
    <a href="injuries.php">Injuries</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h1>⚽ Players Management</h1>

<!-- ADD FORM -->
<?php if(isset($_SESSION["role"]) && $_SESSION["role"]=="coach"){ ?>
<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="position" placeholder="Position" required>
    <input type="number" name="age" placeholder="Age" required>

    <button type="submit" name="add">Add Player</button>
</form>
<?php } ?>

<!-- TABLE -->
<table>
<tr>
    <th>Name</th>
    <th>Position</th>
    <th>Age</th>
    <th>Actions</th>
</tr>

<?php while($r = $result->fetch_assoc()){ ?>

<tr>
    <td><?= $r["name"] ?></td>
    <td><?= $r["position"] ?></td>
    <td><?= $r["age"] ?></td>

    <td>
        <?php if($_SESSION["role"]=="coach"){ ?>
            <a class="delete" href="?delete=<?= $r['id'] ?>">Delete</a>
            <a href="editplayers.php?id=<?= $r['id'] ?>">Edit</a>
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