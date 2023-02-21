<?php
include_once('../DB.php');
include_once('../helpers/queryConverter.php');
$where = queryConverter($_GET);
$where = strlen($where) > 0 ? ' where ' . $where : '';
$books = DB::getRows('select *, b.id, r.profileId, (datediff(r.timeout, r.created_at) < 0) as overdue, (select name from profiles where id = r.profileId) as name from books as b left join reserves as r on r.bookId = b.id and r.canceled = false ' . $where);

$GLOBALS['searchConfig'] = [
  'address' => '/books',
  'defaultSelect' => 'title',
  'types' => ['title', 'author'],
  'customFields' => [
    '
    <style>
      .search-checkbox:checked+* {
        display: inline
      }
      .search-checkbox+* {
        display: none
      }
    </style>',
    '<label for="overdue" class="search-checkbox cursor-pointer bg-stone-600 px-2 py-1">
        <span>Просрочено</span>
        <input type="checkbox" id="overdue" name="overdue" class="search-checkbox hidden">
        <i class="fa-solid fa-check-double"></i>
    </label>
    ',
    ' <label for="reserved" class="search-checkbox cursor-pointer bg-stone-600 px-2 py-1">
      <span>В резерве</span>
      <input type="checkbox" id="reserved" name="reserved" class="search-checkbox hidden">
      <i class="fa-solid fa-check-double"></i>
    </label>',
  ],
]
?>
<div class="mb-6 border-b border-stone-800 pb-6">
  <?php if (!empty($_SESSION['auth'])) { ?>
  <div class="mb-4">
    <a href="/books/new" class="p-2 bg-stone-600 hover:bg-opacity-70 active:scale-95 rounded-md mr-2 mb-4">Новая книга</a>
  </div>
  <?php } ?>
  <div>
    <?php include_once('../components/titleSearch.php') ?>
  </div>
</div>
<?php
foreach ($books as $book) {
?>
<div class="card flex mb-6">
  <div class="card--icon">
    <img src="<?php echo $book['img_url']?>" class="max-w-[80px] mr-2" alt="Logo">
  </div>
  <div class="card--main">
    <a href="<?php echo '/books?id=' . $book['id']?>" class="card--header text-3xl text-amber-200 book-modal cursor-pointer" book-id="<?php echo $book['id']?>"><?php echo $book['title']?></a>
    <h5 class="card--header text-2xl text-amber-200"><?php echo $book['author']?></h5>
    <p class="card--description"><?php echo $book['description']?></p>
    <?php if ($book['reserved']) { ?> 
    <p class="text-3xl">
      Книга зарезервирована <?php echo $book['name'] ?>.<span class="text-red-400">
      <?php 
        if ($book['overdue']) {
          echo ' Просрочено!';
        }
      ?>
      </span>
    </p>
    <?php } ?>
  </div>
</div>
<?php
}
$pdo = null;?>