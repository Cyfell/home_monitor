<!DOCTYPE html>
<html lang="en">
<?php include "header.html"; ?>
<body>
<?php include "navbar.html"; ?>
<div class="container">
  <h1>Tram</h1>
  <?php
  $query = http_build_query(array('search'=>$as_any, 'location'=>$location));
  $url = "https://google.com" . $query;
  $my_var = file_get_contents($url);
  var_dump($my_var);
  ?>
</div>

</body>
<?php include "footer.html"; ?>
</html>
