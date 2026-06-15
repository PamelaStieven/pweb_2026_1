<?php
// Força exibir erros caso falte algo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclui a autenticação que já está funcionando
include 'site/admin/autenticacao.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página Inicial</title>
</head>
<body>

    <h1>Sistema da Biblioteca</h1>
    
    <p>Bem-vindo ao sistema da biblioteca!</p>
    
    <hr>
    
    <h3>Sobre a nossa biblioteca:</h3>
    <p>Este sistema serve para organizar os livros da nossa escola. Aqui o aluno consegue ver os livros que estão guardados e também pode controlar os dias que pegou emprestado para não esquecer de devolver na data certa.</p>
    
    <h3>Nossos Gêneros Disponíveis:</h3>
    <p>Temos um acervo muito rico para ajudar nos seus estudos e também para os momentos de lazer. Você vai encontrar livros de romance, ficção científica, terror, suspense, poesia, biografias, além de uma seção cheia de livros didáticos, gibis e mangás.</p>
    
    <h3>Como funciona para pegar e devolver livros:</h3>
    <p>Para ler um livro, o aluno deve fazer a reserva ou o empréstimo direto na nossa bancada. Você pode ficar com o livro por até 7 dias seguidos. Quando esse prazo acabar, é obrigatório trazer o livro de volta para fazer a devolução ou pedir uma renovação se ninguém estiver esperando por ele.</p>
    
    <h3>Avisos Importantes sobre Multas:</h3>
    <p>Fique muito atento ao prazo de entrega! Caso você esqueça de devolver o livro na data certa, o sistema vai gerar uma multa automática no valor de R$ 1,00 por cada dia de atraso. O aluno que tiver com alguma multa pendente ou atrasada no sistema não vai conseguir pegar novos livros até ir à secretaria regularizar a situação e pagar o valor.</p>
    
    <hr>

    <p>
        <a href="site/admin/login.php"><button>Ir para o Login</button></a>
    </p>
    
    <p>
        <a href="site/admin/registrar.php"><button>Criar Nova Conta</button></a>
    </p>
    
    <p>
        <a href="site/admin/login.php"><button style="color: red;">Sair</button></a>
    </p>

</body>
</html>