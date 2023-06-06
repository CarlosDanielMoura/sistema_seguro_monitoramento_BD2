<?php
require_once '../conexao.php';

if (!empty($_POST)) {
  $id = $_POST['id'];



  try {
    // Chama a stored procedure para excluir o cliente
    $stmt = $pdo->prepare("CALL excluir_cliente(:cliente_id)");
    $stmt->bindParam(':cliente_id', $id);

    $response = array();

    if ($stmt->execute()) {
      $response = array(
        'success' => true,
        'message' => 'Cliente excluído com sucesso'
      );
    } else {
      $response = array(
        'success' => false,
        'message' => 'Falha ao excluir cliente'
      );
    }

    // Retorna a resposta como JSON
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
  } catch (PDOException $e) {
    $response = array(
      'success' => false,
      'message' => 'Erro ao excluir cliente, pois ele tem endereço cadastro no nome.'
    );

    // Retorna a resposta de erro como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
  }
}
