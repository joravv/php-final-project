<?php
session_start();
include "db.php";

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

$playersCount = $conn->query("SELECT COUNT(*) as t FROM players")->fetch_assoc()['t'];
$matchesCount = $conn->query("SELECT COUNT(*) as t FROM matches")->fetch_assoc()['t'];
$injuriesCount = $conn->query("SELECT COUNT(*) as t FROM injuries")->fetch_assoc()['t'];

$nextMatch = $conn->query("SELECT * FROM matches ORDER BY match_date ASC LIMIT 1")->fetch_assoc();
$daysLeft = $nextMatch ? max(0, floor((strtotime($nextMatch['match_date'])-time())/86400)) : 0;

$latestPlayers = $conn->query("SELECT name FROM players ORDER BY id DESC LIMIT 3");

$lineup = $conn->query("
    SELECT l.position, p.name
    FROM lineups l
    JOIN players p ON l.player_id = p.id
    WHERE l.is_active = 1
");

$appearance = $conn->query("
    SELECT pa.*, p.name
    FROM player_appearance pa
    JOIN players p ON pa.player_id = p.id
");

$kits = $conn->query("
    SELECT p.name,
           pa.kit,
           pa.boots
    FROM player_appearance pa
    JOIN players p ON pa.player_id = p.id
");

?>

<!DOCTYPE html>
<html>
<head>
<title>FCB Dashboard</title>
<link rel="stylesheet" href="style.css">

<style>

.main{
    margin-left:220px;
    padding:30px;
}

h1{
    font-size:32px;
    background: linear-gradient(90deg,#ff004c,#00c2ff);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}


.stats{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    margin-top:20px;
}

.stat-box{
    flex:1;
    min-width:180px;
    padding:20px;
    border-radius:15px;
    background:rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    box-shadow:0 8px 25px rgba(0,0,0,0.3);
    transition:0.3s;
}

.stat-box:hover{
    transform:translateY(-5px);
    background:rgba(0,194,255,0.2);
}

.stat-box h3{
    font-size:28px;
    color:#00c2ff;
}


.card{
    margin-top:25px;
    padding:20px;
    border-radius:15px;
    background:rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    box-shadow:0 8px 25px rgba(0,0,0,0.3);
}


.countdown{
    font-size:28px;
    font-weight:bold;
    color:#ff004c;
    margin-top:10px;
}


.activity li{
    list-style:none;
    padding:8px;
    margin:5px 0;
    background:rgba(255,255,255,0.05);
    border-left:4px solid #00c2ff;
    border-radius:5px;
}

.coach-panel{
    border-left:4px solid #ffcc00;
}

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:200px;
    height:100%;
    background:#0b0f1a;
    padding:20px;
}

.sidebar a{
    display:block;
    color:#aaa;
    padding:10px;
    text-decoration:none;
    margin:5px 0;
}

.sidebar a:hover{
    color:#00c2ff;
}

</style>

</head>

<body>


<div class="sidebar">
<h2 style="color:#00c2ff;">FCB Panel</h2>

<a href="index.php"> Dashboard</a>
<a href="players.php"> Players</a>
<a href="matches.php"> Matches</a>
<a href="injuries.php"> Injuries</a>

<?php if($_SESSION["role"]=="coach"){ ?>
<a href="coachboard.php"> Tactical Board</a>
<?php } ?>

<a href="logout.php"> Logout</a>
</div>

<div class="main">

<h1>Club Dashboard</h1>

<?php if($_SESSION["role"]=="coach"){ ?>
<div class="card coach-panel">
    <h2> Coach Panel</h2>
    <p>Manage lineup, tactics and formations like a real club coach.</p>

    <a href="coachboard.php"
       style="display:inline-block; margin-top:10px; padding:10px 15px;
       background:#ffcc00; color:black; border-radius:8px;
       font-weight:bold; text-decoration:none;">
        Open Tactical Board
    </a>
</div>
<?php } ?>

<?php if($_SESSION["role"] == "staff"){ ?>
<div class="card" style="border-left:4px solid #00c2ff;">
    <h2> Staff Kit Control</h2>

    <p>
        Manage player kits and boots for training and matchdays.
    </p>

    <a href="kitboard.php"
       style="display:inline-block; margin-top:10px; padding:10px 15px;
       background:#00c2ff; color:black; border-radius:8px;
       font-weight:bold; text-decoration:none;">

        Open Kit Manager
    </a>
</div>
<?php } ?>

<div class="stats">

<div class="stat-box">
<h3><?= $playersCount ?></h3>
<p> Players</p>
</div>

<div class="stat-box">
<h3><?= $matchesCount ?></h3>
<p> Matches</p>
</div>

<div class="stat-box">
<h3><?= $injuriesCount ?></h3>
<p> Injuries</p>
</div>

</div>

<div class="card">
<h2> Next Match</h2>

<?php if($nextMatch){ ?>
<p>Opponent: <b><?= $nextMatch['opponent'] ?></b></p>
<p>Date: <?= $nextMatch['match_date'] ?></p>

<div class="countdown">
<?= $daysLeft ?> DAYS LEFT
</div>

<?php } else { ?>
<p>No match scheduled</p>
<?php } ?>

</div>

<div class="card">
<h2> Recent Activity</h2>

<ul class="activity">
<?php while($p = $latestPlayers->fetch_assoc()){ ?>
<li>New player added: <b><?= $p['name'] ?></b></li>
<?php } ?>
</ul>

</div>

<div class="card">
    <h2> Starting XI</h2>

    <?php if($lineup->num_rows > 0){ ?>
        <ul class="activity">
            <?php while($l = $lineup->fetch_assoc()){ ?>
                <li>
                    <b><?= $l['position'] ?>:</b> <?= $l['name'] ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No lineup set yet</p>
    <?php } ?>
</div>

<div class="card">
<h2> Kits & Boots</h2>

<?php while($k = $kits->fetch_assoc()){ ?>

<div style="display:flex; gap:15px; margin:10px 0; align-items:center;">
    <b><?= $k['name'] ?></b>

    <img src="img/kit<?= $k['kit'] ?>.png" width="60">
    <img src="img/boot<?= $k['boots'] ?>.png" width="60">
</div>

<?php } ?>
</div>

</div>

</body>
</html>