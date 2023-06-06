<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../css/login.css" />
  <title>SecureAlert</title>
</head>

<body>
  <main class="main">
    <div class="container">
      <div class="wallpaper"></div>
      <div class="detals">
        <header>
          <h1>SecureAlert 👨🏼‍💻📷</h1>
          <p>
            Bem vindo a tela de cadastro, fique a vontade pra se cadastra
          </p>
        </header>
        <form action="./processa_user.php" method="post">
          <div class="inputs">
            <label for="">Nome</label>
            <input type="text" name="cad_nome" id="cad_nome" placeholder="Digite seu nome" />
          </div>
          <div class="inputs">
            <label for="">E-mail</label>
            <input type="email" name="cad_email" id="cad_email" placeholder="Digite seu email" />
          </div>
          <div class="inputs">
            <label for="">Senha</label>
            <input type="password" name="cad_pass" id="cad_pass" placeholder="Digite sua senha" />
          </div>
          <input type="submit" value="Cadastrar" />
        </form>
      </div>
    </div>
  </main>

  <script>

  </script>
</body>

</html>
