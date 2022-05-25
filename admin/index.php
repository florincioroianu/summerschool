<?php
session_start();
include "../inc/config.php";
include "../inc/connect.php";
include "./inc/admin-functions.php";


$login = isset($_REQUEST["login"]) ? $_REQUEST["login"] : NULL;
if (isset($login)) {
  switch ($login) {
    case 'login':
      $nume = $_REQUEST["nume"];
      $parola =  $_REQUEST["parola"];
      if (!doLogin($nume, $parola)) {
        echo "<div class='error'>Autentificare esuata!</div>";
      }
      break;
    case 'logout':
      doLogout();
      break;
  }
}


if (!isLogged()) {
  include "login-form.php";
} else {
  include "inc/header.php";
  echo "<h2 class='title'>Panou gestionare summer school</h2>";
  include "inc/footer.php";
}
?>