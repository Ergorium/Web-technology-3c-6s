<?php
include_once('../DB.php');

if (!empty($_POST['email']) || !empty($_POST['password'])) {
  $res = DB::select('admins', "password = '" . $_POST['password'] . "' and email = '" . $_POST['email'] . "'");
  if (count($res) == 0 || count($res) > 1) {
    $GLOBALS['errors'] = 'Неккоректные даныне';
    include_once('../error.php');
  } else {
    $_SESSION['auth'] = true;
    header('Location: /');
  }
}
