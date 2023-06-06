<?php
require_once('../conexao.php');

if (!empty($_POST)) {


  try {
    //code...

    $id = $_POST['id'];
    $msg = '';

    $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha , tipo = :tipo WHERE id_user =$id";
    $stmt = $pdo->prepare($sql);

    $dados = array(
      ':nome' => $_POST['nome'],
      ':email' => $_POST['email'],
      'senha' => md5($_POST['senha']),
      'tipo' => $_POST['tipo']
    );

    if ($stmt->execute($dados)) {
      $msg = 'Usuario alterado com sucesso';
      echo $msg;
    }
  } catch (PDOException $e) {

    die($e->getMessage());
  }
} else {
  $msg = 'Erro ao alterar';
  echo $msg;
}
