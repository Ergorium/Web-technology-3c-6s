<?php

include_once('../DB.php');
$book = DB::sql('select *, b.id, r.profileId, (select name from profiles where id = r.profileId) as name from books as b left join reserves as r on r.bookId = b.id where b.id = ' . $_GET['id'])->fetch();
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
      <p class="card--description"><?php echo $book['description'] ?></p>
      <?php if (!empty($_SESSION['auth'])) { ?>
        <?php if ($book['reserved']) {?>
          <p class="mb-4">
            <a href="/profiles?id=<?php echo $book['profileId'] ?>" class="text-3xl underline">
              В резерве у <?php echo $book['name'] ?>!
            </a>
          </p>
        <?php } ?>
      <?php } else { if ($book['reserved']) { ?>
        <p class="mb-4">
          <span class="text-3xl underline">В резерве у <?php echo $book['name'] ?></span>
        </p>
      <?php }} ?>
      <?php if (!empty($_SESSION['auth'])) { ?>
      <div class="mt-4">
        <?php if ($book['reserved']) { ?>
          <button id="modal-reset" class="p-2 bg-stone-600 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" book-id="<?php echo $book['id'] ?>">Снять резерв</button>
        <?php } else { ?>
        <a href="/reserves?bookId=<?php echo $book['id'] ?>" class="py-3 px-2 bg-stone-600 hover:bg-opacity-70 active:scale-95 rounded-md mr-2">Зарезервировать</a>
        <?php } ?>
        <a href="/books/edit?id=<?php echo $book['id'] ?>" class="py-3 px-2 bg-stone-600 hover:bg-opacity-70 active:scale-95 rounded-md mr-2">Редактировать</a>
        <button id="modal-delete" class="p-2 bg-stone-600 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" book-id="<?php echo $book['id'] ?>">Удалить</button>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<script src="/js/requestResetReserve.js"></script>
<script src="/js/requestDeleteBook.js"></script>
<?php include_once('../components/footer.php')?>