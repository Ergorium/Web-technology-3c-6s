<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/b66fce7160.js" crossorigin="anonymous"></script>
  <style type="text/css">
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
  </style>
</head>
<body class="min-h-[100vh] w-full flex flex-col text-amber-100">
<header class="absolute p-4 bg-stone-700 l-0 t-0 r-0 w-full">
    <div class="container flex justify-between items-center">
      <a href="/" class="logo text-4xl flex">
        <img src="/assets/2379396.svg" class="max-w-[40px] mr-2" alt="Logo">
        Библиотека
      </a>
      <div class="search">
        <form id="query-form">
          <input id="search" type="text" placeholder="search" class="rounded-sm bg-stone-800 bg-opacity-70 focus:bg-opacity-100 outline-0 border-0 px-2 py-1">
          <button id="search-button" type="sumbit"><i class="fa-solid fa-magnifying-glass p-2"></i></button>
        </form>
      </div>
      <nav>
        <a href="/">book list</a>
        <a href="/profiles">profile list</a>
      </nav>
    </div>
  </header>
<main class="w-full min-h-full grow pt-24 p-4 bg-stone-500">
