<?php
include_once('../components/header.php');
if (empty($_SESSION['auth'])) {
  header('Location: /authorization');
}
if (array_key_exists('id', $_GET)) {
  include_once('showProfile.php');
} else {
  include_once('showProfileList.php');
}
include_once('../components/footer.php');
?>