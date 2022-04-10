<!DOCTYPE html>
<html>
     <?php
          session_start();
          header("Content-Type: text/html;charset=utf-8");
          include_once('php/gestorIndice.php');
          include_once('php/gestorNoticias.php');
          include_once('php/database.php');
          include_once('php/gestorSeccion.php');
          include_once('php/gestorSesiones.php');

          $gestorIndice=new GestorIndice();
          $gestorNoticias=new GestorNoticias();
          $gestorSesiones=new GestorSesiones();


          $gestorIndice->get('php/head.php');


     echo '<body>
          <div id="contenedor">';

                    $gestorIndice->get('php/header.php');

               if(isset($_GET['seccion'])){
                    $seccion=$_GET['seccion'];
                    echo $gestorIndice->getSeccion($seccion);
               }
               else if(isset($_GET['login'])){

                    if(isset($_POST['enviar'])){
                         $usuario=$_POST['usuario'];
                         $password=md5($_POST['password']);
                         $gestorSesiones->compruebaUsuario($usuario,$password);
                    }

                    else{
                         echo $gestorSesiones->getLogin();
                    }
                }
               else if(isset($_GET['desconectar'])){
                    $gestorSesiones->desconectar();
               }
               else{


                    if(isset($_GET['noticia'])){

                         //$gestorIndice->get('noticias/futbol/ejemploNoticia.html');
                         $idNoticia = $_GET['noticia'];
                         echo $gestorNoticias->getNoticiaTotal($idNoticia);
                         if(isset($_POST['enviarcomentario'])){
                              $texto=$_POST['text_comentario'];
                              $gestorNoticias->insertaComentario($texto,$idNoticia);
                         }

                    }
                    else{

                               echo $gestorNoticias->getNoticiasPortada();

                    }
               }
                    $gestorIndice->get('php/footer.php');
               ?>

          </div> <!-- FIN DIV CONTENEDOR -->
     </body>

</html>
