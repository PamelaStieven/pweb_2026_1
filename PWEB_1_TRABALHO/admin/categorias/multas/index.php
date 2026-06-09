<?php
require_once("../../auth/auth.php");
require_once("../../database/db.class.php");

$db = new db("multas");

$busca = $_GET['busca'] ?? '';

if($busca){
    $dados = $db->search([
        "tipo" => "motivo",
        "valor" => $busca
    ]);
}else{
    $dados = $db->all();
}
?>

<h2>Multas</h2>

<form>
<input name="busca" placeholder="Buscar motivo" required>
<button>Buscar</button>
</form>

<a href="create.php">Nova Multa</a>

<?php foreach($dados as $m): ?>
<p>
ID: <?= $m->id ?> |
Valor: <?= $m->valor ?> |
Motivo: <?= $m->motivo ?> |
Status: <?= $m->status ?>

<a href="edit.php?id=<?= $m->id ?>">Editar</a>
<a href="delete.php?id=<?= $m->id ?>">Excluir</a>
</p>
<?php endforeach; ?>