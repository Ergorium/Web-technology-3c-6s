<?php
include_once('DB.php');
$books = DB::select('books');
foreach ($books as $book) {
?>
<div class="card flex mb-4">
  <div class="card--icon">
    <img src="<?php echo $book['img_url']?>" class="max-w-[80px] mr-2" alt="Logo">
  </div>
  <div class="card--main">
    <a href="<?php echo '/books?id=' . $book['id']?>" class="card--header text-3xl text-amber-200 book-modal cursor-pointer" book-id="<?php echo $book['id']?>"><?php echo $book['title']?></a>
    <h5 class="card--header text-2xl text-amber-200"><?php echo $book['author']?></h5>
    <p class="card--description"><?php echo $book['description']?></p>
  </div>
</div>
<?php
}
$pdo = null;?>