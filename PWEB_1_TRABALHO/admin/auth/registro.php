<?php
require_once("../database/db.class.php");

if($_POST){

    $db = new db("usuario");

    $senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $db->store([
        "nome" => $_POST['nome'],
        "sobrenome" => $_POST['sobrenome'],
        "email" => $_POST['email'],
        "telefone" => $_POST['telefone'],
        "login" => $_POST['login'],
        "senha" => $senhaHash
    ]);

    echo "Cadastrado!";
}
?>

<form method="POST">
<input name="nome" required>
<input name="sobrenome">
<input name="email" required>
<input name="telefone">
<input name="login" required>
<input name="senha" required>
<button>Cadastrar</button>
</form>