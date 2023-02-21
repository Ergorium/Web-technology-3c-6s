<?php
include_once('../../DB.php');
$book = DB::selectOne('books', 'id = ' . $_GET['id']);
?>

<h1 class="text-4xl mb-4">Создание новой книги</h1>
<form action="/books/edit?id=<?php echo $book['id'] ?>" method="POST" id="modal-form" class="modal-content min-w-[350px] bg-stone-700 rounded-md relative">
  <div class="modal--main p-4">
    <label for="name" class="block mb-4">
      <p>Название книги</p>
      <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="name" name="title" value="<?php echo $book['title'] ?>" required>
    </label>
    <label for="author" class="block mb-4">
      <p>Автор</p>
      <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="author" name="author" value="<?php echo $book['author'] ?>" required>
    </label>
    <label for="description">
      <p>Описание</p>
      <textarea name="description" id="description" cols="30" rows="5" class="w-full bg-stone-500">
      <?php echo htmlspecialchars($book['description']); ?>
      </textarea>
    </label>
    <label for="img_url">
      <p>Ссылка на обложку</p>
      <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" name="img_url" id="img_url" value="<?php echo $book['img_url'] ?>">
    </label>
    
  </div>
  <div class="modal--footer p-4 flex justify-end items-center">
    <button id="modal-ok" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" type="submit">Сохранить</button>
    <button id="modal-cancel" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" type="reset">Сбросить</button>
  </div>
</form>