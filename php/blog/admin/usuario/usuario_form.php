<?php 
include '../header.php';
include_once'../database/db.class.php';

$db = new db('usuario');

if(!empty($_POST)){
    //var_dump($_POST);
    //exit;
    $db->store($_POST);  

    echo "<script>set Timeout(()=>window.location.href = './usuarioList.php',1500);</script>";

}

?>

    <form action="usuario_form.php" method="post">
        <h3>Formulário Usuário</h3>
        <div class="col-6">
        <label for="nome">Nome</label>
        <input type="text" name="nome" class="form-control">
        </div>  

        <div class="col-6">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control">
        </div>  

        <div class="col-6">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div> 

        <div class="mt-2">
            <button type="submit" class="btn btn-seccess">Salvar</button>
            <a href="./usuarioList.php" class="btn btn-primary">Voltar</a>
        </div>
</form>
<?php 
include '../footer.php';
?>