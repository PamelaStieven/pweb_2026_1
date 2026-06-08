<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

$db = new db("multas");

if($_POST){
    $db->update($_POST);
    header("Location: index.php");
}

$dado = $db->find($_GET['id']);
?>

<h2>Editar Multa</h2>

<form method="POST">
<input type="hidden" name="id" value="<?= $dado->id ?>">

<input name="emprestimo_id" value="<?= $dado->emprestimo_id ?>" required>
<input name="valor" value="<?= $dado->valor ?>" required>
<input name="motivo" value="<?= $dado->motivo ?>" required>
<input name="status" value="<?= $dado->status ?>" required>

<button>Atualizar</button>
</form>