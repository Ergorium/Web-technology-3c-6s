<?php
include_once('../../DB.php');

DB::sql('start transaction');
try {
  $res = DB::insert('books', $_POST);
  var_dump(DB::lastId());
  if ($res == 1) {
    header('Location: /books?id=' . DB::lastId());
  }
  DB::sql('commit');
} catch(err) {
  DB::sql('rollback');
  echo err;
}