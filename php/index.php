<?php
include_once('DB.php');
$GLOBALS['config'] = parse_ini_file('config.ini');
include_once('components/header.php')
?>
<div>
  <div class="flex justify-between bg-stone-600 p-4 pb-6 mb-6 items-center">
    <div class="px-4">
      <h1 class="text-3xl mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, doloremque.</h1>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum necessitatibus adipisci odit illum nobis placeat magni quibusdam unde esse aliquid.</p>
    </div>
    <div>
      <img src="/assets/main.png" alt="Mainimg" class="max-w-[450px]">
    </div>
  </div>
  <div class="mb-6">
    <p class="text-4xl mb-6 text-center">Новые книги</p>
    <div class="flex justify-center flex-wrap">
    <?php
      $res = DB::select('books', 'reserved = false and datediff(created_at, Date(Now())) < 10', 4);
      foreach ($res as $book) {
    ?>
    <a href="/books?id=<?php echo $book['id'] ?>" class="flex mb-4 mr-4">
      <img src="<?php echo $book['img_url'] ?>" alt="book img" class="max-w-[100px] mr-4">
      <div>
        <p class="text-3xl"><?php echo $book['title'] ?></p>
        <p><?php echo $book['author'] ?></p>
      </div>
    </a>
    <?php
      }
    ?>
    </div>
  </div>
  <div class="flex justify-center bg-stone-600 p-4 pb-6">
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis facilis consequatur necessitatibus beatae pariatur dolorum cum, nisi veniam molestiae quis, quae libero quidem illo accusamus repellat ipsam consequuntur at dolorem dignissimos. Debitis, quaerat molestias dolorem doloremque non numquam eos nihil. Dignissimos ipsa dolores sunt sed quisquam pariatur dolorum natus, porro ullam alias veritatis necessitatibus corrupti, velit quam beatae blanditiis, repellendus voluptas! Quidem facilis maxime tempora unde quae id quo autem error, reiciendis inventore sit iure ullam nulla et velit nihil assumenda quisquam aperiam quas neque cumque sapiente exercitationem cum accusamus. Ullam rerum expedita ducimus temporibus enim nostrum possimus et reprehenderit!</p>
  </div>
<script src="js/index.js"></script>
<?php include_once('components/footer.php')?>