<?php 
include_once('../DB.php');
header('content-type: application/json; charset=utf-8');

if (array_key_exists('id', $_GET)) {
  try {
    DB::sql('Start transaction');
    DB::update('books', [
      'reserved' => 0
    ], 'id = ' . $_GET['id']);
    
    DB::update('reserves', [
      'canceled' => 1,
    ], 'bookId = ' . $_GET['id']);
    DB::sql('commit');
    http_response_code(204);
  } catch (PDOException $e) {
    DB::sql('rollback');
    http_response_code(500);
    echo json_encode([
      'error' => 'Ошибка записи в базу данных',
      'errors' => json_encode($e),
    ]);
  }
} else {
  http_response_code(400);
  echo json_decod([
    'error' => 'Bad request'
  ]);
}