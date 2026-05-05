<?php
session_start();
include "db.php";


if(!isset($_SESSION["user"]) || $_SESSION["role"] != "coach"){
    die("Access denied");
}


$playersRes = $conn->query("SELECT * FROM players");
$players = [];

while($row = $playersRes->fetch_assoc()){
    $players[] = $row;
}

if(isset($_POST["save"])){

    $formation = $_POST["formation"];

    
    $conn->query("UPDATE lineups SET is_active = 0");

    if(isset($_POST["position"]) && is_array($_POST["position"])){

        foreach($_POST["position"] as $pos => $player_id){

            if($player_id != ""){

                $conn->query("
                    INSERT INTO lineups (formation, position, player_id, is_active)
                    VALUES ('$formation', '$pos', '$player_id', 1)
                ");
            }
        }
    }

    header("Location: coachboard.php?saved=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tactical Board</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="navbar">
    <h2>FCB Tactical Board</h2>
</div>

<h1> Coach Tactical Board</h1>

<?php if(isset($_GET["saved"])){ ?>
    <p style="text-align:center; color:#00ff88;">Lineup saved!</p>
<?php } ?>

<form method="POST">

<div style="text-align:center;">
    <label>Formation:</label>
    <select name="formation">
        <option value="4-3-3">4-3-3</option>
        <option value="4-2-3-1">4-2-3-1</option>
        <option value="3-5-2">3-5-2</option>
    </select>
</div>

<br>


<div class="pitch">

<?php

$positions = [
    "ST",
    "LW","RW",
    "CM1","CM2","CM3",
    "LB","CB1","CB2","RB",
    "GK"
];

foreach($positions as $pos){
    echo "<div><strong>$pos</strong><br>";
    echo "<select name='position[$pos]'>";
    echo "<option value=''>-- Select Player --</option>";

    foreach($players as $p){
        echo "<option value='".$p['id']."'>".$p['name']."</option>";
    }

    echo "</select></div>";
}
?>

</div>

<button name="save"> Save Starting XI</button>

<a href="index.php" class="back-btn"> Back to Dashboard</a>

</form>

</body>
</html>