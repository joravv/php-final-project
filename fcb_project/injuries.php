     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar">
    <h2>FCB Staff</h2>

    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="players.php">Players</a></li>
        <li><a href="matches.php">Matches</a></li>
        <li><a href="injuries.php">Injuries</a></li>
    </ul>
</div>
        
</div>
</div>
</body>
</html>
<?php include "db.php";

if(isset($_POST["add"])){
$p=$_POST["player"];
$s=$_POST["status"];

$conn->query("INSERT INTO injuries(player_name,status)
VALUES('$p','$s')");
}

$res=$conn->query("SELECT * FROM injuries");
?>

<h1>Injuries</h1>

<form method="POST">
<input name="player" placeholder="Player">
<select name="status">
<option>Injured</option>
<option>Recovering</option>
<option>Fit</option>
</select>
<button name="add">Add</button>
</form>

<table border="1">
<tr><th>Player</th><th>Status</th></tr>
<?php while($r=$res->fetch_assoc()){ ?>
<tr>
<td><?php echo $r["player_name"]; ?></td>
<td><?php echo $r["status"]; ?></td>
</tr>
<?php } ?>
</table>

