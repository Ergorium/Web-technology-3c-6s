<?php
include_once('../DB.php');
$profiles = DB::select('profiles', 'id = ' . $_GET['id']);
if (count($profiles) === 0 || count($profiles) > 1) {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
$profile = $profiles[0];
$sql = 'select *, b.title as title, r.created_at, datediff(r.timeout, r.created_at) as overdue from reserves as r left join books as b on r.bookId = b.id where r.profileId = ' . $profile['id'] . ' order by r.canceled';
$reserves = DB::getRows($sql);

include_once('../components/header.php');
?>
<div class="mb-4">
  <div class="card flex mb-4">
    <div class="card--main w-full">
      <div class="pb-4 mb-4 border-b-2 border-stone-800">
        <div class="max-w-[500px]">
          <h3 class="card--header text-3xl text-amber-200 book-modal cursor-pointer mb-2" book-id="${
              item.id
            }">Номер читательского билета: <?php echo $profile['id'] ?></h3>
          <hr class="mb-2">
          <h3 class="card--header text-3xl text-amber-200 book-modal cursor-pointer mb-2" book-id="${
            item.id
          }"><?php echo $profile['name'] ?></h3>
          <a href="mailto:{{profile.email}}" class="block card--header text-2xl text-amber-200 mb-2 hover:underline"><?php echo $profile['email'] ?></a>
          <a href="tel:{{profile.phone}}" class="block card--description mb-2 hover:underline"><?php echo $profile['phone'] ?></a>
        </div>
      </div>
      <?php if (count($reserves) > 0) { ?>
      <div>
        <h4 class="mb-4 text-3xl">Книги в резерве</h4>
        <div>
          <?php foreach ($reserves as $reserve) { ?>
            <div class="pb-2 mb-4 border-b-2 border-stone-800 w-full">
              <p class="mb-2"><span class="text-2xl select-none">Название книги:</span> <a href="/books?id=<?php echo $reserve['bookId'] ?>" class="text-xl underline"><?php echo $reserve['title'] ?></a></p>
              <p class="mb-2"><span class="text-xl select-none">Дата резерва:</span> <span><?php echo $reserve['created_at'] ?></span></p>
              <p class="mb-2"><span class="text-xl select-none">Дата окончания резерва:</span> <span><?php echo $reserve['timeout'] ?></span></p>
              <?php if ($reserve['overdue'] && !$reserve['canceled']) { ?>
                <p class="text-xl text-orange-600 bg-stone-800 p-2 text-center select-none mb-2">Книга просрочена!!!</p>
              <?php } ?>
              <?php if (!$reserve['canceled']) { ?>
                <div>
                  <button id="modal-reset" class="p-2 bg-stone-600 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" book-id="<?php echo $reserve['bookId'] ?>">Возврат книги</button>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div>      
      <?php } else echo 'Нет истории резервов'?>
    </div>
  </div>
</div>
<script src="/js/requestResetReserve.js"></script>