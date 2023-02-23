<?php
require __DIR__."/globals.php";
require __DIR__."/db.php";
require_once __DIR__."/../dao/UserDAO.php";

$userDao = new UserDAO($conn, $BASE_URL);
if ($userDao) {
  $userDao->destroyToken();
}
