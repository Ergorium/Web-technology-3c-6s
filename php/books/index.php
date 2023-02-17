<?php

include_once('../DB.php');
$book = DB::sql('select *, b.id, r.profileId from books as b left join reserves as r on r.bookId = b.id where b.id = ' . $_GET['id'])->fetch();
if (!$book) {
  header('Location: /');
}
include_once('../components/header.php'); 
?>

<div class="mb-8">
<div class="card flex">
  <div class="card--icon">
    <?php if ($book['img_url']) { ?>
      <img src="<?php echo $book['img_url'] ?>" class="max-w-[80px] mr-2" alt="Logo">
    <?php } else { ?>
      <img src="/assets/2379396.svg" class="max-w-[80px] mr-2" alt="Logo">
    <?php } ?>
  </div>
  <div class="card--main">
    <h3 class="card--header text-3xl text-amber-200 book-modal cursor-pointer" book-id="${
      item.id
    }"><?php echo $book['title']?></h3>
    <h5 class="card--header text-2xl text-amber-200"><?php echo $book['author'] ?></h5>
    <p class="card--description"><? echo $book['description'] ?></p>
    <?php if ($book['reserved']) {?>
    <p><a href="/profiles?id=<?php echo $book['profileId'] ?>  " class="text-3xl underline">В резерве!!!</a></p>
    <?php } ?>
  </div>
</div>
</div>
<?php include_once('../components/footer.php')?>