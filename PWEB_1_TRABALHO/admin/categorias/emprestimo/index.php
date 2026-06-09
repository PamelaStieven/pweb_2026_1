<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

$db = new db("emprestimo");

$busca = $_GET['busca'] ?? '';

$dados = $db->all();

if($busca){
    $dados = array_filter($dados, function($row) use ($busca){
        return stripos($row['livro_id'], $busca) !== false ||
               stripos($row['usuario_id'], $busca) !== false;
    });
}
?>

<h2>Empréstimos</h2>

<form method="GET">
    <input type="text" name="busca" placeholder="Buscar ID livro/usuário" value="<?= $busca ?>">
    <button>Buscar</button>
</form>

<a href="create.php">Novo Empréstimo</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Livro</th>
    <th>Usuário</th>
    <th>Data Empréstimo</th>
    <th>Data Devolução</th>
    <th>Ações</th>
</tr>

<?php foreach($dados as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['livro_id'] ?></td>
    <td><?= $row['usuario_id'] ?></td>
    <td><?= $row['data_emprestimo'] ?></td>
    <td><?= $row['data_devolucao'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>">Editar</a>
        <a href="delete.php?id=<?= $row['id'] ?>" 
        onclick="return confirm('Tem certeza?')">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>

</table>