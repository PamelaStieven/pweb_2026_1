<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

if($_POST){
    $db = new db("emprestimo");

    $db->store([
        "livro_id" => $_POST['livro_id'],
        "usuario_id" => $_POST['usuario_id'],
        "data_emprestimo" => $_POST['data_emprestimo'],
        "data_devolucao" => $_POST['data_devolucao']
    ]);

    header("Location: index.php");
}
?>

<h2>Novo Empréstimo</h2>

<form method="POST">
    <input type="number" name="livro_id" placeholder="ID do Livro" required>
    <input type="number" name="usuario_id" placeholder="ID do Usuário" required>

    <label>Data Empréstimo</label>
    <input type="date" name="data_emprestimo" required>

    <label>Data Devolução</label>
    <input type="date" name="data_devolucao">

    <button>Salvar</button>
</form>