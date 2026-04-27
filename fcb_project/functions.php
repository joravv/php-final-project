<?php

function isLoggedIn(){
    return isset($_SESSION["user"]);
}

function checkLogin(){
    if(!isLoggedIn()){
        header("Location: login.php");
        exit();
    }
}

?>