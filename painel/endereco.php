<?php
require_once './conexao.php';

try {
  //code...
  $sql = "SELECT * FROM Cliente";
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute()) {
    $cliente = $stmt->fetchAll();
  } else {
    die("Erro ao conectar no banco.");
  }

  $sql2 = "SELECT * FROM endereco";
  $stmt2 = $pdo->prepare($sql2);
  if ($stmt2->execute()) {
    $endereco = $stmt2->fetchAll();
  } else {
    die("Erro ao conectar no banco.");
  }
} catch (Exception $e) {
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <title>Endereços</title>
  <link rel="stylesheet" href="../css/user.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">



</head>


<body>
  <div class="container">

    <?php if (!empty($cliente)) { ?>
      <div class="row">
        <div class="col-12">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cadastro_endereco">Inserir Endereço</button>
        </div>
      </div>
    <?php } else {
      echo '<div class="alert alert-danger"> <strong>Nenhum cliente cadastrado, é necessário o cadastro de um cliente </strong> </div>';
    } ?>
    <div class="row">
      <div class="col-12">
        <?php if (!empty($endereco)) { ?>
          <div class="row mt-4">
            <table class="table table-striped table-bordered table-dark" style="font-size: 14px;">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Rua</th>
                  <th scope="col">Número</th>
                  <th scope="col">Bairro</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Complemento</th>
                  <th scope="col">CEP</th>
                  <th scope="col">Cidade</th>
                  <th scope="col">UF</th>
                  <th scope="col">Comp. Residencia</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($endereco as $e) { ?>
                  <tr>
                    <th scope="row"><?php echo $e['id_endereco'] ?></th>
                    <td><?php echo $e['rua'] ?></td>
                    <td><?php echo $e['numero'] ?></td>
                    <td><?php echo $e['bairro'] ?></td>
                    <td><?php echo $e['tipo_endereco'] ?></td>
                    <td><?php echo $e['complemento'] ?></td>
                    <td><?php echo $e['cep'] ?></td>
                    <td><?php echo $e['cidade'] ?></td>
                    <td><?php echo $e['uf'] ?></td>
                    <td>
                      <a href="<?php echo str_replace('../../', '../', $e['dir_imagem']) ?>" data-lightbox="image-<?php echo $e['id_endereco'] ?>">
                        <img src="<?php echo str_replace('../../', '../', $e['dir_imagem']) ?>" alt="Imagem do endereço" style="max-width: 100px;">
                      </a>
                    </td>
                    <td style="width: 187px;">
                      <button type="button" class="btn btn-warning btn-alterar_end" data-bs-toggle="modal" data-bs-target="#alterar_end" data-id="<?php echo $e['id_endereco'] ?>" data-rua="<?php echo $e['rua'] ?>" data-numero="<?php echo $e['numero'] ?>" data-bairro="<?php echo $e['bairro'] ?>" data-tipo_endereco="<?php echo $e['tipo_endereco'] ?>" data-complemento="<?php echo $e['complemento'] ?>" data-cep="<?php echo $e['cep'] ?>" data-cidade="<?php echo $e['cidade'] ?>" data-uf="<?php echo $e['uf'] ?>" data-id_pessoa="<?php echo $e['id_pessoa'] ?>">Alterar</button>
                      <button type="button" class="btn btn-danger btn-excluir_end" data-bs-toggle="modal" data-bs-target="#btn_excluir_end" data-id="<?php echo $e['id_endereco'] ?>" data-rua="<?php echo $e['rua'] ?>" data-numero="<?php echo $e['numero'] ?>" data-bairro="<?php echo $e['bairro'] ?>">Excluir</button>
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

  <div class="modal fade" id="cadastro_endereco" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastrar Endereço</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cep" aria-label="cep" aria-describedby="cep" id="vlr_cep_end" maxlength="9">
                <button class="btn btn-outline-info" type="button" id="cep_end">Buscar Cep</button>
              </div>
            </div>

            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite sua rua" aria-label="rua" id="rua_end">
            </div>
            <div class="col-6 ">
              <div class="input-group">
                <input type="number" class="form-control" placeholder=" Digite seu numero" aria-label="numero" id="numero_end">
              </div>
            </div>

            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu bairro" aria-label="bairro" id="bairro_end">
            </div>
            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu complemento" aria-label="complemento" id="complemento_end">
            </div>

            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite sua cidade" aria-label="cidade" id="cidade_end">
            </div>

            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu UF" aria-label="uf" id="uf_end" maxlength="5">
            </div>
            <div class="col-12 mt-4">
              <select class="form-select" aria-label="" id="tipo_end">
                <option value="Residencial">Residencial</option>
                <option value="Comercial">Comercial</option>
              </select>
            </div>

            <div class="col-12 mt-4">
              <?php if (!empty($cliente)) { ?>
                <select class="form-select" id="cliente_end">
                  <option selected disabled value="">Selecione um cliente</option>
                  <?php foreach ($cliente as $c) { ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['nome']; ?></option>
                  <?php } ?>
                </select>
              <?php } ?>
            </div>

            <div class="col-12 mt-4">
              <div class="mb-3">
                <label for="formFile" class="form-label">Selecione uma foto do cliente</label>
                <input class="form-control" type="file" id="formFile">
              </div>
            </div>
          </div>

          <div class="row mt-3 ">
            <h4 style="text-align: center;" class="msgErro text-danger"></h4>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="fechar_end">Fechar</button>
          <button type="button" class="btn btn-primary" id="cadastrar_end">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Alterar de endereco -->
  <div class="modal fade" id="alterar_end" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alterar Endereço</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cep" aria-label="cep" aria-describedby="cep" id="cep_end" maxlength="8">
              </div>
            </div>

            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite sua rua" aria-label="rua" id="rua_end_alter">
            </div>
            <div class="col-6 ">
              <div class="input-group">
                <input type="number" class="form-control" placeholder=" Digite seu numero" aria-label="numero" id="numero_end_alter">
              </div>
            </div>

            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu bairro" aria-label="bairro" id="bairro_end_alter">
            </div>
            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu complemento" aria-label="complemento_alter" id="complemento_end_alter">
            </div>

            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite sua cidade" aria-label="cidade" id="cidade_end_alter">
            </div>

            <div class="col-6 mt-4">
              <input type="text" class="form-control" placeholder="Digite seu UF" aria-label="uf" id="uf_end_alter" maxlength="5">
            </div>
            <div class="col-12 mt-4">
              <select class="form-select" aria-label="" id="tipo_end_alter">
                <option value="Residencial">Residencial</option>
                <option value="Comercial">Comercial</option>
              </select>
            </div>

            <div class="col-12 mt-4">
              <?php if (!empty($cliente)) { ?>
                <select class="form-select" id="cliente_end_atler">
                  <option selected disabled value="">Selecione um cliente</option>
                  <?php foreach ($cliente as $c) { ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['nome']; ?></option>
                  <?php } ?>
                </select>
              <?php } ?>
            </div>

            <div class="col-12 mt-4">
              <div class="mb-3">
                <label for="formFile" class="form-label">Selecione uma foto do cliente</label>
                <input class="form-control" type="file" id="formFile_alter">
              </div>
            </div>
          </div>

          <input type="hidden" value="" id="id_end">

          <div class="row mt-3 ">
            <h4 style="text-align: center;" class="msgErro text-danger"></h4>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="fechar_end">Fechar</button>
          <button type="button" class="btn btn-primary" id="alterar-end">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Excluir endereco -->
  <div class="modal fade" id="btn_excluir_end" tabindex="-1" aria-labelledby="btn_excluir_cli" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Endereco <strong><em><span id="nome_rua_endereco_excluir"></span></em></strong>
          </h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-danger text-center" style="font-size: 24px;">Deseja realmente excluir ?</p>
          <input type="hidden" id="id_endereco_excluir">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

  <script src="../js/apiCep.js"></script>
  <script>
    $(document).ready(function() {

      $('#cadastrar_end').on('click', function() {

        let rua = $('#rua_end').val();
        let numero = $('#numero_end').val();
        let bairro = $('#bairro_end').val();
        let complemento = $('#complemento_end').val();
        let cidade = $('#cidade_end').val();
        let uf = $('#uf_end').val();
        let tipo = $('#tipo_end').val();
        let cep = $('#vlr_cep_end').val();
        let cliente = $('#cliente_end').val();
        let fotoCliente = $('#formFile').prop('files')[0];


        if (!fotoCliente) {
          const msg = 'Selecione uma foto do cliente';
          $('.msgErro').text(msg);
          return;
        }

        if (rua == '') {
          const msg = 'Preenche nome da Rua'
          $('.msgErro').text(msg)
          return;
        }

        if (numero <= 0 || numero == '') {
          const msg = 'Numero negativo ou 0 ou vazio nao permitido / Preenche numero correto';
          $('.msgErro').text(msg)
          return;
        }

        if (bairro == '') {
          const msg = 'Preenche o bairro'
          $('.msgErro').text(msg)
          return;
        }

        if (complemento == '') {
          const msg = 'Preenche o complemento'
          $('.msgErro').text(msg)
          return;
        }

        if (cidade == '') {
          const msg = 'Preenche a cidade'
          $('.msgErro').text(msg)
          return;
        }
        if (uf == '') {
          const msg = 'Preenche o estado apenas com SIGLA'
          $('.msgErro').text(msg)
          return;
        }
        if (tipo == '') {
          const msg = 'Escolha  o tipo'
          $('.msgErro').text(msg)
          return;
        }
        if (cep == '') {
          const msg = 'Preenche o cep'
          $('.msgErro').text(msg)
          return;
        }

        // Crie um objeto FormData
        let formData = new FormData();
        formData.append('rua', rua);
        formData.append('numero', numero);
        formData.append('bairro', bairro);
        formData.append('complemento', complemento);
        formData.append('cidade', cidade);
        formData.append('uf', uf);
        formData.append('tipo', tipo);
        formData.append('cep', cep);
        formData.append('cliente', cliente);
        formData.append('fotoCliente', fotoCliente);

        $.ajax({
          url: './endereco/inserir.php',
          method: 'POST',
          data: formData,
          processData: false, // Não processar dados do FormData
          contentType: false, // Não definir tipo de conteúdo
          success: function(response) {
            console.log(response);
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

      $('.btn-alterar_end').on('click', function() {
        var id_end = $(this).data('id');
        var rua = $(this).data('rua');
        var numero = $(this).data('numero');
        var bairro = $(this).data('bairro');
        var tipo_endereco = $(this).data('tipo_endereco');
        var complemento = $(this).data('complemento');
        var cep = $(this).data('cep');
        var cidade = $(this).data('cidade');
        var uf = $(this).data('uf');
        var id_pessoa = $(this).data('id_pessoa');

        $('#id_end').val(id_end);
        $('#cep_end').val(cep);
        $('#rua_end_alter').val(rua)
        $('#numero_end_alter').val(numero)
        $('#bairro_end_alter').val(bairro)
        $('#complemento_end_alter').val(complemento)
        $('#cidade_end_alter').val(cidade)
        $('#uf_end_alter').val(uf)
        $('#tipo_end_alter').val(tipo_endereco)

      });

      $('#alterar-end').on('click', function() {

        let id_endereco = $('#id_end').val()
        let rua = $('#rua_end_alter').val()
        let numero = $('#numero_end_alter').val()
        let bairro = $('#bairro_end_alter').val()
        let complemento = $('#complemento_end_alter').val()
        let cidade = $('#cidade_end_alter').val()
        let uf = $('#uf_end_alter').val()
        let tipo = $('#tipo_end_alter').val()
        let cep = $('#cep_end').val();
        let cliente = $('#cliente_end_atler').val();
        let fotoCliente = $('#formFile_alter').prop('files')[0];

        if (!fotoCliente) {
          const msg = 'Selecione uma foto do cliente.';
          $('.msgErro').text(msg);
          return;
        }

        if (fotoCliente.type !== 'image/png' && fotoCliente.type !== 'image/jpeg' && fotoCliente.type !== 'image/gif') {
          const msg = 'Formato de imagem inválido.';
          $('.msgErro').text(msg);
          return;
        }

        if (rua == '') {
          const msg = 'Preenche nome da Rua'
          $('.msgErro').text(msg)
          return;
        }

        if (numero <= 0 || numero == '') {
          const msg = 'Numero negativo ou 0 ou vazio nao permitido / Preenche numero correto';
          $('.msgErro').text(msg)
          return;
        }

        if (bairro == '') {
          const msg = 'Preenche o bairro'
          $('.msgErro').text(msg)
          return;
        }

        if (complemento == '') {
          const msg = 'Preenche o complemento'
          $('.msgErro').text(msg)
          return;
        }

        if (cidade == '') {
          const msg = 'Preenche a cidade'
          $('.msgErro').text(msg)
          return;
        }
        if (uf == '') {
          const msg = 'Preenche o estado apenas com SIGLA'
          $('.msgErro').text(msg)
          return;
        }
        if (tipo == '') {
          const msg = 'Escolha  o tipo'
          $('.msgErro').text(msg)
          return;
        }
        if (cep == '') {
          const msg = 'Preenche o cep'
          $('.msgErro').text(msg)
          return;
        }



        // Crie um objeto FormData
        let formData = new FormData();
        formData.append('id_endereco', id_endereco);
        formData.append('rua', rua);
        formData.append('numero', numero);
        formData.append('bairro', bairro);
        formData.append('complemento', complemento);
        formData.append('cidade', cidade);
        formData.append('uf', uf);
        formData.append('tipo', tipo);
        formData.append('cep', cep);
        formData.append('cliente', cliente);
        formData.append('fotoCliente', fotoCliente);

        $.ajax({
          url: './endereco/alterar.php',
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
              setTimeout(() => {
                location.reload();
              }, 3200);
            } else {

              Swal.fire({
                icon: 'error',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $("#fechar_end").click();
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
            $("#fechar_end").click();
            // setTimeout(() => {
            //   location.reload();
            // }, 3200);
          }
        });
      })

      $('.btn-excluir_end').on('click', function() {
        var id_end = $(this).data('id');
        var rua = $(this).data('rua');
        var numero = $(this).data('numero');
        var bairro = $(this).data('bairro');

        console.log(id_end, rua, numero);

        var frase = `${rua}, nº ${numero}, ${bairro}`


        $('#id_endereco_excluir').val(id_end);
        $('#nome_rua_endereco_excluir').text(frase);
      })


      $('#btn_confirma_exclu').on('click', function() {
        var id = $('#id_endereco_excluir').val();



        $.ajax({
          url: './endereco/excluir.php',
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
