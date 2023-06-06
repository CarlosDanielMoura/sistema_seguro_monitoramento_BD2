<?php
require_once './conexao.php';

$type_user = $_SESSION['tipo'];



$cliente = array();
$sql = "SELECT * FROM Cliente";

try {
  //code...
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute()) {
    $cliente = $stmt->fetchAll();
  } else {
    die("Erro ao conectar no banco.");
  }
} catch (Exception $e) {
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <title>Cliente</title>
  <link rel="stylesheet" href="../css/user.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-12">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cadastro_cliente">Inserir Cliente</button>
      </div>

      <div class="row">
        <div class="col-12">
          <?php if (!empty($cliente)) { ?>
            <div class="row mt-4">
              <table class="table table-striped table-bordered table-dark" style="font-size: 14px;">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Dt Nasc</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Pessoa</th>
                    <!-- <th scope="col">Dt Reg</th> -->
                    <th scope="col">Observacao</th>
                    <th scope="col">Email</th>
                    <th scope="col" style="width: 180px;">Ações</th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($cliente as $u) { ?>
                    <tr>
                      <th scope="row"><?php echo $u['id'] ?></th>
                      <td class="nome"><?php echo $u['nome'] ?></td>
                      <td><?php echo $u['telefone'] ?></td>
                      <td><?php echo $u['data_nascimento'] ?></td>
                      <td><?php echo $u['cpf'] ?></td>
                      <td><?php echo $u['tipo_pessoa'] ?></td>
                      <!-- <td><?php echo $u['data_registro'] ?></td> -->
                      <td><?php echo $u['observacao'] ?></td>
                      <td><?php echo $u['email'] ?></td>
                      <td style="width: 280px;">
                        <button type="button" class="btn btn-warning btn-alterar" data-bs-toggle="modal" data-bs-target="#cadastro_alter" data-whatever="<?php echo $u['id'] ?>" data-nome="<?php echo $u['nome'] ?>" data-telefone="<?php echo $u['telefone'] ?>" data-data_nascimento="<?php echo $u['data_nascimento'] ?>" data-cpf="<?php echo $u['cpf'] ?>" data-tipo_pessoa="<?php echo $u['tipo_pessoa'] ?>" data-observacao="<?php echo $u['observacao'] ?>" data-email="<?php echo $u['email'] ?>">
                          Alterar
                        </button>
                        <?php if ($type_user == 'gerente') { ?>
                          <button type="button" class="btn btn-danger btn_exluir_cliente" data-bs-toggle="modal" data-bs-target="#btn_excluir_cli" data-id="<?php echo $u['id'] ?>" data-nome="<?php echo $u['nome'] ?>">Excluir</button>
                        <?php } ?>
                        <button type="button" class="btn btn-danger btn-ver_end" data-bs-toggle="modal" data-bs-target="#btn_excluir_end" data-id="<?php echo $u['id'] ?>"><ion-icon name="document-attach-outline"></ion-icon></button>
                      </td>
                    </tr>

                  <?php  } ?>

                </tbody>
              </table>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <!-- CLIENTE CADASTRO -->
  <div class="modal fade" id="cadastro_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastrar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite seu nome" aria-label="nome" id="nome_cli">
            </div>
            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite seu Telefone" aria-label="telefone_cli" id="telefone_cli">
            </div>
            <div class="col-6 mt-4">
              <input type="date" class="form-control" placeholder="Digite sua data de nascimento" aria-label="nascimento" id="data_nasc_cli">
            </div>
            <div class="col-6 mt-4">
              <input type="text" class="form-control cpf" placeholder="Digite seu CPF" aria-label="cpf" id="cpf_cli">
            </div>
            <div class="col-12 mt-4">
              <select class="form-select" aria-label="" id="tipo_end">
                <option value="Fisica">Física</option>
                <option value="Juridica">Jurídica</option>
              </select>
            </div>
            <div class="col-12 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu Email" aria-label="email" id="email_cli">
            </div>
            <div class="col-12 mt-4">
              <div class="form-floating">
                <textarea class="form-control" placeholder="Digite sua Observação" id="obs_cli" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Observação</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <h4 style="text-align: center;" class="msgErro text-danger"></h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="fechar_cli">Fechar</button>
          <button type="button" class="btn btn-primary" id="btn_cad_cli">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- CLIENTE ALTERACAO -->
  <div class="modal fade" id="cadastro_alter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastrar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite seu nome" aria-label="nome" id="nome_cli_alter">
            </div>

            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite seu Telefone" aria-label="telefone_cli" id="telefone_cli_alter">
            </div>
            <div class="col-6 mt-4">
              <input type="date" class="form-control" placeholder="Digite sua data de nascimento" aria-label="nascimento" id="data_nasc_cli_alter">
            </div>

            <div class="col-6 mt-4">
              <input type="text" class="form-control cpf" placeholder="Digite seu CPF" aria-label="cpf" id="cpf_cli_alter">
            </div>
            <div class="col-12 mt-4">
              <select class="form-select" aria-label="" id="tipo_end_alter">
                <option value="Fisica">Física</option>
                <option value="Juridica">Jurídica</option>
              </select>
            </div>

            <div class="col-12 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu Email" aria-label="email" id="email_alter">
            </div>
            <div class="col-12 mt-4">
              <div class="form-floating">
                <textarea class="form-control" placeholder="Digite sua Observação" id="obs_cli_alter" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Observação</label>
              </div>
            </div>
          </div>
          <input type="hidden" id="id_cli_alter">
          <div class="row mt-3">
            <h4 style="text-align: center;" class="msgErro text-danger"></h4>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="fechar_alter_cli">Fechar</button>
          <button type="button" class="btn btn-primary" id="btn_alter_cli">Alterar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Excluir cliente -->
  <div class="modal fade" id="btn_excluir_cli" tabindex="-1" aria-labelledby="btn_excluir_cli" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Endereco <strong><em><span id="cliente_nome_ex"></span></em></strong>
          </h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-danger text-center" style="font-size: 24px;">Deseja realmente excluir ?</p>
          <input type="hidden" id="id_exclusao_cliente">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="fechar_exclusao">Fechar</button>
          <button type="button" class="btn btn-danger" id="btn_confirma_exclu">Confirmar</button>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-vViR6GFxyqz/8yh4Dtl8QF/54Nq4XHmhdpjE7PZhZ1GR2yoiXX3v4jYYh7gRbkTM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function() {

      $('#btn_cad_cli').on('click', function() {
        let nome = $('#nome_cli').val();
        let telefone = $('#telefone_cli').val();
        let dataNasc = $('#data_nasc_cli').val();
        let cpf = $('#cpf_cli').val();
        let tipo = $('#tipo_end').val();
        let email = $('#email_cli').val();
        let observacao = $('#obs_cli').val();


        var dataAtual = new Date();

        // Obtendo a data atual no formato "yyyy-mm-dd"
        var dataFormatada = dataAtual.toISOString().split('T')[0];

        if (nome == '') {
          const msg = 'Preencha o nome';
          $('.msgErro').text(msg);
          return;
        }

        if (telefone == '') {
          const msg = 'Preencha o telefone';
          $('.msgErro').text(msg);
          return;
        }

        if (dataNasc == '') {
          const msg = 'Preencha a data de nascimento';
          $('.msgErro').text(msg);
          return;
        }

        if (cpf == '') {
          const msg = 'Preencha o CPF';
          $('.msgErro').text(msg);
          return;
        }

        if (tipo == '') {
          const msg = 'Escolha o tipo de cliente';
          $('.msgErro').text(msg);
          return;
        }

        if (email == '') {
          const msg = 'Preencha o email';
          $('.msgErro').text(msg);
          return;
        }

        $.ajax({
          url: './cliente/inserir.php',
          method: 'POST',
          data: {
            nome: nome,
            telefone: telefone,
            dataNasc: dataNasc,
            cpf: cpf,
            tipo: tipo,
            email: email,
            observacao: observacao,
            dataAtual: dataFormatada,
          },
          success: function(response) {
            console.log(response);
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $("#fechar_cli").click();
              setTimeout(() => {
                location.reload();
              }, 3200);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $("#fechar_cli").click();
              setTimeout(() => {
                location.reload();
              }, 3200);
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Erro',
              text: 'Ocorreu um erro na requisição',
              showConfirmButton: false,
              timer: 3000
            });
            $("#fechar_cli").click();
            setTimeout(() => {
              location.reload();
            }, 3200);
          }
        });
      });

      $('.btn-alterar').on('click', function() {
        var id_cli = $(this).data('whatever');
        var nome = $(this).data('nome');
        var telefone = $(this).data('telefone');
        var data_nascimento = $(this).data('data_nascimento');
        var cpf = $(this).data('cpf');
        var tipo_pessoa = $(this).data('tipo_pessoa');
        var observacao = $(this).data('observacao');
        var email = $(this).data('email');


        $('#id_cli_alter').val(id_cli);
        $('#nome_cli_alter').val(nome);
        $('#telefone_cli_alter').val(telefone);
        $('#data_nasc_cli_alter').val(data_nascimento);
        $('#cpf_cli_alter').val(cpf);
        $('#tipo_end_alter').val(tipo_pessoa);
        $('#obs_cli_alter').val(observacao);
        $('#email_alter').val(email);

      });


      $('#btn_alter_cli').on('click', function() {


        var id_cli = $('#id_cli_alter').val();
        var nome = $('#nome_cli_alter').val();
        var telefone = $('#telefone_cli_alter').val();
        var data_nascimento = $('#data_nasc_cli_alter').val()
        var cpf = $('#cpf_cli_alter').val();
        var tipo_pessoa = $('#tipo_end_alter').val();
        var observacao = $('#obs_cli_alter').val();
        var email = $('#email_alter').val();


        $.ajax({
          url: './cliente/alterar.php',
          method: 'POST',
          dataType: 'json',
          data: {
            id: id_cli,
            nome: nome,
            telefone: telefone,
            data_nascimento: data_nascimento,
            cpf: cpf,
            tipo_pessoa: tipo_pessoa,
            observacao: observacao,
            email: email
          },
          success: function(response) {
            // Executa ação em caso de sucesso
            console.log(response);
            if (response.success) {
              $("#fechar_alter_cli").click();
              Swal.fire({
                icon: 'success',
                title: 'Alteração realizada com sucesso!',
                showConfirmButton: false,
                timer: 2000
              });
              setTimeout(() => {
                location.reload();
              }, 2100);
            } else {
              $("#fechar_alter_cli").click();
              Swal.fire({
                icon: 'error',
                title: 'Falha em alterar cliente',
                showConfirmButton: false,
                timer: 2000
              });
              setTimeout(() => {
                location.reload();
              }, 2100);
            }
          },
          error: function(xhr, status, error) {
            // Executa ação em caso de erro
            console.error('Erro ao enviar os dados:', error);
          }
        });
      })

      $('.btn_exluir_cliente').on('click', function() {
        var id_cli = $(this).data('id');
        var nome = $(this).data('nome');

        $('#id_exclusao_cliente').val(id_cli);
        $('#cliente_nome_ex').text(nome);
      })


      $('#btn_confirma_exclu').on('click', function() {
        var id = $('#id_exclusao_cliente').val();



        $.ajax({
          url: './cliente/excluir.php',
          method: 'POST',
          dataType: 'json',
          data: {
            id: id
          },
          success: function(response) {
            // Executa ação em caso de sucesso
            if (response.success) {
              $("#fechar_exclusao").click();
              Swal.fire({
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 2000
              }).then(() => {
                // Executar ação adicional em caso de sucesso
                // Por exemplo, recarregar a página
                location.reload();
              });
            } else {
              $("#fechar_exclusao").click();
              Swal.fire({
                icon: 'error',
                title: response.message,
                showConfirmButton: false,
                timer: 2000
              });
            }
          },
          error: function(xhr, status, error) {
            // Executa ação em caso de erro
            Swal.fire({
              icon: 'error',
              title: 'Erro ao excluir cliente, pois ele tem endereço cadastro no nome.',
              showConfirmButton: false,
              timer: 2000
            });
          }
        });

      })

      $(".btn-ver_end").click(function() {
        // Obtém o ID Cliente do atributo "data-id" do botão
        var idCliente = $(this).data('id'); // Substitua pelo ID do cliente desejado
        var idCliente = $(this).data('id');
        // Faz a chamada AJAX
        $.ajax({
          url: "./cliente/gerarPDF.php", // Caminho para o arquivo PHP que gera o relatório
          type: "POST",
          data: {
            id_cliente: idCliente
          },
          xhrFields: {
            responseType: 'blob' // Define o tipo de resposta como 'blob'
          },
          success: function(response, status, xhr) {
            // Verifica se a resposta é um Blob
            if (response instanceof Blob) {
              // Cria uma URL temporária para o relatório PDF
              var url = URL.createObjectURL(response);

              // Cria um link para fazer o download do relatório PDF
              var link = document.createElement('a');
              link.href = url;
              link.download = 'relatorio.pdf';
              link.click();
            } else {
              console.log("Resposta inválida: não é um Blob");
            }
          },
          error: function(xhr, status, error) {
            console.log("Erro na chamada AJAX: " + error);
          }
        });

      });



      document.addEventListener("DOMContentLoaded", function() {
        // Função do CPF/CNPJ
        $('#cpf_cli').mask('000.000.000-00');
        $('#tipo_end').change(function() {
          if ($(this).val() === 'Fisica') {
            $('#cpf_cli').mask('000.000.000-00');
          } else {
            $('#cpf_cli').mask('00.000.000/0000-00');
          }
        });

        // Máscara do Telefone
        $('.form-control.telefone').mask('(00) 0000-0000');
      });
    });
  </script>

</body>

</html>
