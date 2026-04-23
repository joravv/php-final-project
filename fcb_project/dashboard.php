<?php session_start(); ?>

<h1>Welcome <?php echo $_SESSION["user"]; ?></h1>

<a href="players.php">Players</a><br>
<a href="matches.php">Matches</a><br>
<a href="injuries.php">Injuries</a><br>
<a href="logout.php">Logout</a>