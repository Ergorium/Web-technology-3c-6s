<?php
include_once('../components/header.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include_once('new.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include_once('form.php');
}
include_once('../components/footer.php');
?>