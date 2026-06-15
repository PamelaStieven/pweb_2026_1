<?php
session_start();
require_once "db.class.php";
$db = new db('usuario');
$mensagem = '';

if (!empty($_POST)) {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $senha = $_POST['senha']; 

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

        // Avisa que deu certo e manda para o login
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Criar Nova Conta</title>
</head>
<body>

    <h2>Criar Nova Conta no Sistema</h2>

    <?php if ($mensagem != ''): ?>
        <p style="color: red;"><b><?php echo $mensagem; ?></b></p>
    <?php endif; ?>

    <form action="registrar.php" method="post">
        <p>
            <label>Nome *</label><br>
            <input type="text" name="nome" required>
        </p>

        <p>
            <label>Sobrenome *</label><br>
            <input type="text" name="sobrenome" required>
        </p>

        <p>
            <label>Telefone</label><br>
            <input type="text" name="telefone">
        </p>

        <p>
            <label>E-mail</label><br>
            <input type="email" name="email">
        </p>

        <p>
            <label>Nome de Usuário (Login) *</label><br>
            <input type="text" name="login" required>
        </p>

        <p>
            <label>Senha *</label><br>
            <input type="password" name="senha" required>
        </p>

        <p>
            <button type="submit">Cadastrar e Voltar</button>
        </p>
    </form>

    <p>Já tem uma conta? <a href="login.php">Faça o Login aqui</a></p>

</body>
</html>