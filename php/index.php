<?php
$GLOBALS['config'] = parse_ini_file('config.ini');
?>
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
  <?php include_once('components/header.php')?>
  <main class="w-full min-h-full grow pt-24 p-4 bg-stone-500">
    <div><?php include_once('components/list.php')?></div>
  </main>
  <footer class="shrink-0 p-4 bg-stone-700">
    <div class="container text-center">
      &copy;&nbsp;Progressiv
    </div>
  </footer>
  <script src="js/index.js"></script>
</body>
</html>