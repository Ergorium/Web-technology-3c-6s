<?php
function queryConverter($values) {
  $res = [];
  foreach ($values as $key => $value) {
    if ($key === 'overdue') {
      array_push($res, 'datediff(timeout, created_at) < 0');
      continue;
    }
    if (preg_match_all('/.*id.*/mi', $key, $matches, PREG_SET_ORDER, 0)) {
      array_push($res, "$key = $value");
      continue;
    }
    if (in_array($key, ['canceled', 'reserved'])) {
      array_push($res, "$key = " . ($value ? 'true' : 'false'));
      continue;
    }
    if ($value) array_push($res, "$key like '%$value%'");
  }
  if (count($res) == 0) {
    return '';
  }
  return implode(' and ', $res);
}
?>