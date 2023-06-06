<?php
require_once '../conexao.php';

if (!empty($_POST)) {
  try {
    $pdo->beginTransaction(); // Inicia a transação
    $f_id = $_POST['id'];
    $f_cpf = $_POST['cpf'];
    $f_nome = $_POST['nome'];
    $f_cargo = $_POST['cargo'];

    // Verificar se o funcionário já existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM funcionario WHERE id_func = ?");
    $stmt->execute([$f_id]);
    $funcionario_count = $stmt->fetchColumn();

    if ($funcionario_count > 0) {
      // Atualizar o funcionário na tabela "funcionario"
      $stmt = $pdo->prepare("UPDATE funcionario SET nome = ?, cargo = ? WHERE id_func = ?");
      $stmt->bindParam(1, $f_nome);
      $stmt->bindParam(2, $f_cargo);
      $stmt->bindParam(3, $f_id);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        // Verificar se o arquivo foi enviado corretamente
        if ($_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
          $uploadDir = '../../assets/img/documentos/';  // Diretório onde os arquivos serão salvos

          // Verificar se o arquivo é um ZIP, RAR ou PDF
          $mimeTypes = ['application/zip', 'application/x-rar-compressed', 'application/pdf'];
          $fileType = $_FILES['arquivo']['type'];
          if (!in_array($fileType, $mimeTypes)) {
            $pdo->rollBack(); // Desfaz a transação
            $response = array(
              'success' => false,
              'message' => 'O arquivo enviado não é um formato aceito.'
            );
            // Retorna a resposta como JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
          }

          // Gerar um nome único para o arquivo
          $fileName = uniqid() . '_' . $_FILES['arquivo']['name'];
          $uploadFile = $uploadDir . $fileName;

          // Mover o arquivo para o diretório de upload
          if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadFile)) {
            // Ler o conteúdo do arquivo
            $fotoBytes = file_get_contents($uploadFile);

            // Atualizar o documento e a imagem na tabela "funcionario"
            $stmt = $pdo->prepare("UPDATE funcionario SET doc_pessoa = ?, dir_imagem = ? WHERE id_func = ?");
            $stmt->bindParam(1, $fotoBytes, PDO::PARAM_LOB);
            $stmt->bindParam(2, $uploadFile);
            $stmt->bindParam(3, $f_id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
              $pdo->commit(); // Confirma a transação
              $response = array(
                'success' => true,
                'message' => 'Funcionário atualizado com sucesso.'
              );
            } else {
              $pdo->rollBack(); // Desfaz a transação
              $response = array(
                'success' => false,
                'message' => 'Erro ao atualizar o funcionário no banco de dados.'
              );
            }
          } else {
            $pdo->rollBack(); // Desfaz a transação
            $response = array(
              'success' => false,
              'message' => 'Falha ao fazer upload do arquivo.'
            );
          }
        } else {
          $pdo->commit(); // Confirma a transação (sem atualizar documento e imagem)
          $response = array(
            'success' => true,
            'message' => 'Funcionário atualizado com sucesso.'
          );
        }
      } else {
        $pdo->rollBack(); // Desfaz a transação
        $response = array(
          'success' => false,
          'message' => 'Erro ao atualizar o funcionário no banco de dados.'
        );
      }
    } else {
      $response = array(
        'success' => false,
        'message' => 'O funcionário não existe no banco de dados. A atualização não será realizada.'
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
