<?php
include "db.php";



     if(isset($_POST["add"])){ $name = $_POST["name"];
      $position = $_POST["position"]; $age = $_POST["age"];
       $conn->query("INSERT INTO players(name, position, age) VALUES('$name','$position','$age')");
        }  if(isset($_GET["delete"])){ $id = $_GET["delete"];
         $conn->query("DELETE FROM players WHERE id=$id");
          }  $result = $conn->query("SELECT * FROM players"); 
          $res=$conn->query("SELECT * FROM players");
          ?> 
          <!DOCTYPE html> <html> <head> <title>Players</title> 
          <link rel="stylesheet" href="style.css">
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
<h2>Players</h2> 
        
         <h1>Manage Players</h1>
          </div> 
          <div class="form-container"> 
            <form method="POST"> 
                <input name="name" placeholder="Name" required>
                 <input name="position" placeholder="Position" required> 
                 <input name="age" placeholder="Age" required> <button name="add">Add Player</button>
                 </form>
                 </div>

                 <table border="1">
<tr><th>Player</th><th>Position</th><th>Age</th></tr>
 while($r=$res->fetch_assoc()){ <?>
<tr>
<td><?php echo $r["name"]; ?></td>  
<td><?php echo $r["position"]; ?></td>
<td><?php echo $r["age"]; ?></td>
<td><a href="deleteplayers.php?id=<?=$r['id'];?>">Delete</a></td>
<td><a href="editplayers.php?id=<?= $r['id'];?>">Update</a></td>
</tr>

<?php } ?>
</table>





