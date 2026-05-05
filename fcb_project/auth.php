<?php
session_start();

/* ONLY BLOCK IF NOT LOGGED IN */
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}
?>