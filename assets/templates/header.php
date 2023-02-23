<?php
require __DIR__ . "/../process/globals.php";
require __DIR__ . "/../process/db.php";
require_once __DIR__ . "/../dao/UserDAO.php";
require_once __DIR__ . "/../models/Message.php";
require_once __DIR__ . "/../dao/FormularioDAO.php";
$message = new Message($BASE_URL);

$flashMessage = $message->getMessage();

if (!empty($flashMessage["msg"])) {
  // Limpar a mensagem
  $message->clearMessage();
}

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(false);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PRINTRAAS - Sistema de Impressão prontuário</title>
  <!--CSS and Images-->
  <link rel="icon" type="image/png" href="assets/image/icon.png" />
  <link rel="stylesheet" href="assets/css/styles.css" />
  <link rel="stylesheet" href="assets/css/boot.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script type="text/javascript" src="assets/js/jquery.js"></script>
</head>

<body>
<div id="fade-container">
    <img class="load" src="assets/image/engrenagem.gif">
</div>
  <!--HEADER-->
  <header class="gradient gradient-green">
    <nav id="main-navbar" class="navbar navbar-expand-lg">
      <a class="transition navbar-brand" title="Home" href="./"><img src="assets/image/logowhite.png" width="260" height="50"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav">
          <?php if ($userData->adm == "S") : ?>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>?file=gerenciarcontas" class="nav-link">Gerenciar contas</a>
            </li>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>?file=newprofile" class="nav-link">Criar conta</a>
            </li>
          <?php endif; ?>
          <?php if ($userData) : ?>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>?file=cadastro" class="nav-link">Cadastrar</a>
            </li>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>?file=profissionais" class="nav-link">Profissionais Referencia</a>
            </li>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>?file=listapacientes&page=1" class="nav-link">Lista de pacientes</a>
            </li>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>?file=editprofile" class="nav-link"><?= $userData->name; ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>assets/process/logout.php" class="nav-link">Sair</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a href="<?php $BASE_URL ?>?file=login" class="nav-link">Entrar</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>
  <?php if (!empty($flashMessage["msg"])) : ?>
    <div class="msg-container">
      <p class="msg <?= $flashMessage["type"] ?>"><?= $flashMessage["msg"] ?></p>
    </div>
  <?php endif; ?>
  <script>
    if (document.querySelector('.msg-container')) {
      setTimeout(() => {
        document.querySelector('.msg-container').style.display = 'none'
      }, 6000)
    }

window.addEventListener("load", function() {
    var fadeContainer = document.querySelector("#fade-container");

  setTimeout(function() {

        fadeContainer.style.display = "none";

  }, 1000);
});
  </script>
