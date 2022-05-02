<?php


function autenticado() : bool {

    session_start();
    
    $auth = $_SESSION['login'] ?? false;
    
    if (!$auth){
        return false;
    }
    
    return true;
}

?>