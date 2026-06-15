<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db_emprestimo = new db('emprestimo'); 
$db_usuario = new db('usuario');
$db_livros = new db('livros');

if (!empty($_GET['id']) && isset($_GET['acao']) && $_GET['acao'] == 'dar_baixa') {
    $emp = $db_emprestimo->find($_GET['id']);
    
    if ($emp) {
        $id              = isset($emp->id) ? $emp->id : $emp['id'];
        $usuario_id      = isset($emp->usuario_id) ? $emp->usuario_id : $emp['usuario_id'];
        $livro_id        = isset($emp->livro_id) ? $emp->livro_id : $emp['livro_id'];
        $data_emprestimo = isset($emp->data_emprestimo) ? $emp->data_emprestimo : $emp['data_emprestimo'];

        $hoje = date('Y-m-d');
        
        $data_limite = date('Y-m-d', strtotime($data_emprestimo . " + 15 days"));
        
        $valor_multa = 0;
        if ($hoje > $data_limite) {
            $dias_atraso = round((strtotime($hoje) - strtotime($data_limite)) / (60 * 60 * 24));
            $valor_multa = $dias_atraso * 5.00; 
        }

        $dados_atualizacao = [
            'id'              => $id,
            'usuario_id'      => $usuario_id,
            'livro_id'        => $livro_id,
            'data_emprestimo' => $data_emprestimo,
            'data_devolucao'  => $hoje, 
            'multa'           => $valor_multa 
        ];
        
        $db_emprestimo->update($dados_atualizacao);
    }
    echo "<script>window.location.href='devolucaoList.php';</script>";
    exit;
}

$dados = $db_emprestimo->all();
?>

<style>
  .custom-card h3, 
  .custom-card h3 i, 
  h3.text-dark {
    color: #ffc107 !important;
  }

  .table-responsive .table thead.table-dark,
  .table-responsive .table thead.table-dark th {
    background-color: #ffc107 !important;
    background: #ffc107 !important;
    color: #000000 !important;
    font-weight: bold !important;
    border-bottom: 2px solid #e0a800 !important;
  }
</style>

<div class="container py-4">

  <div class="p-4 mb-4 bg-white border rounded shadow-sm custom-card">
    
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
      <h3 class="fw-bold text-dark m-0">
        <i class="fa-solid fa-clipboard-check me-2"></i>Histórico de Devoluções
      </h3>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle border mb-0">
        <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 8%;"># ID</th>
            <th scope="col">Usuário / Aluno</th>
            <th scope="col">Livro</th>
            <th scope="col">Retirada</th>
            <th scope="col">Prazo Máximo</th>
            <th scope="col">Entrega Real</th>
            <th scope="col" class="text-center" style="width: 18%;">Multa Aplicada</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $tem_devolvido = false;
          if (!empty($dados)) {
              foreach ($dados as $item) {
                  $data_devolucao = isset($item->data_devolucao) ? $item->data_devolucao : ($item['data_devolucao'] ?? '');
                  
                  if (empty($data_devolucao) || $data_devolucao == '0000-00-00') {
                      continue;
                  }

                  $tem_devolvido = true;
                  $id              = isset($item->id) ? $item->id : $item['id'];
                  $usuario_id      = isset($item->usuario_id) ? $item->usuario_id : $item['usuario_id'];
                  $livro_id        = isset($item->livro_id) ? $item->livro_id : $item['livro_id'];
                  $data_emprestimo = isset($item->data_emprestimo) ? $item->data_emprestimo : $item['data_emprestimo'];

                  $data_limite = date('Y-m-d', strtotime($data_emprestimo . " + 15 days"));
                  
                  $valor_multa = 0;
                  if ($data_devolucao > $data_limite) {
                      $dias_atraso = round((strtotime($data_devolucao) - strtotime($data_limite)) / (60 * 60 * 24));
                      $valor_multa = $dias_atraso * 5.00;
                  }

                  $u = $db_usuario->find($usuario_id);
                  $l = $db_livros->find($livro_id);
                  
                  $nome_usuario = $u ? ((isset($u->nome) ? $u->nome : $u['nome']) . " " . (isset($u->sobrenome) ? $u->sobrenome : $u['sobrenome'])) : "Não encontrado";
                  $nome_livro   = $l ? (isset($l->titulo) ? $l->titulo : $l['titulo']) : "Não encontrado";

                  echo "<tr>
                        <th scope='row' class='text-secondary'>{$id}</th>
                        <td class='fw-bold text-dark'>{$nome_usuario}</td>
                        <td>{$nome_livro}</td>
                        <td>" . date('d/m/Y', strtotime($data_emprestimo)) . "</td>
                        <td>" . date('d/m/Y', strtotime($data_limite)) . "</td>
                        <td>" . date('d/m/Y', strtotime($data_devolucao)) . "</td>
                        <td class='text-center'>";
                        if ($valor_multa > 0) {
                            echo "<span class='badge bg-danger px-2 py-1'>R$ " . number_format($valor_multa, 2, ',', '.') . "</span>";
                        } else {
                            echo "<span class='badge bg-success px-2 py-1'>No Prazo</span>";
                        }
                  echo "</td>
                     </tr>";
              }
          }

          if (!$tem_devolvido) {
              echo "<tr><td colspan='7' align='center' class='text-muted py-4'>📋 Nenhum histórico de devolução registrado ainda.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
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