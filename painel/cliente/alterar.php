<?php
require_once('../conexao.php');

if (!empty($_POST)) {
  try {
    // Code...
    $id = $_POST['id'];

    $sql = "UPDATE Cliente SET nome = :nome, telefone = :telefone, data_nascimento = :data_nascimento, cpf = :cpf, tipo_pessoa = :tipo_pessoa, observacao = :observacao, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $dados = array(
      ':id' => $id,
      ':nome' => $_POST['nome'],
      ':telefone' => $_POST['telefone'],
      ':data_nascimento' => $_POST['data_nascimento'],
      ':cpf' => $_POST['cpf'],
      ':tipo_pessoa' => $_POST['tipo_pessoa'],
      ':observacao' => $_POST['observacao'],
      ':email' => $_POST['email']
    );

    $stmt->execute($dados);
    $rowsUpdated = $stmt->rowCount();
    if ($rowsUpdated > 0) {
      $response = array(
        'success' => true,
        'message' => 'Cliente alterado com sucesso'
      );
    } else {
      $response = array(
        'success' => false,
        'message' => 'Falha em alterar o Cliente'
      );
    }
  } catch (PDOException $e) {
    $response = array(
      'success' => false,
      'message' => 'Erro ao executar a consulta: ' . $e->getMessage()
    );
  }
} else {
  $response = array(
    'success' => false,
    'message' => 'Falha em alterar o Cliente'
  );
}

// Retorna a resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
