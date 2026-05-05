<?php
session_start();
include "db.php";

/* LOGIN CHECK */
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

/* SAVE KITS & BOOTS */
if(isset($_POST["save"])){

    // delete old selections
    $conn->query("DELETE FROM player_appearance");

    // save new selections
    if(isset($_POST["kit"]) && isset($_POST["boots"])){

        foreach($_POST["kit"] as $player_id => $kit){

            $boot = $_POST["boots"][$player_id] ?? 1;

            $conn->query("
                INSERT INTO player_appearance (player_id, kit, boots)
                VALUES ('$player_id', '$kit', '$boot')
            ");
        }

        $success = "Kits saved successfully!";
    }
}

/* GET PLAYERS */
$players = $conn->query("SELECT * FROM players");

/* GET SAVED DATA */
$saved = $conn->query("
    SELECT pa.*, p.name
    FROM player_appearance pa
    JOIN players p ON pa.player_id = p.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Kit Manager</title>

<style>
body{
    font-family:Arial;
    background:#0b0f1a;
    color:white;
}

.main{
    margin-left:220px;
    padding:30px;
}

.card{
    background:rgba(255,255,255,0.08);
    padding:20px;
    border-radius:15px;
    margin-top:20px;
}

.player-box{
    padding:15px;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.row{
    display:flex;
    gap:30px;
    margin-top:10px;
}

button{
    margin-top:20px;
    padding:10px 15px;
    background:#00c2ff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.success{
    background:#00c851;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

.back-btn{
    display:inline-block;
    margin-bottom:15px;
    padding:8px 12px;
    background:#ffcc00;
    color:black;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="main">

<a class="back-btn" href="index.php">⬅ Back to Dashboard</a>

<h1>👕 Kit & Boots Manager</h1>

<?php if(isset($success)){ ?>
    <div class="success"><?= $success ?></div>
<?php } ?>

<form method="POST">

<div class="card">

<?php while($p = $players->fetch_assoc()){ ?>

<div class="player-box">

    <b><?= $p['name'] ?></b>

    <div class="row">

        <!-- KITS -->
        <div>
            <p>Kit</p>
            <?php for($i=1; $i<=3; $i++){ ?>
                <label>
                    <input type="radio" name="kit[<?= $p['id'] ?>]" value="<?= $i ?>" required>
                    <img src="img/kit<?= $i ?>.png" width="60">
                </label>
            <?php } ?>
        </div>

        <!-- BOOTS -->
        <div>
            <p>Boots</p>
            <?php for($i=1; $i<=3; $i++){ ?>
                <label>
                    <input type="radio" name="boots[<?= $p['id'] ?>]" value="<?= $i ?>" required>
                    <img src="img/boot<?= $i ?>.png" width="60">
                </label>
            <?php } ?>
        </div>

    </div>
</div>

<?php } ?>

</div>

<button type="submit" name="save">Save Kits</button>

</form>

</div>

</body>
</html>