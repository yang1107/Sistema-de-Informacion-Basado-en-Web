
<?php

     $database= new Database();
     $database->connect();
     $resultado=$database->query("SELECT * FROM noticias");
 ?>

     <p id="textogaleria">Galería de imágenes </p>

     <!--<div id="fotos">
          <ul id='galeria'>





        /*  for($a=0;$a<15;$a++){
               $noticia=$resultado->fetch_assoc();
               echo '<li><img src="'.$noticia['fotografia'].'" alt="#" title="#" /></li>';
          }*/


     </ul>-->
<?php
$noticia=$resultado->fetch_assoc();
      echo '<div class="galeria"/>';
         for($a=1;$a<15;$a++){
            $noticia=$resultado->fetch_assoc();
            echo '<img src="'.$noticia['fotografia'].'" />';
       }
       echo '</div>';
?>
  </div>
</div>
