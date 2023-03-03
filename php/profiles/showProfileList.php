<?php
include_once('../DB.php');
include_once('../helpers/queryConverter.php');

$GLOBALS['searchConfig'] = [
  'address' => '/profiles',
  'defaultSelect' => 'email',
  'types' => ['email', 'phone', 'name'],
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
    '
    <label for="has_reserve" class="search-checkbox cursor-pointer bg-stone-600 px-2 py-1">
        <span>Есть книги в резерве</span>
        <input type="checkbox" id="has_reserve" name="has_reserve" class="search-checkbox hidden">
        <i class="fa-solid fa-check-double"></i>
    </label>
    ',
  ],
];

$where = queryConverter($_GET);
$where = strlen($where) > 0 ? ' where ' . $where : '';

$profiles = DB::getRows('select *, (select count(*) from reserves as r where r.profileId = p.id and canceled = false ) as reserve from profiles as p' . $where);
?>
  <div class="mb-6 border-b border-stone-800 pb-6">
  <div class="mb-4">
    <a href="/profiles/new" class="p-2 bg-stone-600 hover:bg-opacity-70 active:scale-95 rounded-md mr-2 mb-4">Новый читательский билет</a>
  </div>
  <div>
    <?php include_once('../components/titleSearch.php') ?>
  </div>
</div>

<div class="flex flex-wrap justify-between">
<?php
foreach ($profiles as $profile) {
?>
<div class="mb-4">
  <div class="card max-w-[370px] flex mb-4 mr-4">
    <div class="card--main border-2 py-2 px-4 flex-wrap">
      <a href="/profiles?id=<?php echo $profile['id'] ?>">
        <h3 class="card--header text-3xl text-amber-200 book-modal cursor-pointer" book-id="${
        item.id
      }">Номер читательского билета: <?php echo $profile['id'] ?></h3>
      </a>
      <hr>
      <h5 class="card--header text-2xl text-amber-200"><?php echo $profile['name'] ?></h5>
      <a href="mailto:<?php echo $profile['email'] ?>" class="block card--header text-2xl text-amber-200"><?php echo $profile['email'] ?></a>
      <a href="tel:<?php echo $profile['phone'] ?>" class="block card--description"><?php echo $profile['phone'] ?></a>
      <p>Книг в резерве <?php echo $profile['reserve'] ?></p>
    </div>
  </div>
</div>
<?php } ?>
</div>