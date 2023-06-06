<?php
require_once('../conexao.php');
require('../../libs/fpdf185/fpdf.php');

class PDF extends FPDF
{
  function Header()
  {
    // Definir a fonte e tamanho para o cabeçalho
    $this->SetFont('Arial', 'B', 16);

    // Título do sistema
    $this->Cell(0, 10, 'SecureAlert', 0, 1, 'C');

    // Hora e data do sistema
    date_default_timezone_set('America/Sao_Paulo'); // Definir o fuso horário como "America/Sao_Paulo"
    $this->Cell(0, 10, 'Data: ' . date('d/m/Y'), 0, 1, 'R');
    $this->Cell(0, 10, 'Hora: ' . date('H:i:s'), 0, 1, 'R');

    // Nome do cliente
    if (isset($_POST['nome_cliente'])) {
      $nome_cliente = $_POST['nome_cliente'];
      $this->Cell(0, 10, 'Nome do Cliente: ' . $nome_cliente, 0, 1, 'L');
    }

    // Linha separadora
    $this->Ln(5);

    // Chamar o método da classe pai para evitar conflitos
    parent::Header();
  }

  function Footer()
  {
    // Definir a fonte e tamanho para o rodapé
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);

    // Informações da empresa
    $this->Cell(0, 10, 'SecureAlert | Endereço: Rua ABC, 123 | Telefone: (00) 1234-5678', 0, 0, 'C');
  }
}

// Verifica se foi enviado um ID de cliente via POST
if (isset($_POST['id_cliente'])) {
  $id_cliente = $_POST['id_cliente'];

  try {

    // Consulta SQL
    $sql = "SELECT * FROM EnderecosCliente WHERE id_cliente = :id_cliente";

    // Prepara a consulta
    $stmt = $pdo->prepare($sql);

    // Define o valor do parâmetro :id_cliente
    $stmt->bindParam(':id_cliente', $id_cliente);

    // Executa a consulta
    $stmt->execute();

    // Obtém os resultados da consulta
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cria um objeto FPDF personalizado
    $pdf = new PDF('L', 'mm', array(330, 210));
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->AddPage();

    // Define a fonte e o tamanho para o cabeçalho
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Relatorio Cliente', 0, 1, 'C');

    // Verifica se a consulta retornou resultados
    if (!empty($result)) {
      // Define a fonte e o tamanho para os dados
      $pdf->SetFont('Arial', '', 10);

      // Cabeçalho da tabela
      $pdf->Cell(40, 10, mb_convert_encoding('Nome Cliente', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(40, 10, mb_convert_encoding('Rua', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(20, 10, mb_convert_encoding('Número', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(40, 10, mb_convert_encoding('Bairro', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(40, 10, mb_convert_encoding('Tipo de Endereço', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(40, 10, mb_convert_encoding('Complemento', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(30, 10, mb_convert_encoding('CEP', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(40, 10, mb_convert_encoding('Cidade', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
      $pdf->Cell(20, 10, mb_convert_encoding('UF', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

      // Exibe os dados retornados
      foreach ($result as $row) {
        $pdf->Cell(40, 10, mb_convert_encoding($row["nome_cliente"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(40, 10, mb_convert_encoding($row["rua"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(20, 10, mb_convert_encoding($row["numero"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(40, 10, mb_convert_encoding($row["bairro"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(40, 10, mb_convert_encoding($row["tipo_endereco"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(40, 10, mb_convert_encoding($row["complemento"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(30, 10, mb_convert_encoding($row["cep"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(40, 10, mb_convert_encoding($row["cidade"], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(20, 10, mb_convert_encoding($row["uf"], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');
      }
    } else {
      $pdf->Cell(0, 10, 'Nenhum resultado encontrado.', 0, 1, 'C');
    }

    // Finaliza e gera o PDF
    ob_clean(); // Limpa qualquer saída anterior
    $pdf->Output('I', 'relatorio.pdf'); // Envia o PDF como resposta para o navegador
  } catch (PDOException $e) {
    echo "Erro ao executar a consulta: " . $e->getMessage();
  }
} else {
  echo "ID do cliente não fornecido.";
}
