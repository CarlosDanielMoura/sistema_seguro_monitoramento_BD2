<?php

require_once '../conexao.php';

if (!empty($_POST)) {
  try {
    //code...
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)";
    $stmt = $pdo->prepare($sql);

    // $username = $_POST['cad_email'];
    // $role = 'funcionario';

    // $newUsername = str_replace(['@', '.'], ['_', '_'], $username);

    // // Criação do novo usuário
    // $queryCreateUser = "CREATE USER $newUsername WITH PASSWORD 'root'";
    // $pdo->exec($queryCreateUser);

    // // Atribuição da role ao novo usuário
    // $queryGrantRole = "GRANT $role TO $newUsername";
    // $pdo->exec($queryGrantRole);

    $dados = array(
      ':nome' => $_POST['cad_nome'],
      ':email' => $_POST['cad_email'],
      ':senha' => md5($_POST['cad_pass']),
      ':tipo' => 'gerente'
    );

    if ($stmt->execute($dados)) {
      header("location: ../../index.php?msgSucesso=Cadastro realizado com sucesso.");
    }
  } catch (PDOException $e) {
    die($e->getMessage());
    header("location: ../../index.php?msgErro=Não foi possível realizar cadastro, tente novamente.");
  }
} else {
  header("location: ../../index.php?msgErro=Erro de acesso.");
}

die();
