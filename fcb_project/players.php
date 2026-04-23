<?php include "db.php";

if(isset($_POST["add"])){
$name=$_POST["name"];
$position=$_POST["position"];
$age=$_POST["age"];

$conn->query("INSERT INTO players(name,position,age)
VALUES('$name','$position','$age')");
}

$res=$conn->query("SELECT * FROM players");
?>

<h1>Players</h1>

<form method="POST">
<input name="name" placeholder="Name">
<input name="position" placeholder="Position">
<input name="age" placeholder="Age">
<button name="add">Add</button>
</form>

<table border="1">
<tr><th>Name</th><th>Position</th><th>Age</th></tr>
<?php while($row=$res->fetch_assoc()){ ?>
<tr>
<td><?php echo $row["name"]; ?></td>
<td><?php echo $row["position"]; ?></td>
<td><?php echo $row["age"]; ?></td>
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
  <li><a href="dashboard.php">Home</a></li>
<li><a href="players.php">Players</a></li>
<li><a href="matches.php">Matches</a></li>
<li><a href="injuries.php">Injuries</a></li>
</ul>  
        
</div>
</div>
</body>
</html>