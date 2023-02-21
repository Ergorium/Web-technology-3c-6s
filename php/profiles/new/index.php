<?php
include_once('../../components/header.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include_once('form.php');
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include_once('new.php');
}
?>

<?php 
include_once('../../components/footer.php');
?>