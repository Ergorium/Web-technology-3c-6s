<?php 
$searcherConfig = $GLOBALS['searchConfig'];
?>

<div class="search">
  <style>
    #query-form>* {
      margin-right: 10px
    }
  </style>
  <form id="query-form" class="flex items-center mb-4" action="<?php echo $searcherConfig['address'] ?>">
    <input id="search" name="<?php echo $searcherConfig['defaultSelect'] ?>" type="text" placeholder="search" class="rounded-sm bg-stone-800 bg-opacity-70 focus:bg-opacity-100 outline-0 border-0 px-2 py-1">
    <select id="select" class="bg-stone-600 px-2 py-1 outline-none">
      <?php foreach($searcherConfig['types'] as $type) { ?>
        <option value="<?php echo $type ?>"
        <?php if ($searcherConfig['defaultSelect'] == $type) echo 'selected' ?>>
          <?php echo $type ?>
        </option>
      <?php } ?>
    </select>
    <?php
    if (array_key_exists('customFields', $searcherConfig)) {
      foreach ($searcherConfig['customFields'] as $elem) {
        echo '<div>' . $elem . '</div>';
      }
    }
      
    ?>
    <button id="search-button" type="sumbit"><i class="fa-solid fa-magnifying-glass p-2"></i></button>
  </form>
  <div class="buttons flex mb-4">
      <div class="mr-2">
        <form action="?">
          <button type="submit" class="px-2 py-1 bg-stone-600">Сбросить фильтры</button>
        </form>
      </div>
    </div>
</div>


<script prefer>
  const select = document.querySelector('#select')
  const input = document.querySelector('#search')
  select.addEventListener('change', (e) => {
    const value = e.target.value
    input.setAttribute('name', value)
  })
</script>