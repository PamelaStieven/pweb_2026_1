<?php
session_start();

require_once "db.class.php";
$db = new db('usuario');
$mensagem_erro = '';

// Força a inserção do administrador básico se a tabela estiver vazia
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
        // Busca o usuário pelo login digitado
        $usuario = $db->findBy('login', $login);

        // Se retornar uma lista (array), extrai o primeiro objeto encontrado
        if (is_array($usuario) && !empty($usuario)) {
            $usuario = $usuario[0];
        }

        // Verifica se o usuário existe e se a senha bate exatamente com a do banco
        if ($usuario && $usuario->senha == $senha) {
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario->id;
            $_SESSION['usuario_nome'] = $usuario->nome . " " . $usuario->sobrenome;
            $_SESSION['usuario_email'] = $usuario->email;

            // Manda com sucesso para o painel de controle
            header("Location: index.php");
            exit();
        } else {
            $mensagem_erro = "Usuário ou senha incorretos!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema</title>
</head>
<body>

    <h2>Login do Sistema</h2>

    <?php if ($mensagem_erro != ''): ?>
        <p style="color: red;"><b><?php echo $mensagem_erro; ?></b></p>
    <?php endif; ?>

    <form action="" method="post">
        <p>
            <label>Usuário:</label><br>
            <input type="text" name="login" value="<?php echo $_POST['login'] ?? ''; ?>" required>
        </p>
        
        <p>
            <label>Senha:</label><br>
            <input type="password" name="senha" required>
        </p>
        
        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>

    <p>Não tem conta? <a href="registrar.php">Crie aqui!</a></p>
    <p><a href="../../index.php">Voltar ao site</a></p>

</body>
</html>