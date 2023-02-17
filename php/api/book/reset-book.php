<?php
$GLOBALS['config'] = parse_ini_file('../config.ini');
include_once('../DB.php');

$res = DB::update('books', [
  'reserve' -> false
], 'id = ' . $_GET['id']);

DB::update('reserves', [
  'canceled' -> true
], 'bookId = ' . $_GET['id']);

header('Content-Type: application/json; charset=utf-8');
if ($res == 1) {
  http_response_code(204);
} elseif ($res == 0) {
  http_response_code(404);
}