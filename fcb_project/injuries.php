<?php include "db.php";

if(isset($_POST["add"])){
$p=$_POST["player"];
$s=$_POST["status"];

$conn->query("INSERT INTO injuries(player,status)
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
<td><?php echo $r["player"]; ?></td>
<td><?php echo $r["status"]; ?></td>
</tr>
<?php } ?>
</table>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="navbar">
      
        <div class="nav-links">
         <ul>
 <li> <a href="dashboard.php">Home</a></li>
<li><a href="players.php">Players</a></li>
<li><a href="matches.php">Matches</a></li>
<li><a href="injuries.php">Injuries</a></li>
</ul>  
        
</div>
</div>
</body>
</html>