<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/login.css" />
  <title>SecureAlert</title>
</head>

<body>
  <div class="container">
    <?php if (!empty($_GET['msgErro'])) { ?>
      <div class="alert alert-warning" role="alert">
        <?php echo $_GET['msgErro'] ?>
      </div>
    <?php } ?>

    <?php if (!empty($_GET['msgSucesso'])) { ?>
      <div class="alert alert-success" role="alert">
        <?php echo $_GET['msgSucesso'] ?>
      </div>
    <?php } ?>
  </div>
  <main class="main">
    <div class="container">
      <div class="wallpaper"></div>
      <div class="detals">
        <header>
          <h1>SecureAlert 👨🏼‍💻📷</h1>
          <p>
            Bem-vindo à SecureAlert: especialistas em monitoramento e seguros.
            Garantimos segurança e tranquilidade com soluções personalizadas e
            tecnologia avançada. Sua proteção é nossa prioridade.
          </p>
        </header>
        <form action="./painel/usuarios/autenticar.php" method="post">
          <div class="inputs">
            <label for="">E-mail</label>
            <input type="email" name="user_email" id="user_email" placeholder="Digite seu email" />
          </div>
          <div class="inputs">
            <label for="">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha" />
          </div>

          <div class="create_account">
            <span>Não tem uma conta ?</span><a href="painel/usuarios/cad_usuario.php">Criar uma conta</a>
          </div>

          <input type="submit" value="Entrar" />
        </form>
      </div>
    </div>
  </main>

  <script>
    setTimeout(() => {
      let divEl = document.querySelector('.container');
      divEl.innerHTML = '';
    }, 3000);
  </script>
</body>

</html>
