<?php
include "db.php";

$id = $_GET["id"];

$stmt = $pdo->prepare("DELETE FROM players WHERE id=?");
$stmt->execute([$id]);

header("Location: players.php");