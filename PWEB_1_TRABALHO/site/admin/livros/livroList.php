<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db = new db('livros');
$dados = [];

// DELETAR (Se vier ID pela URL)
if (!empty($_GET['id'])) {
    try {
        $db->destroy($_GET['id']);
        echo "<script>window.location.href='livroList.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erro ao deletar: " . $e->getMessage() . "</div>";
    }
}

// SE CLICOU EM BUSCAR
if (!empty($_POST) && !empty($_POST['valor'])) {
    $dados = $db->all();
    $valor_busca = strtolower($_POST['valor']);
    $tipo_busca = $_POST['tipo'];
    
    $dados = array_filter($dados, function($item) use ($valor_busca, $tipo_busca) {
        $campo_valor = isset($item->$tipo_busca) ? $item->$tipo_busca : ($item[$tipo_busca] ?? '');
        return strpos(strtolower($campo_valor), $valor_busca) !== false;
    });
} else {
    // SE NÃO BUSCOU, TRAZ TODOS
    $dados = $db->all();
}
?>
<div class="row">
  <h3>Listagem de Livros</h3>
  <form action="livroList.php" method="post">
    <div class="row">
      <div class="col-2">
        <label for="tipo">Tipo</label>
        <select name="tipo" class="form-select">
          <option value="titulo">Título</option>
          <option value="autor">Autor</option>
          <option value="genero">Gênero</option>
        </select>
      </div>
      <div class="col-5">
        <label for="valor">Valor</label>
        <input type="text" name="valor" placeholder="Pesquisar..." class="form-control">
      </div>
      <div class="col-5 align-self-end">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="./livroForm.php" class="btn btn-success">Novo Livro</a>
      </div>
    </div>
  </form>
</div>

<div class="row mt-4">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Título</th>
        <th scope="col">Autor</th>
        <th scope="col">Gênero</th>
        <th scope="col">Editar</th>
        <th scope="col">Excluir</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (empty($dados)) {
          echo "<tr><td colspan='6' align='center'>Nenhum livro encontrado ou cadastrado.</td></tr>";
      } else {
          foreach ($dados as $item) {
              $id     = isset($item->id) ? $item->id : $item['id'];
              $titulo = isset($item->titulo) ? $item->titulo : $item['titulo'];
              $autor  = isset($item->autor) ? $item->autor : $item['autor'];
              $genero = isset($item->genero) ? $item->genero : $item['genero'];

              echo "<tr>
                    <th scope='row'>{$id}</th>
                    <td>{$titulo}</td>
                    <td>{$autor}</td>
                    <td>{$genero}</td>
                    <td>
                      <a class='btn btn-warning btn-sm' href='./livroForm.php?id={$id}'>Editar</a>
                    </td>
                    <td>
                      <a class='btn btn-danger btn-sm' onclick='return confirm(\"Deseja Excluir?\")' href='./livroList.php?id={$id}'>Deletar</a>
                    </td>
                 </tr>";
          }
      }
      ?>
    </tbody>
  </table>
   <div class="mt-3">
                <a href="../index.php" class="btn btn-outline-dark">Voltar ao Painel</a>
            </div>
</div>

<?php
include '../footer.php';
?>