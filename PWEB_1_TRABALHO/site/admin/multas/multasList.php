<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db_emprestimo = new db('emprestimo'); 
$db_usuario = new db('usuario');
$db_livros = new db('livros');

$dados = $db_emprestimo->all();

$dias_permitidos = 15; 
$valor_por_dia_atraso = 5.00; 
?>

<div class="row">
  <h3>Controle de Multas por Atraso</h3>
  <p class="text-muted">Listagem de alunos com devoluções atrasadas ou empréstimos vencidos.</p>
  <div class="mt-2">
      <a href="../index.php" class="btn btn-secondary">Voltar ao Painel</a>
  </div>
</div>

<div class="row mt-4">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col"># Empréstimo</th>
        <th scope="col">Usuário / Aluno</th>
        <th scope="col">Livro</th>
        <th scope="col">Situação</th>
        <th scope="col">Dias de Atraso</th>
        <th scope="col">Valor da Multa</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $tem_multa = false;
      if (!empty($dados)) {
          foreach ($dados as $item) {
              $id              = isset($item->id) ? $item->id : $item['id'];
              $usuario_id      = isset($item->usuario_id) ? $item->usuario_id : $item['usuario_id'];
              $livro_id        = isset($item->livro_id) ? $item->livro_id : $item['livro_id'];
              $data_emprestimo = isset($item->data_emprestimo) ? $item->data_emprestimo : $item['data_emprestimo'];
              $data_devolucao  = isset($item->data_devolucao) ? $item->data_devolucao : ($item['data_devolucao'] ?? '');

              // data para devolver
              $data_limite = date('Y-m-d', strtotime($data_emprestimo . " + {$dias_permitidos} days"));
              
              $dias_atraso = 0;
              $situacao = "";

              // devolveu com atraso
              if (!empty($data_devolucao) && $data_devolucao != '0000-00-00') {
                  if ($data_devolucao > $data_limite) {
                      $time_limite = strtotime($data_limite);
                      $time_devolucao = strtotime($data_devolucao);
                      $dias_atraso = round(($time_devolucao - $time_limite) / (60 * 60 * 24));
                      $situacao = "<span class='badge bg-secondary'>Devolvido com Atraso</span>";
                  }
              } 
              // não devolveu e ja esta atrasado
              else {
                  $hoje = date('Y-m-d');
                  if ($hoje > $data_limite) {
                      $time_limite = strtotime($data_limite);
                      $time_hoje = strtotime($hoje);
                      $dias_atraso = round(($time_hoje - $time_limite) / (60 * 60 * 24));
                      $situacao = "<span class='badge bg-danger'>Pendente (Vencido)</span>";
                  }
              }

              if ($dias_atraso <= 0) {
                  continue;
              }

              $tem_multa = true;
              $valor_multa = $dias_atraso * $valor_por_dia_atraso;

              $u = $db_usuario->find($usuario_id);
              $l = $db_livros->find($livro_id);
              
              $nome_usuario = $u ? ((isset($u->nome) ? $u->nome : $u['nome']) . " " . (isset($u->sobrenome) ? $u->sobrenome : $u['sobrenome'])) : "Não encontrado";
              $nome_livro   = $l ? (isset($l->titulo) ? $l->titulo : $l['titulo']) : "Não encontrado";

              echo "<tr>
                    <th scope='row'>{$id}</th>
                    <td>{$nome_usuario}</td>
                    <td>{$nome_livro}</td>
                    <td>{$situacao}</td>
                    <td><strong class='text-danger'>{$dias_atraso} dias</strong></td>
                    <td><span class='badge bg-warning text-dark'>R$ " . number_format($valor_multa, 2, ',', '.') . "</span></td>
                 </tr>";
          }
      }

      if (!$tem_multa) {
          echo "<tr><td colspan='6' align='center' class='text-success'>🎉 Nenhuma multa ou atraso registrado no sistema.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<?php include '../footer.php'; ?>