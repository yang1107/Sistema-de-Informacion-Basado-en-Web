<?php
          session_start();
          include_once('database.php');
          include_once('gestorContenidos.php');
          $gestorContenidos=new GestorContenidos();
          $conexion=new Database();
          $conexion->connect();
          $conexion->query("SET NAMES 'utf8'");
          $texto=$_GET['textoBusqueda'];
          if( $gestorContenidos->comprobarSiEsJefe() || $gestorContenidos->comprobarSiEsRedactor() ){
               if($texto!=""){
                    $result=$conexion->query("select titular,id from noticias where (titular LIKE '%".$texto."%') OR (entradilla LIKE '%".$texto."%') LIMIT 10 ");
                    while($resultadoBusqueda=$result->fetch_assoc() ){
                         echo "<a class='enlaceSugerencia' href=index.php?noticia=".$resultadoBusqueda['id']."><p>".$resultadoBusqueda['titular']."</p></a>";
                    }
               }
               else{
                    echo "";
               }
          }

          else{
               if($texto!=""){
                    $result=$conexion->query("select titular,id from noticias where ( (titular LIKE '%".$texto."%') OR (entradilla LIKE '%".$texto."%') ) AND (estado <>'RECHAZADA' AND estado <>'PENDIENTE' )  LIMIT 10 ");
                    while($resultadoBusqueda=$result->fetch_assoc() ){
                         echo "<a class='enlaceSugerencia' href=index.php?noticia=".$resultadoBusqueda['id']."><p>".$resultadoBusqueda['titular']."</p></a>";
                    }
               }
               else{
                    echo "";
               }
          }
          $conexion->close();


          //if($resultadoBusqueda)
               //echo "<p>".$resultadoBusqueda[0]."</p>";






?>
