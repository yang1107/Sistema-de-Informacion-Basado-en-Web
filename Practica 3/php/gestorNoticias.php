<?php
//include_once('php/database.php');

class GestorNoticias{

    function GestorNoticias(){
    }

   /* function parsearCuerpo($cuerpo){
        for($i=0;$i<count($cuerpo);$i++){
             if($cuerpo[$i]=='['){
                  if($cuerpo[$i+1]=='I' && $cuerpo[$i+2]=='M' && $cuerpo[$i+3]=='G' && $cuerpo[$i+4]==']'){
                      $aux=$i;
                      $i=$i+5;
                      $fin=false;
                      $ruta="";
                      while(!$fin){

                           if($cuerpo[$i]=='['){
                                if($cuerpo[$i+1]=='/' && $cuerpo[$i+2]=='I' && $cuerpo[$i+3]=='M' && $cuerpo[$i+4]=='G' && $cuerpo[$i+5]==']'){
                                   $i=$i+6;

                                   $fin=true;
                                }
                           }
                           else{
                                $ruta=$ruta.$cuerpo[$i];
                                $i++;
                           }
                      }
                  }
             }
        }
        /*<div class="imagen_cuerpo">
             <img src="../../imagenes/noticia/imagen2.png" alt="Jurado con una bolsa de Real Madrid">
             <p class="pie_imagen"> Jurado, jugador del Espanyol </p>
        </div>
        <div class="imagen_cuerpo">
             <img src="../../imagenes/noticia/imagen1.png" alt="Gil Manzano, en el Villarreal-Madrid">
             <p class="pie_imagen"> Gil Manzano, en el Villarreal-Madrid </p>
        </div>
   }*/

   function getNoticiasPortada(){
        $resultado = '<div id="content_portada"><div id="news"><div id="contenido"><div id="conjunto_columnas"><div id="columna1">';
        for($i=1; $i<4; $i++){
             $resultado = $resultado . $this->getNoticiaTitular($i);
        }

        $resultado = $resultado . '</div>';
        $resultado = $resultado . '<div id="columna2">';

        for($i=4; $i<7; $i++){
             $resultado = $resultado . $this->getNoticiaTitular($i);
        }

        $resultado = $resultado . '</div>';
        $resultado = $resultado . '<div id="columna3">';

        for($i=7; $i<10; $i++){
             $resultado = $resultado . $this->getNoticiaTitular($i);
        }

        $resultado = $resultado . '</div></div></div></div>';

        $resultado = $resultado . '<div id="publi" >

                          <div class="adv">
                               <img alt="adv1" class="advs" src="./imagenes/publi/banner1.png"/>
                          </div>

                          <div class="adv">
                               <img alt="adv2" class="advs" src="./imagenes/publi/banner2.png" />
                          </div>

                          <div class="adv">
                               <img alt="adv3" class="advs" src="./imagenes/publi/banner3.png"/>
                          </div>

                          <div class="adv">
                               <img alt="adv4" class="advs" src="./imagenes/publi/banner4.png"/>
                          </div>
                     </div>
                  </div>';
        return $resultado;
   }

   function getNoticiasSeccion($seccion){
        if(strcmp ($seccion , 'Fotos' ) == 0){
             include_once('php/galeria/galeria.php');
        }else if(strcmp( $seccion , 'Videos' ) == 0){
             include_once('php/video/video.php');
        }
       else{
            $conexion=new Database();
            $conexion->connect();
            $conexion->query("SET NAMES 'utf8'");
            $result=$conexion->query("select count(*) from noticias where seccion='".$seccion."'");
            $numeroNoticias=$result->fetch_row();
            $numeroNoticias=$numeroNoticias[0];

            $idNoticias=[];
            $result=$conexion->query("select id from noticias where seccion='".$seccion."'");
            for($i=0;$i<$numeroNoticias;$i++){
              $id=$result->fetch_assoc();
              $idNoticias[$i]=$id['id'];
            }


              $resultado = '<div id="content_portada"><div id="news"><div id="contenido"><div id="conjunto_columnas"><div id="columna1">';
             for($i=0; $i<$numeroNoticias/3; $i++){
                  $resultado = $resultado . $this->getNoticiaTitular($idNoticias[$i]);
             }

             $resultado = $resultado . '</div>';
             $resultado = $resultado . '<div id="columna2">';

             for($i=$numeroNoticias/3; $i<($numeroNoticias/3)*2; $i++){
                  $resultado = $resultado . $this->getNoticiaTitular($idNoticias[$i]);
             }

             $resultado = $resultado . '</div>';
             $resultado = $resultado . '<div id="columna3">';

             for($i=($numeroNoticias/3)*2; $i<$numeroNoticias; $i++){
                  $resultado = $resultado . $this->getNoticiaTitular($idNoticias[$i]);
             }
             $conexion->close();
              $resultado = $resultado . '</div></div></div></div>';
              $resultado = $resultado . '<div id="publi" >

                               <div class="adv">
                                    <img alt="adv1" class="advs" src="./imagenes/publi/banner1.png"/>
                               </div>

                               <div class="adv">
                                    <img alt="adv2" class="advs" src="./imagenes/publi/banner2.png" />
                               </div>

                               <div class="adv">
                                    <img alt="adv3" class="advs" src="./imagenes/publi/banner3.png"/>
                               </div>

                               <div class="adv">
                                    <img alt="adv4" class="advs" src="./imagenes/publi/banner4.png"/>
                               </div>
                          </div>
                       </div>';

             return $resultado;
        }
   }


        function getNoticiaTitular($id){
             $conexion=new Database();
             $conexion->connect();
             $conexion->query("SET NAMES 'utf8'");
             $result=$conexion->query("select * from noticias where id=$id");
             $noticia=$result->fetch_assoc();

             $resultado = '
             <div class="noticia">
                 <div class="div_imagen_columna2">
                       <img alt=""  class="imagen_columna1" src="'.$noticia['fotografia'].'"/>
                 </div>
                 <div class="texto_noticia_col2">
                       <p class="centrar_noticia"><a href="index.php?noticia='.$id.'" class="enlaces_noticias">'.$noticia['titular'].'</a></p>
                 </div>
             </div>';

             $conexion->close();
             return $resultado;
        }

        function getComentarios($id){
             $conexion=new Database();
             $conexion->connect();
             $conexion->query("SET NAMES 'utf8'");
             $result=$conexion->query("select * from noticias where id=$id");
             $noticia=$result->fetch_assoc();


             $etiqueta = $noticia['etiqueta'];


             $result = $conexion->query("SELECT * FROM noticias WHERE etiqueta='".$etiqueta."'");
             $noticiasRelacionadas = $result->fetch_all();

             $resultado ='<div id="derecho"><p id="titulo_derecha">Noticias relacionadas</p>';

             $randomArray = [];
             for($j=0; $j<count($noticiasRelacionadas); $j++){
                  $randomArray[$j] = $j;
             }
             shuffle($randomArray);


             $relacionada = "";
             for($i=0; $i<3; $i++){
                  $rand = $randomArray[$i];
                  $relacionada = $relacionada . '<div class="noticia">
                       <div class="imagennoticia">
                            <img class="imagenes_noticias" src="'.$noticiasRelacionadas[$rand][10].'" />
                       </div>
                       <div class="textonoticia">
                            <p class="titulonoticia"><a href="index.php?noticia='.$noticiasRelacionadas[$rand][0].'" class="enlaces_noticias">'.$noticiasRelacionadas[$rand][3].'</a></p>
                       </div>
                    </div>';
             }

                    $resultado = $resultado . $relacionada . '<script> var desplegado=false </script>
         			<button id="boton_comentarios" onclick="javascript:desplegarComentarios()">Comentarios</button>
         			<button id="boton_quitar_comentarios" onclick="javascript:quitarComentarios()">Ocultar Comentarios</button>
         			<div id="div_comentarios">';

         						$result=$conexion->query("select * from comentarios where idNoticia=$id");
                                   $rango=mysqli_num_rows($result);
                                   for($i=1;$i<=$rango;$i++){
                                        $informacion=$result->fetch_assoc();
                                        $resultado = $resultado .' <div class="comentario">
              							<p class="th_comentario">#Comentario'.$i.'</p>
              								<p class="autor_comentario"><label class="negrita">Autor:</label>'.$informacion["autor"].' | '.$informacion["correoElectronico"].' </p>
                                                  <p class="fecha_comentario"><label class="negrita">Fecha y Hora:</label>'.$informacion["fecha"].'  '.$informacion["hora"].'</p>
                                                  <p class="descripcion_comentario" ><label class="negrita">Descripción</label></p>
                                                  <div>
                                                       <p class="texto_comentario">'.$informacion["texto"].'</p>

                                                  </div>
                                        </div>';
                                   }
                                   if(isset($_SESSION['user'])){
                   					$resultado = $resultado . '<div id="formulario_comentarios">
                   							<form id="form_comentarios" method="POST" action="#">
                   								<table id="formulario_comentario">
                   									<tr><td class="cabecera_comentario" colspan="2">Escribe tu comentario</td></tr>
                   									<tr><td>Comentario:</td> <td><textarea id="texto_com" name="text_comentario" onKeyUp="javascript:compruebaPalabra('."'texto_com'".')"
                   														  ></textarea></td></tr>
                   									<tr><td colspan="2"><p><input id="boton_enviar_form" type="submit" value="Enviar" name="enviarcomentario"></p></td></tr>
                   								</table>
                   							</form>
                   						</div>';
                                   }
         		$resultado = $resultado .'</div>
               </div>';

               $conexion->close();
               return $resultado;
       }


   function getRealIP(){

   if (isset($_SERVER["HTTP_CLIENT_IP"]))
   {
       return $_SERVER["HTTP_CLIENT_IP"];
   }
   elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
   {
       return $_SERVER["HTTP_X_FORWARDED_FOR"];
   }
   elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
   {
       return $_SERVER["HTTP_X_FORWARDED"];
   }
   elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
   {
       return $_SERVER["HTTP_FORWARDED_FOR"];
   }
   elseif (isset($_SERVER["HTTP_FORWARDED"]))
   {
       return $_SERVER["HTTP_FORWARDED"];
   }
   else
   {
       return $_SERVER["REMOTE_ADDR"];
   }

}

   function insertaComentario($texto,$idNoticia){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $fecha = getdate();
        $anio = $fecha['year'];
        $dia = $fecha['mday'];
        $mes = $fecha['mon'];
        $fech=$anio.'-'.$mes.'-'.$dia;
        $hora = $fecha['hours'];
        $minutos = $fecha['minutes'];
        $segundos = $fecha['seconds'];
        $hor=$hora.':'.$minutos.':'.$segundos;
        $autor=$_SESSION['user'];

        $result=$conexion->query(" select correoElectronico from usuarios where usuario='".$autor."'");
        $correo=$result->fetch_row();
        $correo=$correo[0];

        $result=$conexion->query(" select * from comentarios");
        $idComentario=mysqli_num_rows($result);

        $ip=$this->getRealIP();

        echo $idNoticia."<br/>".$idComentario."<br/>".$autor."<br/>".$correo."<br/>".$fech."<br/>".$hor."<br/>".$texto."<br/>".$ip."<br/>";

        $q="insert into comentarios(idNoticia,idComentario,autor,correoElectronico,fecha,hora,texto,ip)
                 values(".$idNoticia.",".$idComentario.",'".$autor."','".$correo."','".$fech."','".$hor.",'".$texto."','".$ip."')";
        $res=$conexion->query($q);
        if($res)
          echo '<script language="javascript">alert("Comentario insertado correctamente");</script>';
   }




    function getNoticia($id, $ruta=""){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select * from noticias where id=$id");
         $noticia=$result->fetch_assoc();

         $cuerpo=$noticia['cuerpo'];

         $resultado='
         <div id="caja">

            <div id="izquierda">
               	     <p id="titulo">'.$noticia['titular'].'</p>

                         <div class="imagen_cuerpo">
                              <img id="imagenNoticia" src="'.$ruta.$noticia['fotografia'].'" alt="Imagen de portada">
                              <p class="pie_imagen"> Imagen de portada </p>
                         </div>

         			<p id="subtitulo">'.$noticia['subtitulo'].'</p>

         			<p id="entradilla">'.$noticia['entradilla'].'</p>

         			<p id="fecha_y_autor">'.$noticia['autor'].' fecha Publicación: '.$noticia['fechaPublicacion'].'  fecha Modificación: '.$noticia['fechaModificacion'].'</p>

         			<div id="cuerpo">
         				<p>'.$noticia['cuerpo'].'
                         </p>

                    <div id="botones_noticias">

                              <a  href=javascript:compartir(); ><img id="boton_imprimir" src="imagenes/logos/facebook.png" title="click para imprimir compartir" alt="compartir noticia en facebook" /></a>


                              <a  href=javascript:compartir(); ><img id="boton_imprimir" src="imagenes/logos/twitter.png" title="click para imprimir compartir" alt="compartir noticia en twitter" /></a>


         					<a  href="php/imprimible/imprimible.php?noticia='.$id.'" target="_blank"><img id="boton_imprimir" src="'.$ruta.'imagenes/botones/imprimir.jpg" title="click para imprimir esta noticia" alt="imprimir noticia" /></a>

                    </div>

         		     </div>
               </div>';
         $conexion->close();
         return $resultado;
    }


    function getNoticiaImp($id, $ruta=""){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select * from noticias where id=$id");
         $noticia=$result->fetch_assoc();

         $cuerpo=$noticia['cuerpo'];

         $resultado='
         <div id="box">

            <div id="container">
                     <p id="titulo">'.$noticia['titular'].'</p>

                         <div class="imagen_cuerpo">
                              <img id="picture" src="'.$ruta.$noticia['fotografia'].'" alt="Imagen de portada">
                              <p class="pie_imagen"> Imagen de portada </p>
                         </div>

                     <p id="subtitulo">'.$noticia['subtitulo'].'</p>

                     <p id="entradilla">'.$noticia['entradilla'].'</p>

                     <p id="fecha_y_autor">'.$noticia['autor'].' fecha Publicación: '.$noticia['fechaPublicacion'].'  fecha Modificación: '.$noticia['fechaModificacion'].'</p>

                     <div id="cuerpoimp">
                          <p class="noticiaimp">'.$noticia['cuerpo'].'
                         </p>



                     </div>
               </div>';
         $conexion->close();
         return $resultado;
    }

    function getNoticiaTotal($id){
         $resultado = $this->getNoticia($id);
         $resultado = $resultado . $this->getComentarios($id);
         $resultado = $resultado . '</div>';
         return $resultado;
    }

}

?>
