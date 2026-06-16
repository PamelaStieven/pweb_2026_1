
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];

if (!empty($_GET['id'])) {
    $usuario = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    
    $data_obj = (object) $_POST;
    
    try {
        // Validações obrigatórias estruturadas
        if (empty($_POST['nome'])) {
            $errors[] = "<li>O nome é obrigatório</li>";
        }
        if (empty($_POST['email'])) {
            $errors[] = "<li>O email é obrigatório</li>";
        }
        if (empty($_POST['sobrenome'])) {
            $errors[] = "<li>O sobrenome é obrigatório</li>";
        }
        if (empty($_POST['login'])) {
            $errors[] = "<li>O login é obrigatório</li>";
        }
        if (empty($_POST['senha'])) {
            $errors[] = "<li>A senha é obrigatória</li>";
        }

        if (empty($errors)) {
            $dados = [
                'nome'      => $_POST['nome'],
                'sobrenome' => $_POST['sobrenome'],
                'telefone'  => $_POST['telefone'],
                'email'     => $_POST['email'],
                'login'     => $_POST['login'],
                'senha'     => $_POST['senha']
            ];

            if (!empty($_POST['id'])) {
                $dados['id'] = $_POST['id'];
                $db->update($dados);
                $success = "Registro Atualizado com sucesso!";
            } else {
                $db->store($dados);
                $success = "Registro Salvo com sucesso!";
            }
            
            echo "<script>window.location.href='UsuarioList.php';</script>";
            exit();
        }
    } catch (PDOException $e) {
        $actionError = $e->getMessage();
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}
?>

<style>
  .custom-card h3, 
  .custom-card h3 i, 
  h3.text-dark {
    color: #ffc107 !important;
  }
</style>

<div class="container py-4">

  <div class="p-4 mb-4 bg-white border rounded shadow-sm custom-card">
    
    <?php actionMessage($success, $actionError) ?>
    <?php showValidationError($errors) ?>

    <form action="UsuarioForm.php" method="post">
      <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
        <h3 class="fw-bold text-dark m-0">
          <i class="fa-solid fa-user-gear me-2"></i><?php echo !empty($_GET['id']) ? 'Editar Usuário' : 'Cadastrar Usuário'; ?>
        </h3>
      </div>

      <input type="hidden" name="id" value="<?php echo isset($usuario->id) ? $usuario->id : ($usuario['id'] ?? ''); ?>">

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold text-secondary small">Nome</label>
          <input type="text" name="nome" class="form-control" value="<?php echo isset($usuario->nome) ? $usuario->nome : ($usuario['nome'] ?? ''); ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold text-secondary small">Sobrenome</label>
          <input type="text" name="sobrenome" class="form-control" value="<?php echo isset($usuario->sobrenome) ? $usuario->sobrenome : ($usuario['sobrenome'] ?? ''); ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold text-secondary small">Telefone</label>
          <input type="text" name="telefone" class="form-control" value="<?php echo isset($usuario->telefone) ? $usuario->telefone : ($usuario['telefone'] ?? ''); ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold text-secondary small">Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo isset($usuario->email) ? $usuario->email : ($usuario['email'] ?? ''); ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold text-secondary small">Usuário (Login)</label>
          <input type="text" name="login" class="form-control" value="<?php echo isset($usuario->login) ? $usuario->login : ($usuario['login'] ?? ''); ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold text-secondary small">Senha</label>
          <input type="text" name="senha" class="form-control" value="<?php echo isset($usuario->senha) ? $usuario->senha : ($usuario['senha'] ?? ''); ?>">
        </div>
      </div>

      <div class="mt-4 pt-2 border-top d-flex gap-2">
        <button type="submit" class="btn btn-success px-4">
          <i class="fa-solid fa-floppy-disk me-2"></i>Salvar Dados
        </button>
        <a href="UsuarioList.php" class="btn btn-outline-secondary px-4">
          Cancelar
        </a>
      </div>
    </form>

  </div>

  <div class="mb-4">
    <a href="../index.php" class="btn btn-outline-dark bg-white">
      <i class="fa-solid fa-house me-2"></i>Voltar ao Painel Principal
    </a>
  </div>

</div>

<?php
include '../footer.php';
?>