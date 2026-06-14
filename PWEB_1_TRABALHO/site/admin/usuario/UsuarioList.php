<?php
session_start();

// Puxa a classe do banco
require_once "db.class.php";
$db = new db('usuario');

// Se o usuário clicou em excluir, deleta direto pelo ID
if (!empty($_GET['excluir_id'])) {
    $db->destroy($_GET['excluir_id']);
    header("Location: UsuarioList.php");
    exit();
}

// Se tiver alguma busca, usa o método search, senão lista tudo (all)
if (!empty($_POST['valor'])) {
    $dados_busca = [
        'tipo' => 'nome', // busca pelo campo nome
        'valor' => $_POST['valor']
    ];
    $lista = $db->search($dados_busca);
} else {
    $lista = $db->all();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Lista de Usuários</h2>

            <form action="UsuarioList.php" method="post" class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" name="valor" class="form-control" placeholder="Buscar por nome...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Buscar</button>
                </div>
                <div class="col-md-6 text-end">
                    <a href="UsuarioForm.php" class="btn btn-success">Cadastrar Novo</a>
                </div>
            </form>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Login</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $item): ?>
                        <tr>
                            <td><?php echo $item->id; ?></td>
                            <td><?php echo $item->nome . " " . $item->sobrenome; ?></td>
                            <td><?php echo $item->telefone; ?></td>
                            <td><?php echo $item->email; ?></td>
                            <td><?php echo $item->login; ?></td>
                            <td>
                                <a href="UsuarioForm.php?id=<?php echo $item->id; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="UsuarioList.php?excluir_id=<?php echo $item->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Quer mesmo deletar?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="mt-3">
                <a href="index.php" class="btn btn-outline-dark">Voltar ao Painel</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>