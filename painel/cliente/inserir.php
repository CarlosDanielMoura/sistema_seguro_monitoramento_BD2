<?php

require_once '../conexao.php';



function inserirCliente($nome, $telefone, $dataNascimento, $cpf, $tipoPessoa, $dataRegistro, $observacao, $email)
{
  global $pdo;

  try {
    $nome = $pdo->quote($nome);
    $telefone = $pdo->quote($telefone);
    $dataNascimento = $pdo->quote($dataNascimento);
    $cpf = $pdo->quote($cpf);
    $tipoPessoa = $pdo->quote($tipoPessoa);
    $dataRegistro = $pdo->quote($dataRegistro);
    $observacao = $pdo->quote($observacao);
    $email = $pdo->quote($email);

    $query = "SELECT inserir_cliente($nome, $telefone, $dataNascimento, $cpf, $tipoPessoa, $dataRegistro, $observacao, $email)";
    $stmt = $pdo->query($query);

    if ($stmt) {
      return array(
        'success' => true,
        'message' => 'Cliente inserido com sucesso!'
      );
    } else {
      return array(
        'success' => false,
        'message' => 'Ocorreu um erro ao inserir o cliente.'
      );
    }
  } catch (PDOException $e) {
    return array(
      'success' => false,
      'message' => 'Idade do cliente deve ser minimo 18 anos'
    );
  }
}


if (!empty($_POST)) {
  // Exemplo de uso:
  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $dataNascimento = $_POST['dataNasc'];
  $cpf = $_POST['cpf'];
  $tipoPessoa = $_POST['tipo'];
  $dataRegistro = $_POST['dataAtual'];
  $observacao = $_POST['observacao'];
  $email = $_POST['email'];

  $response = inserirCliente($nome, $telefone, $dataNascimento, $cpf, $tipoPessoa, $dataRegistro, $observacao, $email);
  // Retorna a resposta como JSON
  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  return array(
    'success' => false,
    'message' => 'Ocorreu um erro POST vazio'
  );
}
