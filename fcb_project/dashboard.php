<?php include "auth.php"; ?>

<h1>Welcome <?php echo $_SESSION["user"]; ?></h1>
<h3>Role: <?php echo $_SESSION["role"]; ?></h3>

<a href="players.php">Players</a>
<a href="injuries.php">Injuries</a>
<a href="matches.php">Matches</a>