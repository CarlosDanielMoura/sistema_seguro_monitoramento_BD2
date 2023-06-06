<?php
require_once './conexao.php';

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

  $sql3 = 'SELECT * FROM vw_cliente_seguro_monitoramento';
  $stmt3 = $pdo->prepare($sql3);
  $stmt3->execute();
  $results3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
  $clientesMonitoramento = array();
  foreach ($results3 as $m) {
    $cpf_cliente = $m['fk_cliente_cpf'];
    $marca = $m['marca'];
    $modelo = $m['modelo'];
    $placa = $m['placa'];
    $monitoramento = $m['fk_monitoramento_id_monitoramento'];

    $monitoramento = array(
      'cpf_cliente' => $cpf_cliente,
      'marca' => $marca,
      'modelo' => $modelo,
      'placa' => $placa,
      'monitoramento' => $monitoramento
    );
    $clientesMonitoramento[] = $monitoramento;
  }


  // Define o cabeçalho como JSON e imprime os dados dos clientes como resposta
} catch (Exception $e) {
  echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Exemplo de Nav-Tabs Bootstrap 5</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/user.css">

  <style>
    .nav-item button {
      color: whitesmoke;
    }

    h3,
    p {
      color: whitesmoke;
    }
  </style>
</head>

<body>
  <ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="cliente-obs-tab" data-bs-toggle="tab" data-bs-target="#obs_cliente" type="button" role="tab" aria-controls="obs_cliente" aria-selected="true">Logs de alteração de observações de clientes</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="cliente-seguro-tab" data-bs-toggle="tab" data-bs-target="#cliente_seguro" type="button" role="tab" aria-controls="cliente_seguro" aria-selected="false">View Cliente seguro</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="monitoramento-tab" data-bs-toggle="tab" data-bs-target="#cliente_monitoramento" type="button" role="tab" aria-controls="cliente_seguro" aria-selected="false">Cliente Automavel Monitoramento</button>
    </li>
  </ul>

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active mt-5" id="obs_cliente" role="tabpanel" aria-labelledby="cliente-obs-tab">
    </div>

    <div class="tab-pane fade" id="cliente_seguro" role="tabpanel" aria-labelledby="cliente-seguro-tab">
      <table class="table table-striped table-bordered table-dark mt-5">
        <thead>
          <tr>
            <th>CPF</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Ano de Fabricação</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($clientes as $c) {
            echo "<tr>";
            echo "<td>" . $c['cpf'] . "</td>";
            echo "<td>" . $c['nome'] . "</td>";
            echo "<td>" . $c['telefone'] . "</td>";
            echo "<td>" . $c['marca'] . "</td>";
            echo "<td>" . $c['modelo'] . "</td>";
            echo "<td>" . date("Y", strtotime($c['ano_fabricacao'])) . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>

    </div>

    <div class="tab-pane fade" id="cliente_monitoramento" role="tabpanel" aria-labelledby="monitoramento-tab">
      <table class="table table-striped table-bordered table-dark mt-5">
        <thead>
          <tr>
            <th>CPF Cliente</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Placa </th>
            <th>Monitoramento</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($clientesMonitoramento as $m) {
            echo "<tr>";
            echo "<td>" . $m['cpf_cliente'] . "</td>";
            echo "<td>" . $m['marca'] . "</td>";
            echo "<td>" . $m['modelo'] . "</td>";
            echo "<td>" . $m['placa'] . "</td>";
            echo "<td>" . $m['monitoramento'] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#cliente-obs-tab').on('click', function() {
        $.ajax({
          url: './logs/listarLogs.php',
          method: 'POST',
          dataType: 'json',
          success: function(response) {
            montarTabelaClientes(response);
          },
          error: function(xhr, status, error) {
            // Executa ação em caso de erro
          }
        });
      });

      $('#cliente-obs-tab').trigger('click');
    });

    function montarTabelaClientes(data) {
      var tabela = '<table class="table table-striped table-bordered table-dark">';
      tabela += '<thead><tr><th>ID</th><th>Nome</th><th>Nova Observação</th><th>Horário</th></tr></thead>';
      tabela += '<tbody>';

      for (var i = 0; i < data.length; i++) {
        var cliente = data[i];
        tabela += '<tr>';
        tabela += '<td>' + cliente.id + '</td>';
        tabela += '<td>' + cliente.nome + '</td>';
        tabela += '<td>' + cliente.nova_observacao + '</td>';
        tabela += '<td>' + cliente.horario_formatado + '</td>';
        tabela += '</tr>';
      }

      tabela += '</tbody></table>';

      // Adiciona a tabela à div com o ID "obs_cliente"
      $('#obs_cliente').html(tabela);
    }
  </script>
</body>

</html>
