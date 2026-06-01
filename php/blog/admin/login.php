<?php
include './header.php';
include_once "./database/db.class.php";

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = "";

if(!empty($_GET['id'])){
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    $data = (object) $_POST;
    // var_dump($_POST);
    //exit;
    try {

        if (empty($_POST['email'])) {
            $errors[] = "<li>O email é obrigatório</li>";
        }

        if (empty($_POST['senha'])) {
            $errors[] = "<li>A senha é obrigatório</li>";

            if(strlen($_POST['senha'] < 3)){
                $errors[] = '<li>A senha deve ter no mínimo 3 caracteres</li>';
            }
        }

        if (empty($errors)) {

            $usuario = $db->findBy('email',$_POST['email']);

            if($usuario && password_verify($_POST['senha'], $usuario->senha)){
                $_SESSION['usuario_id'] = $usuario->id;
                $_SESSION['usuario_nome'] = $usuario->nome;
                $_SESSION['usuario_email'] = $usuario->email;

                $success = "Registro Salvo com sucesso!";
                redirect('./index.php');
        }else{
            $actionError = "Email ou senha inválido, por favor tente novamente";
        }  
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }



    $data = [
        'id' => '',
        'nome' => '',
        'email' => '',
        'telefone' => ''
    ];
}
?>

<div class="row">
    <?php actionMessage($success, $actionError) ?>
    <?php showValidationError($errors) ?>

    <form action="login.php" method="post">
        <h3>Login Usuário</h3> 
        <div class="col-6">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo getFormValue($data, 'email'); ?>">
        </div>
         <div class="col-6">
            <label for="telefone">Senha</label>
            <input type="text" name="senha" class="form-control" value="<?php echo getFormValue($data, 'senha'); ?>">
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Logar</button>Não tem conta?
            <a href="./registrar.php" class="btn btn-primary"> Crie aqui!</a>
        </div>


    </form>

</div>

<?php
include './footer.php';
?>