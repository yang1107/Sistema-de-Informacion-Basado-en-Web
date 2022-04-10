
<div class="noticia">
     <div class="div_imagen_columna2">
     </div>
     <div class="texto_noticia_col2">
          <?php
               $database= new Database();
               $database->connect();
               $result=$database->query("select * from noticias");
               $noticia=$result->fetch_assoc();

               echo '<p class="centrar_noticia"><a href="#" class="enlaces_noticias">'.$noticia['titular'].'</a></p>';
               echo '<img alt="Sergio Ramos" class="imagen_columna1" src="'.$noticia['fotografia'].'"/>';
               $database->close();
          ?>



     </div>
</div>
