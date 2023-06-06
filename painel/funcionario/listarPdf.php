<?php
header('Content-Type: text/html; charset=utf-8');

require_once '../conexao.php';

if (!empty($_POST)) {
  try {
    $id = $_POST['id'];
    $sql = "SELECT * FROM funcionario WHERE id_func = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      $func = $stmt->fetch();  // Usar fetch() em vez de fetchAll() para retornar apenas um registro
      $caminho =  $func['dir_imagem'];
      header('Content-Type: application/json');
      echo json_encode($caminho, JSON_UNESCAPED_UNICODE);
    } else {
      throw new Exception("Erro ao executar a consulta no banco.");
    }
  } catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
  }
} else {
  echo 'Nenhum dado foi enviado.';
}
