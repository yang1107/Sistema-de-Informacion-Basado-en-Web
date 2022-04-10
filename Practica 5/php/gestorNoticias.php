<?php
//include_once('php/database.php');

class GestorNoticias{

    function GestorNoticias(){
    }

    function existeNoticia($id){
      $conexion=new Database();
      $conexion->connect();
      $conexion->query("SET NAMES 'utf8'");
      $result=$conexion->query("select * from noticias where id=$id");
      $conexion->close();
      if($result)
        return true;
      else
        return false;
    }


   function getNoticiasPortada(){

         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");

         $result=$conexion->query("select id from noticias where seccion='futbol'AND estado='PUBLICADA' order BY RAND()");
         $result2=$conexion->query("select id from noticias where seccion='baloncesto' AND estado='PUBLICADA' order BY RAND()");
         $result3=$conexion->query("select id from noticias where seccion='motor' AND estado='PUBLICADA' order BY RAND()");

        $resultado = '<div id="content_portada"><div id="news"><div id="contenido"><div id="conjunto_columnas"><div id="columna1">';
        for($i=1;$i<4;$i++){
             $f1=$result->fetch_row();
             $resultado = $resultado . $this->getNoticiaTitular($f1[0]);
        }

        $resultado = $resultado . '</div>';
        $resultado = $resultado . '<div id="columna2">';

        for($i=4; $i<7; $i++){
             $f2=$result2->fetch_row();
             $resultado = $resultado . $this->getNoticiaTitular($f2[0]);
        }

        $resultado = $resultado . '</div>';
        $resultado = $resultado . '<div id="columna3">';

        for($i=7; $i<10; $i++){
             $f3=$result3->fetch_row();
             $resultado = $resultado . $this->getNoticiaTitular($f3[0]);
        }

        $resultado = $resultado . '</div></div></div></div>';

        $resultado = $resultado . '<div id="sidebar">';
        $gestor=new GestorContenidos();
        if($gestor->comprobarSiEsJefe()){

            $resultado=$resultado . $gestor->mostrarMenuGestorContenidos();
        }
        else if($gestor->comprobarSiEsRedactor()){
            $resultado=$resultado . $gestor->mostrarMenuGestorContenidosRedactor();
        }
        $resultado = $resultado . $gestor->mostrarPublicidad();
        $resultado = $resultado . '</div></div>';
        $conexion->close();

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
            $result=$conexion->query("select count(*) from noticias where seccion='".$seccion."' AND estado='PUBLICADA'");
            $numeroNoticias=$result->fetch_row();
            $numeroNoticias=$numeroNoticias[0];

            $idNoticias=[];
            $result=$conexion->query("select id from noticias where seccion='".$seccion."' AND estado='PUBLICADA'");
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

              $resultado = $resultado . '<div id="sidebar">';
             $gestor=new GestorContenidos();
             if($gestor->comprobarSiEsJefe()){

                 $resultado=$resultado . $gestor->mostrarMenuGestorContenidos();
             }
             else if($gestor->comprobarSiEsRedactor()){
               $resultado=$resultado . $gestor->mostrarMenuGestorContenidosRedactor();
             }
             $resultado = $resultado . $gestor->mostrarPublicidad();
             $resultado = $resultado . '</div></div>';

             return $resultado;
        }
   }


        function getNoticiaTitular($id){
             $conexion=new Database();
             $conexion->connect();
             $conexion->query("SET NAMES 'utf8'");
             $result=$conexion->query("select * from noticias where id=$id ");
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
             $gestorContenidos= new GestorContenidos();

             $etiqueta = $noticia['etiqueta'];


             $result = $conexion->query("SELECT * FROM noticias WHERE etiqueta='".$etiqueta."' AND estado='PUBLICADA'");
             $noticiasRelacionadas = $result->fetch_all();

             $resultado ='<div id="derecho">';
             if($gestorContenidos->comprobarSiEsJefe()){
                  $resultado=$resultado.$gestorContenidos->mostrarMenuGestorContenidos();
             }
             else if($gestorContenidos->comprobarSiEsRedactor()){
               $resultado=$resultado . $gestorContenidos->mostrarMenuGestorContenidosRedactor();
             }
             $resultado=$resultado. '<br/><p id="titulo_derecha">Noticias relacionadas</p>';

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

        $result=$conexion->query(" select count(*) from comentarios");
        $idComentario=$result->fetch_row();
        $idComentario=$idComentario[0]+1;

        $ip=$this->getRealIP();

       // echo $idNoticia."<br/>".$idComentario."<br/>".$autor."<br/>".$correo."<br/>".$fech."<br/>".$hor."<br/>".$texto."<br/>".$ip."<br/>";

       $q= "INSERT INTO `comentarios`(`idNoticia`, `idComentario`, `autor`, `correoElectronico`, `fecha`, `hora`, `texto`, `ip`)
                    VALUES ($idNoticia,$idComentario,'$autor','$correo','$fech','$hor','$texto','$ip')";

        /*$q="insert into comentarios(idNoticia,idComentario,autor,correoElectronico,fecha,hora,texto,ip)
                 values(".$idNoticia.",".$idComentario.",'".$autor."','".$correo."','".$fech."','".$hor.",'".$texto."','".$ip."')";*/
        $res=$conexion->query($q);
        if($res){
          echo '<script language="javascript">alert("Comentario insertado correctamente");</script>';
          echo '<script language="javascript"> window.location.href = "index.php?noticia='.$idNoticia.'"</script>';

     }
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

    function getSidebar(){
         include 'php/sidebar.php';
    }

}

?>
