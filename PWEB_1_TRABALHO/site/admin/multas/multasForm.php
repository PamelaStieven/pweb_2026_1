<?php
include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";?>

<div class="row">
  <h3>Configuração do Sistema de Multas</h3>
  <div class="alert alert-info col-6 mt-3">
    <h5>Regra de Negócio Automatizada</h5>
    <p>As multas são calculadas automaticamente com base no histórico de empréstimos:</p>
    <ul>
      <li><strong>Prazo regulamentar:</strong> 7 dias corridos.</li>
      <li><strong>Taxa de atraso:</strong> R$ 2,00 por dia vencido.</li>
    </ul>
  </div>
  <div class="col-12 mt-2">
    <a href="multas.php" class="btn btn-secondary">Voltar para Lista</a>
  </div>
</div>
<?php include '../footer.php'; ?>