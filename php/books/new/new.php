<?php
include_once('../../DB.php');

DB::sql('start transaction');
try {
  $res = DB::insert('books', array_merge($_POST, [
    'created_at' => date('Y-m-d')
  ]));
  var_dump(DB::lastId());
  if ($res == 1) {
    header('Location: /books?id=' . DB::lastId());
  }
  DB::sql('commit');
} catch(err) {
  DB::sql('rollback');
  echo err;
}