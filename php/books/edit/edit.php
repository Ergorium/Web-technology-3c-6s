<?php
include_once('../../DB.php');

if (DB::update('books', $_POST, 'id = ' . $_GET['id'])) {
  header('Location: /books?id=' . $_GET['id']);
} else {
  header('Location: /books/edit?id=' . $_GET['id']); 
}