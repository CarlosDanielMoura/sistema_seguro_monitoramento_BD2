<?php
require_once '../conexao.php';

$user = array();
$sql = "SELECT * FROM usuarios";

try {
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute()) {
    $user = $stmt->fetchAll();
    echo json_encode($user); // Converte o array para formato JSON
  } else {
    die("Erro ao conectar no banco.");
  }
} catch (Exception $e) {
}
