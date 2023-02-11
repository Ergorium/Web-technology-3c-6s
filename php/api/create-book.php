<?php
$GLOBALS['config'] = parse_ini_file('../config.ini');
include_once('../DB.php');

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$res = DB::insert('books', $data);
if ($res == 1) {
  $response = [
    'id' => DB::lastId()
  ];
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($response);
}