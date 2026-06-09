<?php

include __DIR__ . '/admin/auth/auth.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Biblioteca</title>
</head>
<body>

<h1>Sistema Biblioteca</h1>

<p>
Bem-vindo,
<?= $_SESSION['usuario']->nome ?>
</p>

<hr>

<a href="usuario/index.php">
Usuários
</a>

<br><br>

<a href="livros/index.php">
Livros
</a>

<br><br>

<a href="emprestimo/index.php">
Empréstimos
</a>

<br><br>

<a href="devolucao/index.php">
Devoluções
</a>

<br><br>

<a href="auth/logout.php">
Sair
</a>

</body>
</html>