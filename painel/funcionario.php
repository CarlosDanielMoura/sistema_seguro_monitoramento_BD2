<?php



require_once './conexao.php';



$type_user = $_SESSION['tipo'];
$email_user = $_SESSION['email'];

$user = array();

$sql = "SELECT * FROM funcionario";
$stmt = $pdo->prepare($sql);
if ($stmt->execute()) {
  $func = $stmt->fetchAll();
} else {
  die("Erro ao conectar no banco.");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <title>Funcionario</title>
  <link rel="stylesheet" href="../css/user.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">



</head>

<body>

  <div class="row">
    <div class="col-12">
      <?php if ($type_user  == 'gerente') { ?>
        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#cadastro_funcionario">Cadastrar Fucionario</button>
      <?php } ?>
      <div class="row">
        <div class="col-12">
          <?php if (!empty($func)) { ?>
            <div class="row mt-4 ">
              <table class="table table-striped table-bordered table-dark" style="font-size: 14px;">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($func as $f) { ?>
                    <tr>
                      <th scope="row"><?php echo $f['id_func'] ?></th>
                      <td><?php echo $f['cpf'] ?></td>
                      <td><?php echo $f['nome'] ?></td>
                      <td><?php echo $f['cargo'] ?></td>
                      <td style="width: 280px;">

                        <?php if ($type_user == 'gerente') { ?>
                          <button type="button" class="btn btn-warning btn-alterar_funcionario" data-bs-toggle="modal" data-bs-target="#alter_func" data-id="<?php echo $f['id_func'] ?>" data-cpf="<?php echo $f['cpf'] ?>" data-nome="<?php echo $f['nome'] ?>" data-cargo="<?php echo $f['cargo'] ?>">Alterar</button>
                          <button type="button" class="btn btn-danger btn-excluir_func" data-bs-toggle="modal" data-bs-target="#btn_excluir_end" data-id="<?php echo $f['id_func'] ?>" data-nome="<?php echo $f['nome'] ?>">Excluir</button>
                        <?php } ?>
                        <button type="button" class="btn btn-info btn-mostrar-pdf" data-bs-toggle="modal" data-bs-target="#pdf_func" data-id_func="<?php echo $f['id_func'] ?>">Ver PDF</button>

                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <!-- Modal Cadastro de Funcionario -->
    <div class="modal fade" id="cadastro_funcionario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-lg-down">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cadastrar Funcionario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-6">
                <input type="text" class="form-control" placeholder="Digite seu CPF" aria-label="cpf" id="cpf_func" maxlength="11">
              </div>
              <div class="col-6 ">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder=" Digite seu nome" aria-label="nome" id="cad_nome_func">
                </div>
              </div>
              <div class="col-12 mt-4">
                <select class="form-select" aria-label="" id="cad_tipo_func">
                  <option selected disabled value="">Escolha o Cargo</option>
                  <option value="funcionario">Atendente</option>
                  <option value="gerente">Gestor</option>
                  <option value="gerente">Segurança</option>
                </select>
              </div>
              <div class="col-12 mt-4">
                <div class="mb-3">
                  <label for="formFile" class="form-label">Carregue seus arquivos. Ex: RG OU CNH em <strong> PDF</strong></label>
                  <input class="form-control" type="file" id="form_cada_func">
                </div>
              </div>

            </div>
            <div class="row mt-3 ">
              <h4 style="text-align: center;" class="msgErro text-danger"></h4>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" id="cadastrar_func">Cadastrar</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal Cadastro de Funcionario-->
    <div class="modal fade" id="alter_func" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-lg-down">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Alterar Funcionario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-6">
                <input type="text" class="form-control" placeholder="Digite seu CPF" aria-label="cpf" id="cpf_alter" maxlength="11">
              </div>
              <div class="col-6 ">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder=" Digite seu nome" aria-label="nome" id="nome_alter">
                </div>
              </div>
              <div class="col-12 mt-4">
                <select class="form-select" aria-label="" id="alter_cargo_func">
                  <option selected disabled value="">Escolha o Cargo</option>
                  <option value="funcionario">Atendente</option>
                  <option value="gestor">Gestor</option>
                  <option value="seguranca">Segurança</option>
                </select>
              </div>
              <div class="col-12 mt-4">
                <div class="mb-3">
                  <label for="formFile" class="form-label">Carregue seus arquivos. Ex: RG OU CNH em <strong> PDF</strong></label>
                  <input class="form-control" type="file" id="form_alter_func">
                </div>
              </div>

            </div>
            <div class="row mt-3 ">
              <h4 style="text-align: center;" class="msgErro text-danger"></h4>
            </div>
          </div>

          <input type="hidden" value="" id="id_alter_func_hidden">
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" id="alterar_func">Alterar</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Excluir Funcionario -->
    <div class="modal fade" id="btn_excluir_end" tabindex="-1" aria-labelledby="btn_excluir_cli" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Funcionario <strong><em><span id="id_func_excluir"></span></em></strong>
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="text-danger text-center" style="font-size: 24px;">Deseja realmente excluir ?</p>
            <input type="hidden" id="id_excluir_funcionario">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="fechar_exclusao">Fechar</button>
            <button type="button" class="btn btn-danger" id="btn_confirma_exclu">Confirmar</button>
          </div>
        </div>
      </div>
    </div>



    <!-- Modal Mosrtar pdf -->
    <div class="modal fade" id="pdf_func" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              <h3>PDF DOCUMENTOS PESSOAIS</h3>
            </h5>
            <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12" id="pdf_funcionario">

              </div>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-vViR6GFxyqz/8yh4Dtl8QF/54Nq4XHmhdpjE7PZhZ1GR2yoiXX3v4jYYh7gRbkTM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>


  <script>
    $(document).ready(function() {

      $("#cadastrar_func").on("click", function() {
        let cpf = $('#cpf_func').val();
        let nome = $('#cad_nome_func').val();
        let cargo = $('#cad_tipo_func').val();
        let arquivo = $('#form_cada_func').prop('files')[0];



        if (!arquivo) {
          const msg = 'Selecione o documento do funcionário.';
          $('.msgErro').text(msg);
          return;
        }

        const allowedExtensions = ['.zip', '.rar', '.pdf'];
        const fileExtension = arquivo.name.substring(arquivo.name.lastIndexOf('.')).toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
          const msg = 'Formato de arquivo inválido. Aceitamos apenas PDF.';
          $('.msgErro').text(msg);
          return;
        }

        let formData = new FormData();
        formData.append('cpf', cpf);
        formData.append('nome', nome);
        formData.append('cargo', cargo);
        formData.append('arquivo', arquivo);

        $.ajax({
          url: './funcionario/inserir.php',
          method: 'POST',
          data: formData,
          processData: false, // Não processar dados do FormData
          contentType: false, // Não definir tipo de conteúdo
          success: function(response) {

            if (response.success) {

              Swal.fire({
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $("#fechar_end").click();
              // setTimeout(() => {
              //   location.reload();
              // }, 3200);
            } else {

              Swal.fire({
                icon: 'error',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $("#fechar_end").click();
              // setTimeout(() => {
              //   location.reload();
              // }, 3200);
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
            $("#fechar_end").click();
            // setTimeout(() => {
            //   location.reload();
            // }, 3200);
          }
        });
      })

      $('.btn-mostrar-pdf').on('click', function() {
        let id = $(this).data('id_func');
        $.ajax({
          url: './funcionario/listarPdf.php',
          method: 'POST',
          dataType: 'json',
          data: {
            id: id
          },
          success: function(response) {
            // Executa ação em caso de sucesso
            let caminho = response;
            let caminhoSimplificado = caminho.replace(/(\.\.\/)+/g, '../');
            let embedHtml = '<embed src="' + caminhoSimplificado + '" type="application/pdf" width="100%" height="500px" />';
            $('#pdf_funcionario').html(embedHtml);
            // Acesso direto aos dados na variável 'response'
          },
          error: function(xhr, status, error) {
            // Executa ação em caso de erro
            console.log(xhr.responseText);
            console.error('Erro ao enviar os dados:', error);

          }
        });
      });


      $(".btn-alterar_funcionario").on("click", function(e) {

        var id_func = $(this).data("id");
        var cpf = $(this).data('cpf');
        var nome = $(this).data('nome');
        var cargo = $(this).data('cargo');



        $("#id_alter_func_hidden").val(id_func);
        $("#cpf_alter").val(cpf);
        $("#nome_alter").val(nome);
        $("#alter_cargo_func").val(cargo);
      })

      $("#alterar_func").on("click", function() {
        var id = $("#id_alter_func_hidden").val();
        var cpf = $("#cpf_alter").val();
        var nome = $("#nome_alter").val();
        var cargo = $("#alter_cargo_func").val();
        let arquivo = $('#form_alter_func').prop('files')[0];



        if (!arquivo) {
          const msg = 'Selecione o documento do funcionário.';
          $('.msgErro').text(msg);
          return;
        }

        const allowedExtensions = ['.zip', '.rar', '.pdf'];
        const fileExtension = arquivo.name.substring(arquivo.name.lastIndexOf('.')).toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
          const msg = 'Formato de arquivo inválido. Aceitamos apenas PDF.';
          $('.msgErro').text(msg);
          return;
        }

        let formData = new FormData();
        formData.append('id', id);
        formData.append('cpf', cpf);
        formData.append('nome', nome);
        formData.append('cargo', cargo);
        formData.append('arquivo', arquivo);

        $.ajax({
          url: './funcionario/alterar.php',
          method: 'POST',
          data: formData,
          processData: false, // Não processar dados do FormData
          contentType: false, // Não definir tipo de conteúdo
          success: function(response) {

            if (response.success) {

              Swal.fire({
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $("#fechar_end").click();
              // setTimeout(() => {
              //   location.reload();
              // }, 3200);
            } else {

              Swal.fire({
                icon: 'error',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $("#fechar_end").click();
              // setTimeout(() => {
              //   location.reload();
              // }, 3200);
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
            $("#fechar_end").click();
            // setTimeout(() => {
            //   location.reload();
            // }, 3200);
          }
        });

      })


      $('.btn-excluir_func').on('click', function() {
        var id = $(this).data('id');
        var nome = $(this).data('nome');
        $("#id_excluir_funcionario").val(id);
        $("#id_func_excluir").text(nome);
      })


      $('#btn_confirma_exclu').on('click', function() {
        var id = $('#id_excluir_funcionario').val();

        $.ajax({
          url: './funcionario/excluir.php',
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

    })
  </script>
</body>

</html>
