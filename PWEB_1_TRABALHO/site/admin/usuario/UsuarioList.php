<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: ../login.php");
    exit();
}

include '../header.php';
require_once "../db.class.php";
$db = new db('usuario');

if (!empty($_GET['excluir_id'])) {
    $db->destroy($_GET['excluir_id']);
    header("Location: UsuarioList.php");
    exit();
}

if (!empty($_POST['valor'])) {
    $dados_busca = [
        'tipo' => 'nome',
        'valor' => $_POST['valor']
    ];
    $lista = $db->search($dados_busca);
} else {
    $lista = $db->all();
}
?>

<main class="container-fluid p-0 bg-light" style="min-height: 100vh;">
  <div class="row g-0">
    
    <aside class="col-md-3 col-lg-2 p-3 bg-white border-end">
      <div class="d-flex flex-column h-100">
        <a href="../index.php" class="d-flex align-items-center mb-4 me-md-auto text-decoration-none">
          <i class="fa-solid fa-book-bookmark me-2" style="color: #ffc107;"></i>
          <span class="fs-5 fw-bold text-dark" style="letter-spacing: 1px;">ACCIO LIBRARY</span>
        </a>
        <hr class="text-secondary">
        
        <ul class="nav nav-pills flex-column mb-auto gap-2">
          <li><a href="../index.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-chart-pie me-2" style="color: #ffc107;"></i> Pagina Inicial</a></li>
          <li><a href="UsuarioList.php" class="nav-link active py-2.5 px-3 rounded text-dark fw-bold" style="background-color: #ffc107;"><i class="fa-solid fa-users me-2"></i> Leitores</a></li>
          <li><a href="../livros/livroList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-book-open me-2" style="color: #ffc107;"></i> Acervo</a></li>
          <li><a href="../emprestimo/emprestimoList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-business-time me-2" style="color: #ffc107;"></i> Empréstimos</a></li>
          <li><a href="../devolucoes/devolucaoList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-clipboard-check me-2" style="color: #ffc107;"></i> Devoluções</a></li>
          <li><a href="../multas/multasList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-receipt me-2" style="color: #ffc107;"></i> Multas</a></li>
          <li><a href="../reservas/reservasList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-calendar-days me-2" style="color: #ffc107;"></i> Reservas</a></li>
        </ul>
        
        <hr class="text-secondary">
        <div class="d-flex flex-column gap-2">
          <a href="../../../index.php" class="btn btn-sm btn-outline-dark w-100"><i class="fa-solid fa-globe me-2"></i>Ver Site</a>
          <a href="../login.php" class="btn btn-sm btn-outline-danger w-100"><i class="fa-solid fa-right-from-bracket me-2"></i>Sair do Painel</a>
        </div>
      </div>
    </aside>

    <article class="col-md-9 col-lg-10 p-4 p-md-5 bg-white">
      <div class="mb-5 border-bottom pb-3 d-flex justify-content-between align-items-end flex-wrap gap-3">
        <div>
          <h1 class="fw-bold text-dark m-0 h2">Filiados & Leitores</h1>
          <span class="text-muted small">Listagem geral de usuários ativos cadastrados no sistema</span>
        </div>
        <div>
          <a href="UsuarioForm.php" class="btn px-4 text-dark fw-bold" style="background-color: #ffc107;">
            <i class="fa-solid fa-user-plus me-2"></i>Cadastrar Novo
          </a>
        </div>
      </div>

      <div class="card p-4 border bg-white shadow-sm mb-4">
        <form action="UsuarioList.php" method="post" class="row g-2">
          <div class="col-md-8 col-lg-6">
            <input type="text" name="valor" class="form-control" placeholder="Buscar leitor por nome...">
          </div>
          <div class="col-md-4 col-lg-2">
            <button type="submit" class="btn btn-dark w-100">Filtrar</button>
          </div>
        </form>
      </div>

      <div class="card border bg-white shadow-sm overflow-hidden">
        <div class="table-responsive">
          <table class="table table-hover align-middle m-0">
            <thead class="table-light text-secondary small text-uppercase">
              <tr>
                <th class="ps-4">ID</th>
                <th>Nome Completo</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Login</th>
                <th class="text-center pe-4">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($lista)): ?>
                <?php foreach ($lista as $item): ?>
                  <tr>
                    <td class="ps-4 fw-bold text-secondary">#<?php echo $item->id; ?></td>
                    <td class="fw-bold text-dark"><?php echo $item->nome . " " . $item->sobrenome; ?></td>
                    <td><?php echo $item->telefone; ?></td>
                    <td><?php echo $item->email; ?></td>
                    <td><span class="badge bg-light text-dark border"><?php echo $item->login; ?></span></td>
                    <td class="text-center pe-4">
                      <div class="d-inline-flex gap-2">
                        <a href="UsuarioForm.php?id=<?php echo $item->id; ?>" class="btn btn-sm btn-warning shadow-sm text-dark fw-bold">
                          <i class="fa-solid fa-pen-to-square me-1"></i> Editar
                        </a>
                        <a href="UsuarioList.php?excluir_id=<?php echo $item->id; ?>" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Tem certeza que deseja remover este usuário?')">
                          <i class="fa-solid fa-trash me-1"></i> Excluir
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Nenhum leitor encontrado.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </article>
  </div>
</main>

<?php
include '../footer.php';
?>