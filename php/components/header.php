<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/b66fce7160.js" crossorigin="anonymous"></script>
  <style type="text/css">
    .main-container {
      max-width: 1200px;
      margin: 0 auto;
    }
  </style>
</head>
<body class="min-h-[100vh] w-full flex flex-col text-amber-100">
<header class="absolute p-4 bg-stone-700 l-0 t-0 r-0 w-full">
    <div class="main-container flex justify-between items-center">
      <a href="/" class="logo text-4xl flex">
        <img src="/assets/2379396.svg" class="max-w-[40px] mr-2" alt="Logo">
        Библиотека
      </a>
      <nav>
        <a href="/books" class="mr-2">Книги</a>
        <?php if(!empty($_SESSION['auth'])) { ?>
          <a href="/profiles" class="mr-2">Читательские билеты</a>
          <form action="/authorization/loguot.php" class="inline"><button href="#" class="mr-2">Выйти</и></form>
        <?php } else { ?>
          <a href="/authorization" class="mr-2">Войти</a>
        <?php } ?>
      </nav>
    </div>
  </header>
<main class="w-full min-h-full grow pt-24 p-4 bg-stone-500">
  <div class="main-container">
