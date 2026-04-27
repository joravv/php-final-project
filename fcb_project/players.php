<?php
session_start();
include "db.php";
include "functions.php";
checkLogin();

// ADD PLAYER (CRUD CREATE)
if(isset($_POST["add"])){

    $stmt = $pdo->prepare("INSERT INTO players(name,position,age,goals,assists)
    VALUES(?,?,?,?,?)");

    $stmt->execute([
        $_POST["name"],
        $_POST["position"],
        $_POST["age"],
        $_POST["goals"],
        $_POST["assists"]
    ]);
}

// GET PLAYERS (READ)
$stmt = $pdo->query("SELECT * FROM players");
$players = $stmt->fetchAll();
?>

<h1>Players</h1>

<form method="POST">
<input name="name" placeholder="Name">
<input name="position" placeholder="Position">
<input name="age" placeholder="Age">
<input name="goals" placeholder="Goals">
<input name="assists" placeholder="Assists">
<button name="add">Add</button>
</form>

<table border="1">
<tr>
<th>Name</th>
<th>Position</th>
<th>Age</th>
<th>Actions</th>
</tr>

<?php foreach($players as $p){ ?>  <!-- LOOP -->
<tr>
<td><?php echo $p["name"]; ?></td>
<td><?php echo $p["position"]; ?></td>
<td><?php echo $p["age"]; ?></td>

<td>
<a href="delete_player.php?id=<?php echo $p["id"]; ?>">Delete</a>
</td>

</tr>
<?php } ?>

</table>