<?php
require_once '../conexao.php';

if (!empty($_POST)) {
  try {
    $pdo->beginTransaction(); // Inicia a transação

    $p_rua = $_POST['rua'];
    $p_numero = $_POST['numero'];
    $p_bairro = $_POST['bairro'];
    $p_tipo_endereco = $_POST['tipo'];
    $p_complemento = $_POST['complemento'];
    $p_cep = $_POST['cep'];
    $p_cidade = $_POST['cidade'];
    $p_uf = $_POST['uf'];
    $p_cliente = $_POST['cliente'];

    // Verificar se o arquivo foi enviado corretamente
    if ($_FILES['fotoCliente']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = '../../assets/img/fotos_clientes/';  // Diretório onde as fotos serão salvas

      // Verificar se o arquivo é uma imagem
      $mimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
      $fileType = $_FILES['fotoCliente']['type'];
      if (!in_array($fileType, $mimeTypes)) {
        $response = array(
          'success' => false,
          'message' => 'O arquivo enviado não é uma imagem válida.'
        );
        $pdo->rollBack(); // Desfaz a transação
        // Retorna a resposta como JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
      }

      // Gerar um nome único para o arquivo
      $fileName = uniqid() . '_' . $_FILES['fotoCliente']['name'];
      $uploadFile = $uploadDir . $fileName;

      // Mover o arquivo para o diretório de upload
      if (move_uploaded_file($_FILES['fotoCliente']['tmp_name'], $uploadFile)) {
        // Converter a foto para uma sequência de bytes
        $fotoBytes = file_get_contents($uploadFile);

        // Verificar se o endereço já existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM endereco WHERE rua = ? AND numero = ? AND bairro = ? AND tipo_endereco = ?");
        $stmt->execute([$p_rua, $p_numero, $p_bairro, $p_tipo_endereco]);
        $endereco_count = $stmt->fetchColumn();

        if ($endereco_count > 0) {
          $response = array(
            'success' => false,
            'message' => 'O endereço já existe no banco de dados. A inserção não será realizada.'
          );
        } else {
          // Inserir o endereço
          $stmt = $pdo->prepare("INSERT INTO endereco (rua, numero, bairro, tipo_endereco, complemento, id_pessoa, cep, cidade, uf, img_comprovante_end,dir_imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
          $stmt->bindParam(1, $p_rua);
          $stmt->bindParam(2, $p_numero);
          $stmt->bindParam(3, $p_bairro);
          $stmt->bindParam(4, $p_tipo_endereco);
          $stmt->bindParam(5, $p_complemento);
          $stmt->bindParam(6, $p_cliente);
          $stmt->bindParam(7, $p_cep);
          $stmt->bindParam(8, $p_cidade);
          $stmt->bindParam(9, $p_uf);
          $stmt->bindParam(10, $fotoBytes, PDO::PARAM_LOB);
          $stmt->bindParam(11, $uploadFile);
          if ($stmt->execute()) {
            $pdo->commit(); // Confirma a transação
            $response = array(
              'success' => true,
              'message' => 'Endereço inserido com sucesso.'
            );
          } else {
            $pdo->rollBack(); // Desfaz a transação
            $response = array(
              'success' => false,
              'message' => 'Erro ao inserir o endereço no banco de dados.'
            );
          }
        }
      } else {
        $pdo->rollBack(); // Desfaz a transação
        $response = array(
          'success' => false,
          'message' => 'Falha ao fazer upload da foto.'
        );
      }
    } else {
      $pdo->rollBack(); // Desfaz a transação
      $response = array(
        'success' => false,
        'message' => 'Erro ao enviar o arquivo. Verifique se o arquivo é válido e tente novamente.'
      );
    }
  } catch (PDOException $e) {
    $pdo->rollBack(); // Desfaz a transação
    $response = array(
      'success' => false,
      'message' => 'Erro de conexão com o banco de dados: ' . $e->getMessage()
    );
  }

  // Retorna a resposta como JSON
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}
