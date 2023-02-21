<form action="/reserves" method="POST" class="modal-content min-w-[350px] bg-stone-700 rounded-md relative">
  <div class="modal--header p-4 select-none">Резерв книги</div>
  <div class="modal--main p-4">
    <label for="profileId" class="block mb-4">
      <p>Номер карточки</p>
      <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="profileId" name="profileId" required>
    </label>
    <label for="bookId" class="block mb-4">
      <p>bookId</p>
      <input type="text" name="bookId" id="bookId" value="<?php echo $_GET['bookId'] ?>" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0">
    </label>
    <label for="timeout" class="block">
      <p>Время резерва</p>
      <input type="date" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="timeout" name="timeout" required>
    </label>
  </div>
  <div class="modal--footer p-4 flex justify-end items-center">
    <button id="modal-ok" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" type="submit">Ok</button>
    <button class="modal-cancel p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md" type="reset"> Сбросить</button>
  </div>
</form>