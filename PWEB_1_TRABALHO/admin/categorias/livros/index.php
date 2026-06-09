<?php
require_once("../../auth/auth.php");
require_once("../../database/db.class.php");

$db = new db("livros");

$busca = $_GET['busca'] ?? '';

if($busca){
    $dados = $db->search([
        "tipo" => "titulo",
        "valor" => $busca
    ]);
}else{
    $dados = $db->all();
}
?>

<h2>Livros</h2>

<form>
<input name="busca" placeholder="Buscar" required>
<button>Buscar</button>
</form>

<a href="create.php">Novo</a>

<?php foreach($dados as $d): ?>
<p>
<?= $d->titulo ?>
<a href="edit.php?id=<?= $d->id ?>">Editar</a>
<a href="delete.php?id=<?= $d->id ?>">Excluir</a>
</p>
<?php endforeach; ?>