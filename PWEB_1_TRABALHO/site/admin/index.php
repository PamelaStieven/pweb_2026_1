<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>O que deseja ler hoje?</title>
</head>
<body>

    <h1>Painel de Controle da Biblioteca</h1>
    
    <hr>
    
    <h3>Menu de Gerenciamento do Sistema:</h3>
    
    <!-- Links diretos para as pastas internas, sem firulas -->
    <ul>
        <li><a href="usuario/usuarioList.php">Usuários</a></li>
        <br>
        <li><a href="livros/livroList.php">Catálogo de Livros</a></li>
        <br>
        <li><a href="emprestimo/emprestimoList.php">Empréstimos Ativos</a></li>
        <br>
        <li><a href="devolucoes/devolucaoList.php">Registro de Devoluções</a></li>
        <br>
        <li><a href="multas/multasList.php"> Ver Multas Aplicadas</a></li>
        <br>
        <li><a href="reservas/reservasList.php">Ver Reservas</a></li>
       
    </ul>

    <hr>

    <p>
        <!-- Link para voltar para a página inicial do site -->
        <a href="../../index.php"><button>Ver Página Inicial (Site)</button></a>
        
        <!-- Botão de deslogar definitivo -->
        <a href="./login.php"><button style="color: red;">Sair do Sistema</button></a>
    </p>

</body>
</html>