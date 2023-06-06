<?php
//Menus Painel

$usuarios = 'usuarios';
$home = 'home';
$endereco = 'endereco';
$cliente = 'cliente';
$funcionario = 'funcionario';
$log = 'log';
if (@$_GET['pag'] == "") {
  $pag = $home;
} else {
  $pag = @$_GET['pag'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="../css/painel.css">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-2">
        <div class="navigation">
          <div class="menuToggle"></div>
          <ul>
            <li class="list <?php if ($pag === $home) echo 'active'; ?>">
              <a href="#" id="home-link" class="menu-link" style="--clr: #f44336">
                <span class="icon">
                  <ion-icon name="home-outline"></ion-icon>
                </span>
                <span class="text">Home</span>
              </a>
            </li>

            <li class="list <?php if ($pag === $usuarios) echo 'active'; ?>">
              <a href="#" id="usuarios-link" class="menu-link" style="--clr: #ffa117">
                <span class="icon">
                  <ion-icon name="person-outline"></ion-icon>
                </span>
                <span class="text">Usuarios</span>
              </a>
            </li>


            <li class="list <?php if ($pag === $cliente) echo 'active'; ?>">
              <a href="#" id="cliente-link" class="menu-link" style="--clr: #b145e9">
                <span class="icon">
                  <ion-icon name="person-add-outline"></ion-icon>
                </span>
                <span class="text">Cliente</span>
              </a>
            </li>


            <li class="list <?php if ($pag === $endereco) echo 'active'; ?>">
              <a href="#" id="endereco-link" class="menu-link" style="--clr: #0fc70f">
                <span class="icon">
                  <ion-icon name="location-outline"></ion-icon>
                </span>
                <span class="text">Endereco</span>
              </a>
            </li>


            <li class="list <?php if ($pag === $funcionario) echo 'active'; ?>">
              <a href=" #" id="funcionario-link" class="menu-link" style="--clr: #2196f3">
                <span class="icon">
                  <ion-icon name="code-working-outline"></ion-icon>
                </span>
                <span class="text">Funcionario</span>
              </a>
            </li>

            <li class="list <?php if ($pag === $log) echo 'active'; ?>">
              <a href=" #" id="log-link" class="menu-link" style="--clr:  #b145e9">
                <span class="icon">
                  <ion-icon name="construct-outline"></ion-icon>
                </span>
                <span class="text">Logs</span>
              </a>
            </li>

            <div class="indicator"></div>
            <a href="./logout.php">Sair</a>
          </ul>
        </div>
      </div>
      <div class="col-10">
        <div class="pagina">
          <?php
          require_once($pag . '.php');
          ?>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/menu.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    $(document).ready(function() {
      function carregarPagina(pagina) {
        $.ajax({
          url: pagina + '.php',
          type: 'GET',
          dataType: 'html',
          success: function(data) {
            $('.pagina').html(data);
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      }

      $('.menu-link').click(function(e) {
        e.preventDefault();
        var linkId = $(this).attr('id');

        if (linkId === 'home-link') {
          carregarPagina('home');
          $('.list').removeClass('active');
          $('#home-link').parent().addClass('active');
        } else if (linkId === 'usuarios-link') {
          carregarPagina('usuarios');
          $('.list').removeClass('active');
          $('#usuarios-link').parent().addClass('active');
        } else if (linkId === 'endereco-link') {
          carregarPagina('endereco');
          $('.list').removeClass('active');
          $('#endereco-link').parent().addClass('active');
        } else if (linkId === 'cliente-link') {
          carregarPagina('cliente');
          $('.list').removeClass('active');
          $('#cliente-link').parent().addClass('active');
        } else if (linkId === 'funcionario-link') {
          carregarPagina('funcionario');
          $('.list').removeClass('active');
          $('#funcionario-link').parent().addClass('active');
        } else if (linkId === 'log-link') {
          carregarPagina('log');
          $('.list').removeClass('active');
          $('#funcionario-link').parent().addClass('active');
        }
      });
    });
  </script>
</body>

</html>
