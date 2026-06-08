<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

if($_POST){
    $db = new db("multas");

    $db->store([
        "emprestimo_id" => $_POST['emprestimo_id'],
        "valor" => $_POST['valor'],
        "motivo" => $_POST['motivo'],
        "status" => $_POST['status']
    ]);

    header("Location: index.php");
}
?>

<h2>Nova Multa</h2>

<form method="POST">
<input name="emprestimo_id" placeholder="ID Empréstimo" required>
<input name="valor" placeholder="Valor" required>
<input name="motivo" placeholder="Motivo" required>
<input name="status" placeholder="Status" required>

<button>Salvar</button>
</form>