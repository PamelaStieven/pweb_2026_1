<?php
session_start();

require_once "db.class.php";
$db = new db('usuario');
$mensagem_erro = '';

try {
    $teste_usuario = $db->findBy('login', 'admin');
    if (is_array($teste_usuario) && !empty($teste_usuario)) {
        $teste_usuario = $teste_usuario[0];
    }

    if (!$teste_usuario) {
        $db->store([
            'nome' => 'Administrador',
            'sobrenome' => 'adm',
            'telefone' => '49999999999',
            'email' => 'admin@ifsc.com',
            'login' => 'admin',
            'senha' => '123'
        ]);
    }
} catch (Exception $e) {
    $mensagem_erro = "Aviso: Verifique se a tabela 'usuario' existe.";
}

if (!empty($_POST)) {
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($login) || empty($senha)) {
        $mensagem_erro = "Preencha todos os campos!";
    } else {
        $usuario = $db->findBy('login', $login);

        if (is_array($usuario) && !empty($usuario)) {
            $usuario = $usuario[0];
        }

        if ($usuario && $usuario->senha == $senha) {
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario->id;
            $_SESSION['usuario_nome'] = $usuario->nome . " " . $usuario->sobrenome;
            $_SESSION['usuario_email'] = $usuario->email;

            header("Location: index.php");
            exit();
        } else {
            $mensagem_erro = "Usuário ou senha incorretos!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ACCIO LIBRARY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-12 col-sm-8 col-md-5 col-lg-4">
            
            <div class="card shadow-sm border-0 p-4">
                <div class="card-body">
                    
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-book-bookmark fa-3x mb-3" style="color: #ffc107;"></i>
                        <h4 class="fw-bold text-dark">ACCIO LIBRARY</h4>
                        <p class="text-muted small">Faça login para acessar o sistema</p>
                    </div>

                    <?php if ($mensagem_erro != ''): ?>
                        <div class="alert alert-danger p-2 text-center small mb-3">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $mensagem_erro; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Usuário</label>
                            <input type="text" name="login" class="form-control" value="<?php echo $_POST['login'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn w-100 fw-bold text-dark py-2" style="background-color: #ffc107;">ENTRAR</button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="small text-muted">Não tem conta? <a href="registrar.php" class="text-decoration-none fw-bold" style="color: #ffc107;">Crie aqui!</a></p>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>