<?php
$GLOBALS['config'] = parse_ini_file('../config.ini');
include_once('../DB.php');

$res = DB::delete('books', "id = " . $_GET['id']);
if ($res == 1) {
  http_response_code(204);
} elseif ($res == 0) {
  http_response_code(404);
}