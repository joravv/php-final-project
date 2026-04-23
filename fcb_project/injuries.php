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