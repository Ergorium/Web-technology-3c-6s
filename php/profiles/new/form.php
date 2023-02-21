<div class="flex flex-col items-center justify-center">
  <h1 class="text-4xl mb-4">Регистраци нового читателя</h1>
  <form actions="/profiles/new" method="POST" id="modal-form" class="modal-content min-w-[350px] max-w-[800px] w-full bg-stone-700 rounded-md relative">
  <div class="modal--main p-4">
    <label for="name" class="block mb-4">
      <p>ФИО</p>
      <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="name" name="name" required>
    </label>
    <label for="email" class="block mb-4">
      <p>Email</p>
      <input type="email" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="email" name="email" required>
    </label>
    <label for="phone">
      <p>Телефон</p>
      <input type="phone" name="phone" id="phone" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0"></input>
    </label>
    
  </div>
  <div class="modal--footer p-4 flex justify-end items-center">
    <button id="modal-ok" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" type="submit">Сохранить</button>
    <button id="modal-cancel" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" type="reset">Сбросить</button>
  </div>
</form>
</div>