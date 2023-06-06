<?php
// Configurações do banco de dados
session_start();

if (!empty($_SESSION)) {
  $nome = $_SESSION['email'];
} else {
  $nome = "postgres"; // Ou qualquer valor padrão que você desejar
}


$newUsername = str_replace(['@', '.'], ['_', '_'], $nome);
$host = "localhost";
$dbname = "sistema";
$user = "postgres";
$password = "root"; // Senha vazia

try {
  $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Resto do seu código...
