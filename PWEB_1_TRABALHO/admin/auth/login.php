<?php
session_start();

require_once ('../../db.class.php');

$erro = '';

if($_POST){
    $db = new db("usuario");

    $usuario = $db->findBy("login", $_POST['login']);

    if($usuario && password_verify($_POST['senha'], $usuario->senha)){
        $_SESSION['usuario'] = $usuario;
        header("Location: ../index.php");
        exit;
    }

    $erro = "Login inválido";
}
?>

<form method="POST">
    <input name="login" placeholder="Login" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button>Entrar</button>
</form>

<?= $erro ?>