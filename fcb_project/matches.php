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
$op=$_POST["opponent"];
$date=$_POST["date"];
$stadium=$_POST["stadium"];

$conn->query("INSERT INTO matches(opponent,match_date,stadium)
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
<td><?php echo $r["match_date"]; ?></td>
<td><?php echo $r["stadium"]; ?></td>
</tr>
<?php } ?>
</table>

