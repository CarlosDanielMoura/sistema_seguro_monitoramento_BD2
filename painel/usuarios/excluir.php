<?php

require_once '../conexao.php';

if (!empty($_POST)) {
  $id = $_POST['id'];
  try {
    // Chama a stored procedure para excluir o cliente
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_user = '$id'");

    $response = array();

    if ($stmt->execute()) {
      $response = array(
        'success' => true,
        'message' => 'User excluído com sucesso'
      );
    } else {
      $response = array(
        'success' => false,
        'message' => 'Falha ao excluir User'
      );
    }

    // Retorna a resposta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
  } catch (PDOException $e) {
    $response = array(
      'success' => false,
      'message' => 'Falha no Servidor'
    );

    // Retorna a resposta de erro como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
  }
}
