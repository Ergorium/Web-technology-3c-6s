<?php
include_once('../../components/header.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include_once('edit.php');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include_once('form.php');
}
include_once('../../components/footer.php');