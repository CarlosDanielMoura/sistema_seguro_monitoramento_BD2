<?php

require_once '../conexao.php';


if (!empty($_POST)) {

  try {
    //code...

    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)";
    $stmt = $pdo->prepare($sql);


    $username = $_POST['email'];
    $role = $_POST['tipo'];

    $newUsername = str_replace(['@', '.'], ['_', '_'], $username);

    // Criação do novo usuário
    $queryCreateUser = "CREATE USER $newUsername WITH PASSWORD 'root'";
    $pdo->exec($queryCreateUser);

    // Atribuição da role ao novo usuário
    $queryGrantRole = "GRANT $role TO $newUsername";
    $pdo->exec($queryGrantRole);

    $dados = array(
      ':nome' => $_POST['nome'],
      ':email' => $_POST['email'],
      'senha' => md5($_POST['senha']),
      'tipo' => $_POST['tipo']
    );

    if ($stmt->execute($dados)) {
      $msg = 'Usuario cadastrado com sucesso';
      echo $msg;
    }
  } catch (PDOException $e) {

    die($e->getMessage());
    $msg = 'Usuario nao cadastrado';
    echo $msg;
  }
} else {
  header("location: ../../index.php?msgErro=Erro de acesso.");
}

die();
