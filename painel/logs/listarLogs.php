<?php

require_once('../conexao.php');

try {
  // Consulta SQL para recuperar os dados da tabela clienteLog
  $sql = 'SELECT * FROM clienteLog';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Array para armazenar os dados dos clientes
  $clientes = array();

  foreach ($results as $result) {
    $id = $result['cliente_id'];

    // Consulta SQL para recuperar os dados do cliente usando o ID
    $sql2 = "SELECT * FROM Cliente WHERE id = :id";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt2->execute();
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

    // Verifica se a consulta retornou resultados
    if ($row) {
      $nome_cliente = $row['nome'];
      $nova_observacao = $result['nova_observacao'];
      $horario_formatado = date('Y-m-d H:i:s', strtotime($result['horario']));

      // Cria um array com os dados do cliente
      $cliente = array(
        'id' => $id,
        'nome' => $nome_cliente,
        'nova_observacao' => $nova_observacao,
        'horario_formatado' => $horario_formatado
      );

      $clientes[] = $cliente;
    }
  }

  // Define o cabeçalho como JSON e imprime os dados dos clientes como resposta
  header('Content-Type: application/json');
  echo json_encode($clientes);
} catch (Exception $e) {
  echo $e->getMessage();
}
