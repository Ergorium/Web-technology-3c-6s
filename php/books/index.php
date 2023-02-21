<?php
include_once('../components/header.php');

$GLOBALS['searchConfig'] = [
  'address' => '/profiles',
  'defaultSelect' => 'email',
  'types' => ['email', 'phone', 'name'],
];


if (array_key_exists('id', $_GET)) {
  include_once('showBook.php');
} else {
  include_once('bookList.php');
}
?>


<?php include_once('../components/footer.php');