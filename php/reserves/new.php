<?php
include_once('../DB.php');
try {
  DB::sql('start transaction');
  $test = DB::select('reserves', 'bookId = '.$_POST['bookId'] . ' and profileId = ' . $_POST['profileId'] . ' and canceled = false');
  if (count($test) > 0) { 
    throw new Exception('Книга уже зарезервирована', 1);
  }
  $resInsert = DB::insert('reserves', array_merge($_POST, [
    'created_at' => date('Y-m-d')
  ]));
  $resUpdate = DB::update('books', [
    'reserved' => 1,
  ], 'id = ' . $_POST['bookId']);
  DB::sql('commit');
  if ($resInsert != 1 && $resUpdate != 1) {
    throw new Exception("Ошибка записи в базу", 1);
  }
  header('Location: /books?id=' . $_POST['bookId']);
} catch(PDOException $e) {
  DB::sql('rollback');
  $GLOBALS['errors'] = 'Ошибка записи в базу';
  include_once('../error.php');
} catch (Exception $e) {
  DB::sql('rollback');
  $GLOBALS['errors'] = $e->getMessage();
  include_once('../error.php'); 
}