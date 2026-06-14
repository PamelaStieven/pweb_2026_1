<?php
session_start();

require_once "db.class.php";
$db = new db('usuario');

$id = $_GET['id'] ?? '';
$usuario = null;

// Se veio ID na URL, significa que estamos EDITANDO, então busca os dados dele
if ($id != '') {
    $usuario = $db->find($id);
}

// Verifica se o formulário foi enviado
if (!empty($_POST)) {
    $dados = [
        'nome'      => $_POST['nome'],
        'sobrenome' => $_POST['sobrenome'],
        'telefone'  => $_POST['telefone'],
        'email'     => $_POST['email'],
        'login'     => $_POST['login'],
        'senha'     => $_POST['senha']
    ];

    if ($_POST['id'] != '') {
        // Se já tem ID escondido no formulário, atualiza
        $dados['id'] = $_POST['id'];
        $db->update($dados);
    } else {
        // Se não tem ID, é um cadastro novo
        $db->store($dados);
    }

    // Depois de salvar, volta para a listagem
    header("Location: UsuarioList.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4"><?php echo $usuario ? 'Editar Usuário' : 'Cadastrar Usuário'; ?></h2>

                    <form action="UsuarioForm.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $usuario->id ?? ''; ?>">

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $usuario->nome ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sobrenome</label>
                            <input type="text" name="sobrenome" class="form-control" value="<?php echo $usuario->sobrenome ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="<?php echo $usuario->telefone ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $usuario->email ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Usuário (Login)</label>
                            <input type="text" name="login" class="form-control" value="<?php echo $usuario->login ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="text" name="senha" class="form-control" value="<?php echo $usuario->senha ?? ''; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar Dados</button>
                        <a href="UsuarioList.php" class="btn btn-outline-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>