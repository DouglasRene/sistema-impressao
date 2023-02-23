<?php

  $db_name = parse_ini_file('.env')['mysql_db'];
  $db_host = parse_ini_file('.env')['mysql_host'];
  $db_user = parse_ini_file('.env')['mysql_login'];
  $db_pass = parse_ini_file('.env')['mysql_pass'];

  $conn = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);

  //Habilitar erros PDO
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  