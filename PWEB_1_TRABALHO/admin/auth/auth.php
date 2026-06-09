
<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['usuario'])){
    header("Location: /pweb_2026_1/PWEB_1_TRABALHO/admin/auth/login.php");
    exit;
}