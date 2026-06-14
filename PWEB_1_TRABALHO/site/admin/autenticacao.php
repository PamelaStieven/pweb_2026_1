<?php
// Força o arquivo de autenticação a também mostrar os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão se ela já não tiver sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Corrigindo o caminho da classe do banco para a pasta atual
require_once "db.class.php";

// Se o usuário não estiver logado, chuta ele de volta para a tela de login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: login.php");
    exit();
}