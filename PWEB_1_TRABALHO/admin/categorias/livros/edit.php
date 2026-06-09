<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

$db = new db("livros");

if($_POST){
    $db->update($_POST);
    header("Location: index.php");
}

$dado = $db->find($_GET['id']);
?>

<h2>Editar</h2>

<form method="POST">
<input type="hidden" name="id" value="<?= $dado->id ?>">
<input name="titulo" value="<?= $dado->titulo ?>" required>
<input name="genero" value="<?= $dado->genero ?>" required>
<input name="ano" value="<?= $dado->ano ?>" required>
<button>Atualizar</button>
</form>