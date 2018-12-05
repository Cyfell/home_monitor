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
      define('ARRETS', array(
          'JAME',
          'XBON',
      ));

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

      foreach ( ARRETS as $arret_name) {
        ?>
        <div class="col-sm-3" style="border-style: solid; border-radius: 10px; background: #E0E0E0">
        <?php
        $arret = get_info_arret($arret_name);
        echo "<h2>";
        echo $arret[0]['arret']['codeArret'];
        echo "</h2>";
        $nb_trams = 0;
        foreach ($arret as $obj) {
          if ($obj['sens'] == 2){
            echo "A destination de ";
            echo $obj['terminus'];
            echo '</br>';
            echo "prochain départ : ";
            echo  $obj['temps'];
            echo '</br>';
            echo '</br>';
            $nb_trams++;
            if ($nb_trams >= NB_TRAMS_MAX){
              break;
            }
          }
        }
        echo "</div>";
      }
      ?>
    </div>
  </div>

</body>
<?php include "footer.html"; ?>
</html>
