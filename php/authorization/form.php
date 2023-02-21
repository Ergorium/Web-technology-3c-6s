<form action="/authorization" method="POST" class="modal-content min-w-[350px] bg-stone-700 rounded-md relative">
  <div class="modal--header p-4 select-none">Войти</div>
  <div class="modal--main p-4">
    <label for="email" class="block mb-4">
      <p>Email</p>
      <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="email" name="email" required>
    </label>
    <label for="password" class="block mb-4">
      <p>Password</p>
      <input type="password" name="password" id="password" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0">
    </label>
  </div>
  <div class="modal--footer p-4 flex justify-end items-center">
    <button id="modal-ok" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" type="submit">Войти</button>
  </div>
</form>