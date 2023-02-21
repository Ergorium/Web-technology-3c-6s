<?php
include_once('../../DB.php');
$body = $_POST;
try {
  
  if ($body['email'] && $body['name'] && $body['phone']) {
    if (DB::insert('profiles', $body)) {
      header('Location: /profiles?id=' . DB::lastId());
    } else {
      throw new Error('Ошибка записи даных в базу');
    }
  } else {
    throw new Error('Неккоректные данные');
  }
} catch (Error $e) {
  $GLOBALS['errors'] = $e->getMessage();
  include_once('../../error.php');
}