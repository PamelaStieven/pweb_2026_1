<?php
session_start();
require_once "db.class.php";
$db = new db('usuario');
$mensagem = '';

if (!empty($_POST)) {
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? ''; 

    if (empty($nome) || empty($sobrenome) || empty($login) || empty($senha)) {
        $mensagem = "Por favor, preencha os campos obrigatórios!";
    } else {
        $db->store([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'telefone' => $telefone,
            'email' => $email,
            'login' => $login,
            'senha' => $senha                  
        ]);

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nova Conta - ACCIO LIBRARY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="col-12 col-sm-10 col-md-6 col-lg-5">
            
            <div class="card shadow-sm border-0 p-4">
                <div class="card-body">
                    
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-user-plus fa-3x mb-3" style="color: #ffc107;"></i>
                        <h4 class="fw-bold text-dark">Criar Nova Conta</h4>
                        <p class="text-muted small">Preencha os dados abaixo para se registrar</p>
                    </div>

                    <?php if ($mensagem != ''): ?>
                        <div class="alert alert-danger p-2 text-center small mb-3">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $mensagem; ?>
                        </div>
                    <?php endif; ?>

                    <form action="registrar.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small fw-bold">Nome *</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small fw-bold">Sobrenome *</label>
                                <input type="text" name="sobrenome" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Telefone</label>
                            <input type="text" name="telefone" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Nome de Usuário *</label>
                            <input type="text" name="login" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Senha *</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold text-dark py-2" style="background-color: #ffc107;">CADASTRAR</button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="small text-muted">Já tem uma conta? <a href="login.php" class="text-decoration-none fw-bold" style="color: #ffc107;">Faça o Login aqui</a></p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>