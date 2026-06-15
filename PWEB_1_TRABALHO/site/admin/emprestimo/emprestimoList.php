<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db = new db('emprestimo');
$db_usuario = new db('usuario');
$db_livros = new db('livros');
$dados = [];

// DELETAR REGISTRO
if (!empty($_GET['id']) && isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    $db->destroy($_GET['id']);
    echo "<script>window.location.href='emprestimoList.php';</script>";
    exit;
}

$dados = $db->all();
?>
<div class="row">
  <h3>Gerenciamento de Empréstimos</h3>
  <div class="mt-2">
      <a href="./emprestimoForm.php" class="btn btn-success">Novo Empréstimo</a>
      <a href="../index.php" class="btn btn-secondary">Voltar ao Painel</a>
  </div>
</div>

<div class="row mt-4">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Usuário / Aluno</th>
        <th scope="col">Livro</th>
        <th scope="col">Data Empréstimo</th>
        <th scope="col">Data Devolução</th>
        <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (empty($dados)) {
          echo "<tr><td colspan='6' align='center'>Nenhum empréstimo registrado.</td></tr>";
      } else {
          foreach ($dados as $item) {
              $id              = isset($item->id) ? $item->id : $item['id'];
              $usuario_id      = isset($item->usuario_id) ? $item->usuario_id : $item['usuario_id'];
              $livro_id        = isset($item->livro_id) ? $item->livro_id : $item['livro_id'];
              $data_emprestimo = isset($item->data_emprestimo) ? $item->data_emprestimo : $item['data_emprestimo'];
              $data_devolucao  = isset($item->data_devolucao) ? $item->data_devolucao : $item['data_devolucao'];

              // Busca os nomes correspondentes nas outras tabelas
              $u = $db_usuario->find($usuario_id);
              $l = $db_livros->find($livro_id);
              
              $nome_usuario = $u ? ((isset($u->nome) ? $u->nome : $u['nome']) . " " . (isset($u->sobrenome) ? $u->sobrenome : $u['sobrenome'])) : "Não encontrado";
              $nome_livro   = $l ? (isset($l->titulo) ? $l->titulo : $l['titulo']) : "Não encontrado";
              
              $dt_emp = date('d/m/Y', strtotime($data_emprestimo));
              $dt_dev = !empty($data_devolucao) ? date('d/m/Y', strtotime($data_devolucao)) : "Pendente";

              echo "<tr>
                    <th scope='row'>{$id}</th>
                    <td>{$nome_usuario}</td>
                    <td>{$nome_livro}</td>
                    <td>{$dt_emp}</td>
                    <td>{$dt_dev}</td>
                    <td>
                      <a class='btn btn-success btn-sm' onclick='return confirm('Confirmar devolução e gerar registro?')' href='../devolucoes/devolucaoList.php?id={$id}&acao=dar_baixa'>Devolver</a>                      
                      <a class='btn btn-warning btn-sm' href='./emprestimoForm.php?id={$id}'>Editar</a>
                      <a class='btn btn-danger btn-sm' onclick='return confirm(\"Deseja Excluir?\")' href='./emprestimoList.php?id={$id}&acao=excluir'>Excluir</a>
                    </td>
                 </tr>";
          }
      }
      ?>
    </tbody>
  </table>
</div>
<?php include '../footer.php'; ?>