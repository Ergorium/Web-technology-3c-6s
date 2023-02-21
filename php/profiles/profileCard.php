<?php
include_once('../DB.php')

?>

<div class="mb-4">
  <div class="card flex mb-4">
    <div class="card--main">
      <a href="/profiles/{{this.id}}">
        <h3 class="card--header text-3xl text-amber-200 book-modal cursor-pointer" book-id="${
        item.id
      }">CardID: {{this.id}}</h3>
      </a>
      <h5 class="card--header text-2xl text-amber-200">{{this.name}}</h5>
      <a href="mailto:{{this.email}}" class="block card--header text-2xl text-amber-200">{{this.email}}</a>
      <a href="tel:{{this.phone}}" class="block card--description">{{this.phone}}</a>
      <p>Книг в резерве {{this.reserve}}</p>
    </div>
  </div>
</div>