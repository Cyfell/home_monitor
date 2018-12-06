<!DOCTYPE html>
<html lang="en">
<?php include "header.html"; ?>
<body>
<?php include "navbar.html"; ?>
<div class="container">
  <h1>Tram</h1>
  <div class="row">
      <?php


      define("NB_TRAMS_MAX", 2);

      function get_info_arret($code_arret){
        $url = "http://open.tan.fr/ewp/tempsattente.json/$code_arret";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = utf8_encode($data);
        return json_decode($data, true);
      }

      $dbname='home_monitor';
      $mytable ="Tan";

      $dir = 'sqlite:home_monitor.sqlite';

      $dbh = new PDO($dir) or die("cannot open the database");
      $query = "SELECT * FROM Tan";

      foreach ($dbh->query($query) as $db_result)
      {
          ?>
          <div class="col-sm-3" style="border-style: solid; border-radius: 10px; background: #E0E0E0; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
          <?php
          $arret = get_info_arret($db_result['stop_code_name']);
          echo "<h2>";
          echo $db_result['stop_name'];
          echo "</h2>";
          $nb_trams = 0;
          foreach ($arret as $obj) {
            if ($obj['sens'] == $db_result['direction'] && $obj['ligne']['numLigne'] == $db_result['line_num'] && $obj['ligne']['typeLigne'] == $db_result['line_type']){
              echo "Ligne ";
              echo $obj['ligne']['numLigne'];
              echo " destination de ";
              echo $obj['terminus'];
              echo '</br>';
              echo "Prochain départ : ";
              echo  $obj['temps'];
              echo '</br>';
              echo '</br>';
              $nb_trams++;
              if ($nb_trams >= $db_result['depth']){
                break;
              }
            }
          }
          echo "</div><div class=\"col-sm-1\"></div>";
      }
      ?>
    </div>
  </div>

</body>
<?php include "footer.html"; ?>
</html>
