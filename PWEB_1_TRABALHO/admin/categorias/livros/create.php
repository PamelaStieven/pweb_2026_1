<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

if($_POST){
    $db = new db("livros");

    $db->store([
        "titulo" => $_POST['titulo'],
        "genero" => $_POST['genero'],
        "ano_publicacao" => $_POST['ano_publicacao']
    ]);

    header("Location: index.php");
}
?>

<h2>Novo Livro</h2>

<form method="POST">
<input name="titulo" placeholder="Título" required>
<input name="genero" placeholder="Gênero" required>
<input name="ano_publicacao" placeholder="Ano_publicacao" required>
<button>Salvar</button>
</form>