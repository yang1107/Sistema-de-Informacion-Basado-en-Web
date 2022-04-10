
<?php
     
     $database= new Database();
     $database->connect();
     $resultado=$database->query("SELECT * FROM noticias");
 ?>

     <p id="textogaleria">Galería de imágenes </p>

     <div id="fotos">
          <ul id='galeria'>
     <?php
          for($a=0;$a<20;$a++){
               $noticia=$resultado->fetch_assoc();
               echo '<li><img src="'.$noticia['fotografia'].'" alt="#" title="#" /></li>';
          }
          ?>

     </ul>
