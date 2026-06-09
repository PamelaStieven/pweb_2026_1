<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

$db = new db("emprestimo");

$id = $_GET['id'];

if($_POST){
    $db->update($id, [
        "livro_id" => $_POST['livro_id'],
        "usuario_id" => $_POST['usuario_id'],
        "data_emprestimo" => $_POST['data_emprestimo'],
        "data_devolucao" => $_POST['data_devolucao']
    ]);

    header("Location: index.php");
}

$dado = $db->find($id);
?>

<h2>Editar Empréstimo</h2>

<form method="POST">
    <input type="number" name="livro_id" value="<?= $dado['livro_id'] ?>" required>
    <input type="number" name="usuario_id" value="<?= $dado['usuario_id'] ?>" required>

    <input type="date" name="data_emprestimo" value="<?= $dado['data_emprestimo'] ?>" required>
    <input type="date" name="data_devolucao" value="<?= $dado['data_devolucao'] ?>">

    <button>Atualizar</button>
</form>