<?php



require_once './conexao.php';



$type_user = $_SESSION['tipo'];
$email_user = $_SESSION['email'];

$user = array();


if ($type_user == 'funcionario') {
  $disable = 'disabled';
} else {
  $disable = '';
}



try {
  //code...
  $sql = "SELECT * FROM usuarios";
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute()) {
    $user = $stmt->fetchAll();
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
  <title>Usuarios</title>
  <link rel="stylesheet" href="../css/user.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php if ($type_user  == 'gerente') { ?>
          <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#cadastro_user">Cadastrar Usuario</button>
        <?php } ?>

      </div>
    </div>

    <?php if (!empty($user)) { ?>
      <div class="row mt-4">
        <table class="table table-striped table-bordered table-dark" style="font-size: 14px;">
          <thead>
            <tr>
              <th scope="col">Identificação</th>
              <th scope="col">Nome</th>
              <th scope="col">Email</th>
              <th scope="col">Cargo</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($user as $u) { ?>
              <tr>
                <th scope="row"><?php echo $u['id_user'] ?></th>
                <td class="nome"><?php echo $u['nome'] ?></td>
                <td><?php echo $u['email'] ?></td>
                <td><?php echo $u['tipo'] ?></td>
                <td>
                  <button type="button" class="btn btn-warning btn-alterar" data-bs-toggle="modal" data-bs-target="#alterar_cad" data-whatever="<?php echo $u['id_user'] ?>" data-nome="<?php echo $u['nome'] ?>" data-email="<?php echo $u['email'] ?>" data-tipo="<?php echo $u['tipo'] ?>">Alterar</button>
                  <?php if ($email_user != $u['email']) { ?>
                    <button type="button" class="btn btn-danger btn-excluir-user" data-bs-toggle="modal" data-bs-target="#btn_excluir_user" data-id="<?php echo $u['id_user'] ?>" data-name="<?php echo $u['nome'] ?>">Excluir</button>
                  <?php } ?>

                </td>
              </tr>

            <?php  } ?>

          </tbody>
        </table>
      </div>
    <?php } ?>
  </div>

  <!-- Modal Cadastro de usuario -->
  <div class="modal fade" id="cadastro_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastrar Usuários</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite seu nome" aria-label="username" id="cad_nome">
            </div>
            <div class="col-6 ">
              <div class="input-group">
                <input type="email" class="form-control" placeholder=" Digite seu E-mail" aria-label="email" id="cad_email">
                <span class="input-group-text">@</span>
              </div>
            </div>

            <div class="col-6 mt-4">
              <input type="password" class="form-control" placeholder="Digite sua senha" aria-label="password" id="cad_senha">
            </div>
            <div class="col-6 mt-4">
              <select class="form-select" aria-label="" id="cad_tipo">
                <option value="funcionario">Funcionario</option>
                <option value="gerente">Gerente</option>
              </select>
            </div>
          </div>
          <div class="row mt-3 ">
            <h4 style="text-align: center;" class="msgErro text-danger"></h4>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" id="cadastrar_user">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Alterar Usuario -->
  <div class="modal fade" id="alterar_cad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alterar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="user_id">

          <div class="row">
            <div class="col-6">
              <input type="text" class="form-control" placeholder="Digite seu nome" aria-label="username" id="alter_name">
            </div>
            <div class="col-6 ">
              <div class="input-group">
                <input type="email" class="form-control" placeholder="Digite seu E-mail" aria-label="email" id="alter_email">
                <span class="input-group-text">@</span>
              </div>
            </div>

            <div class="col-6 mt-4">
              <input type="password" class="form-control" placeholder="Digite sua senha" aria-label="password" id="alter_pass" <?php echo $disable ?>>
            </div>
            <div class="col-6 mt-4">
              <select class="form-select" aria-label="" id="user_type" <?php echo $disable ?>>
                <option value="funcionario">Funcionário</option>
                <option value="gerente">Gerente</option>
              </select>
            </div>
            <div class="row mt-3 ">
              <h4 style="text-align: center;" class="msgErro text-danger"></h4>
            </div>

            <div class="row mt-3 ">
              <h4 style="text-align: center;" class="text-danger">
                <?php if ($type_user == 'funcionario') { ?>
                  <?php echo "Voce nao tem permissao pra alterar senha.." ?>
                <?php } ?>
              </h4>
            </div>
            <input type="hidden" id="id_user_hidden" value="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="fechar_alter">Fechar</button>
          <button type="button" class="btn btn-primary" id="alterarUsuarioBtn">Alterar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Excluir Usuario -->
  <div class="modal fade" id="btn_excluir_user" tabindex="-1" aria-labelledby="btn_excluir_user" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Usuario <strong><em><span id="user_ex"></span></em></strong>
          </h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-danger text-center" style="font-size: 24px;">Deseja realmente excluir ?</p>
          <input type="hidden" id="id_ex_user">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="fechar_exclusao_user">Fechar</button>
          <button type="button" class="btn btn-danger" id="btn_confirmar_exclusao_user">Confirmar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-vViR6GFxyqz/8yh4Dtl8QF/54Nq4XHmhdpjE7PZhZ1GR2yoiXX3v4jYYh7gRbkTM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

  <script>
    // const getData = (id, nome, email, tipo) => {
    //   $('#alter_name').val(nome);
    //   $('#alter_email').val(email);
    //   $('#user_type').val(tipo);
    //   $('#id_user_hidden').val(id);
    // }

    $(document).ready(function() {




      $('.btn-alterar').on('click', function() {
        var idUser = $(this).data('whatever');
        var nomeUser = $(this).data('nome');
        var email = $(this).data('email');
        var tipo = $(this).data('tipo');

        $('#id_user_hidden').val(idUser);
        $('#alter_name').val(nomeUser);
        $('#alter_email').val(email);
        $('#user_type').val(tipo);
      });


      $('.btn-excluir-user').on('click', function() {
        var idUser = $(this).data('id');
        var nome = $(this).data('name');
        $('#id_ex_user').val(idUser);
        $('#user_ex').text(nome);

      });

      $('#btn_confirmar_exclusao_user').on('click', function() {
        var id = $('#id_ex_user').val();
        $.ajax({
          url: './usuarios/excluir.php',
          method: 'POST',
          dataType: 'json',
          data: {
            id: id
          },
          success: function(response) {
            // Executa ação em caso de sucesso
            $("#fechar_alter").click();
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: `${response.message}`,
                showConfirmButton: false,
                timer: 2100
              });

            } else {
              Swal.fire({
                icon: 'error',
                title: `${response.message}`,
                showConfirmButton: false,
                timer: 2100
              });
            }

            setTimeout(() => {
              location.reload();
            }, 2200);

          },
          error: function(xhr, status, error) {
            // Executa ação em caso de erro
            console.error('Erro ao enviar os dados:', error);
          }
        });

      });

      $("#alterarUsuarioBtn").on('click', function() {


        var idUser = $('#id_user_hidden').val();
        var nomeUser = $('#alter_name').val();
        var emailUser = $('#alter_email').val();
        var passUser = $('#alter_pass').val();
        var typeUser = $('#user_type').val();



        if (passUser == '') {
          const msg = 'Digite sua nova senha ou a atual.'
          $('.msgErro').text(msg)
          return;
        }

        console.log(idUser, nomeUser, emailUser, passUser, typeUser);

        $.ajax({
          url: './usuarios/alterar.php',
          method: 'POST',
          data: {
            id: idUser,
            nome: nomeUser,
            email: emailUser,
            senha: passUser,
            tipo: typeUser
          },
          success: function(response) {
            // Executa ação em caso de sucesso
            $("#fechar_alter").click();
            Swal.fire({
              icon: 'success',
              title: 'Alteração realizada com sucesso!',
              showConfirmButton: false,
              timer: 2000
            });
            setTimeout(() => {
              location.reload();
            }, 2100);
          },
          error: function(xhr, status, error) {
            // Executa ação em caso de erro
            console.error('Erro ao enviar os dados:', error);
          }
        });
      })

      $("#cadastrar_user").on('click', function() {


        var nomeUser = $('#cad_nome').val();
        var emailUser = $('#cad_email').val();
        var passUser = $('#cad_senha').val();
        var typeUser = $('#cad_tipo').val();



        if (nomeUser == '') {
          const msg = 'Digite seu nome'
          $('.msgErro').text(msg)
          return;
        }

        if (emailUser == '') {
          const msg = 'Digite seu email.'
          $('.msgErro').text(msg)
          return;
        }

        if (passUser == '') {
          const msg = 'Digite sua nova senha ou a atual.'
          $('.msgErro').text(msg)
          return;
        }

        console.log(nomeUser, emailUser, passUser, typeUser);


        $.ajax({
          url: './usuarios/cadastraUser.php',
          method: 'POST',
          data: {
            nome: nomeUser,
            email: emailUser,
            senha: passUser,
            tipo: typeUser
          },
          success: function(response) {
            // Executa ação em caso de sucesso
            $("#fechar_alter").click();
            Swal.fire({
              icon: 'success',
              title: `${response}`,
              showConfirmButton: false,
              timer: 2100
            });
            setTimeout(() => {
              location.reload();
            }, 2100);
          },
          error: function(xhr, status, error) {
            // Executa ação em caso de erro
            console.error('Erro ao enviar os dados:', error);
          }
        });
      })
    });
  </script>
</body>

</html>
