<?php
session_start();

if (empty($_SESSION)) {
  header('location: ../index.php?msgErro=Você precisa se autenticar no sistema');
} else {
  session_destroy();
  header("location: ../index.php?msgSucesso=Lougout realizado com sucesso.");
  exit(); // Adicione esta linha para evitar que o código continue sendo executado após o redirecionamento
}

die();
