


<?php 
	
	include "db.php";

	$id = $_GET['id'];
	$sql = "DELETE FROM players WHERE id=:id";
	$prep = $conn->prepare($sql);
	$prep->bindParam(':id',$id);
	$prep->execute();

	header("Location: players.php");
 ?>