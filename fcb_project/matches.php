<?php include "db.php";

if(isset($_POST["add"])){
$op=$_POST["opponent"];
$date=$_POST["date"];
$stadium=$_POST["stadium"];

$conn->query("INSERT INTO matches(opponent,date,stadium)
VALUES('$op','$date','$stadium')");
}

$res=$conn->query("SELECT * FROM matches");
?>

<h1>Matches</h1>

<form method="POST">
<input name="opponent" placeholder="Opponent">
<input name="date" type="date">
<input name="stadium" placeholder="Stadium">
<button name="add">Add</button>
</form>

<table border="1">
<tr><th>Opponent</th><th>Date</th><th>Stadium</th></tr>
<?php while($r=$res->fetch_assoc()){ ?>
<tr>
<td><?php echo $r["opponent"]; ?></td>
<td><?php echo $r["date"]; ?></td>
<td><?php echo $r["stadium"]; ?></td>
</tr>
<?php } ?>
</table>