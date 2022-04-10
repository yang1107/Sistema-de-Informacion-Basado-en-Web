
<div id="header">
     <div id="imagen_logo">
          <div id="log">
               <img alt="Diario Deportivo"  id="logo" src="imagenes/logos/logo.png"/>
          </div>
          <div id="iniciar">
               <?php
                    if(!isset($_SESSION['user']))
                         echo '<a href="index.php?login" id="iniciar_sesion">Iniciar sesion</a>';
                    else
                         echo '<a href="index.php?desconectar" id="iniciar_sesion"> Cerrar Sesión</a>';
               ?>


          </div>
     </div>

     <div id="secciones">
          <div class="seccion">
               <ul id="lista_secciones">
                    <?php
                         $database= new Database();
                         $database->connect();
                         $resultado=$database->query("SELECT * FROM menu");

                              while ( $fila=$resultado->fetch_row() ){
                                   echo "<li class='lista_seccion'><a class='enlaces_secciones' href='index.php?seccion=$fila[1]'>$fila[1]</li>";
                                   echo "<ul class='subsecciones'>";
                                   for($a=2;$a<6;$a++) {
                                        if (!is_null($fila[$a])){

                                             echo "<li><a href='#'>$fila[$a]</a></li>" . "\n";

                                        }
                                        else{
                                             echo "es nulo.";
                                        }

                                   }
                                             echo "</ul>";
                              }

                         $database->close();
                     ?>
                </ul>
           </div>
      </div>
</div>
