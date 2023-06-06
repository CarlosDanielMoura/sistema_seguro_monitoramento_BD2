<?php

require_once '../conexao.php';


session_start();

if (!empty($_POST)) {

  try {
    //code...

    $sql = "SELECT nome, email, tipo FROM usuarios  WHERE email = :email AND senha = :senha";
    $stmt = $pdo->prepare($sql);

    $dados = array(
      'email' => $_POST['user_email'],
      'senha' => md5($_POST['password'])
    );
    $stmt->execute($dados);
    $result = $stmt->fetchAll();

    if ($stmt->rowCount() == 1) {
      $result = $result[0];
      $_SESSION['nome'] = $result['nome'];
      $_SESSION['email'] = $result['email'];
      $_SESSION['tipo'] = $result['tipo'];
      header("location: ../painel.php");
    } else {
      session_destroy();
      header("location: ../../index.php?msgErro=Não foi possível realizar login, Email e/ou Senha incorreta.");
    }
  } catch (PDOException $e) {

    die($e->getMessage());
  }
} else {
  header("location: ../../index.php?msgErro=Erro de acesso.");
}
die();
