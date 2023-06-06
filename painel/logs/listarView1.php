< <?php

  require_once('../conexao.php');

  try {
    // Consulta SQL para recuperar os dados da tabela clienteLog
    $sql = 'SELECT * FROM clientes_com_seguro';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Array para armazenar os dados dos clientes
    $clientes = array();

    foreach ($results as $result) {
      $id = $result['cpf'];

      // Consulta SQL para recuperar os dados do cliente usando o ID
      $sql2 = "SELECT * FROM Cliente WHERE cpf = :id";
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt2->execute();
      $row = $stmt2->fetch(PDO::FETCH_ASSOC);

      // Verifica se a consulta retornou resultados
      if ($row) {
        $cpf = $row['cpf'];
        $nome = $result['nome'];
        $telefone = $result['telefone'];
        $marca = $result['marca'];
        $modelo = $result['modelo'];
        $ano_fabricacao = $result['ano_fabricacao'];

        // Cria um array com os dados do cliente
        $cliente = array(
          'cpf' => $cpf,
          'nome' => $nome,
          'telefone' => $telefone,
          'marca' => $marca,
          'modelo' => $modelo,
          'ano_fabricacao' => $ano_fabricacao
        );

        $clientes[] = $cliente;
      }
    }

    // Define o cabeçalho como JSON e imprime os dados dos clientes como resposta
    header('Content-Type: application/json');
    echo json_encode($clientes);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
