<?php

class GestorContenidos{


  function mostrarMenuGestorContenidos(){
       return "<div class='menuGestorContenidos' id='menuGestorContenidos'>
                  <h2 id='cabecera_gestor'> Gestor de contenidos </h2>
                  <a class='enlace_gestor' href='index.php?gestion&gComentarios'><p>Gestor de comentarios</p></a>
                  <a class='enlace_gestor' href='index.php?gestion&gNoticias'><p> Gestor de noticias</p></a>
                  <a class='enlace_gestor' href='index.php?gestion&gPublicidad'><p>Gestor de publicidad</p></a>
                  <a class='enlace_gestor' href='index.php?gestion&gSecciones'><p>Gestor de secciones</p></a>
                  <a class='enlace_gestor' href=''><p>Organizador de la página de inicio</p></a>
             </div>";
  }

  function mostrarMenuGestorContenidosRedactor(){
       return "<div class='menuGestorContenidos' id='menuGestorContenidos'>
                  <h2> Gestor de contenidos </h2>
                  <a class='enlace_gestor' href='index.php?gestion&gNoticias&aniadeNoticia'><p>Insertar Noticia</p></a>
             </div>";
  }

    function comprobarSiEsJefe(){
         if(!isset($_SESSION['user'])){
              return false;
         }
         else{
            $usuario=$_SESSION['user'];
            $conexion=new Database();
            $conexion->connect();
            $conexion->query("SET NAMES 'utf8'");
            $result=$conexion->query("select rol from usuarios where usuario='".$usuario."'");
            $tipoUsuario=$result->fetch_row();
            $tipoUsuario=$tipoUsuario[0];
            $conexion->close();
            if($tipoUsuario=="Jefe"){
                 return true;
            }
            else {
                 return false;
            }

         }
    }
    function comprobarSiEsRedactor(){
         if(!isset($_SESSION['user'])){
              return false;
         }
         else{
            $usuario=$_SESSION['user'];
            $conexion=new Database();
            $conexion->connect();
            $conexion->query("SET NAMES 'utf8'");
            $result=$conexion->query("select rol from usuarios where usuario='".$usuario."'");
            $tipoUsuario=$result->fetch_row();
            $tipoUsuario=$tipoUsuario[0];
            $conexion->close();
            if($tipoUsuario=="Redactor"){
                 return true;
            }
            else {
                 return false;
            }

         }
    }
    function mostrarGestorComentarios(){
              return "
              <div class='menu_gestor'>
               <h1 class='cab_enlace_gestorespec'>Gestor de comentarios</h1>
               <a class='enlace_gestorespec' href='index.php?gestion&gComentarios&Insertar'><p>1. Insertar Comentario</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gComentarios&eliminar'><p>2. Eliminar Comentario</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gComentarios&modificar'><p>3. Modificar Comentario</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gComentarios&verComentarios'><p>4. Ver comentarios</p></a>
               </div>
              ";
    }
    function mostrarNoticiasDisponiblesParaInsertarComentario(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select id,seccion,etiqueta,titular,autor,fechaPublicacion,fechaModificacion,fotografia from noticias");
         $salida="<h1 class='center'>Insertar Comentario</h1>
         <table class='table2'>
              <thead>
                         <tr>
                             <th scope='col'></th>
                             <th scope='col' >id</th>
                             <th scope='col' >seccion</th>
                             <th scope='col' >etiqueta</th>
                             <th scope='col'>titular</th>
                             <th scope='col' >autor</th>
                             <th scope='col' >fechaPublicacion</th>
                             <th scope='col' >fechaModificacion</th>
                             <th scope='col' >fotografia</th>
                         </tr>
                     </thead>
              <tbody>
              ";

         if($result){
              $contador=1;
              while ($fila = $result->fetch_row()) {

                   $salida= $salida. '
                         <tr>
                             <td><a href="index.php?gestion&gComentarios&Insertar&not='.$fila[0].'"><img class="checkGestion" src="imagenes/logos/check.png"/></a></td>
                             <td>'.$fila[0].'</td>
                             <td>'.$fila[1].'</td>
                             <td>'.$fila[2].'</td>
                             <td>'.$fila[3].'</td>
                             <td>'.$fila[4].'</td>
                             <td>'.$fila[5].'</td>
                             <td>'.$fila[6].'</td>';
                             $ruta=$fila[7];

                            $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>

                           </tr>";
                  $contador++;
              }
         }
         $salida=$salida . ' </tbody></table>';
         $conexion->close();
         return $salida;
    }

    function mostrarNoticiasDisponiblesParaEliminarComentario(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select id,seccion,etiqueta,titular,autor,fechaPublicacion,fechaModificacion,fotografia from noticias");
         $salida="<h1 class='center'>Eliminar Comentario</h1>
         <table class='table2'>
              <thead>
                         <tr>
                             <th scope='col'></th>
                             <th scope='col' >id</th>
                             <th scope='col' >seccion</th>
                             <th scope='col' >etiqueta</th>
                             <th scope='col'>titular</th>
                             <th scope='col' >autor</th>
                             <th scope='col' >fechaPublicacion</th>
                             <th scope='col' >fechaModificacion</th>
                             <th scope='col' >fotografia</th>
                         </tr>
                     </thead>
              <tbody>
              ";

         if($result){
              $contador=1;
              while ($fila = $result->fetch_row()) {

                   $salida= $salida. '
                         <tr>
                             <td><a href="index.php?gestion&gComentarios&eliminar&not='.$fila[0].'"><img class="checkGestion" src="imagenes/logos/cruz.jpg"/></a></td>
                             <td>'.$fila[0].'</td>
                             <td>'.$fila[1].'</td>
                             <td>'.$fila[2].'</td>
                             <td>'.$fila[3].'</td>
                             <td>'.$fila[4].'</td>
                             <td>'.$fila[5].'</td>
                             <td>'.$fila[6].'</td>';
                             $ruta=$fila[7];

                            $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>

                           </tr>";
                  $contador++;
              }
         }
         $salida=$salida . ' </tbody></table>';
         $conexion->close();
         return $salida;
    }

    function mostrarNoticiasDisponiblesParaModificarComentario(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select id,seccion,etiqueta,titular,autor,fechaPublicacion,fechaModificacion,fotografia from noticias");
         $salida="<h1 class='center'>Modificar Comentario</h1>
         <table class='table2'>
              <thead>
                         <tr>
                             <th scope='col'></th>
                             <th scope='col' >id</th>
                             <th scope='col' >seccion</th>
                             <th scope='col' >etiqueta</th>
                             <th scope='col'>titular</th>
                             <th scope='col' >autor</th>
                             <th scope='col' >fechaPublicacion</th>
                             <th scope='col' >fechaModificacion</th>
                             <th scope='col' >fotografia</th>
                         </tr>
                     </thead>
              <tbody>
              ";

         if($result){
              $contador=1;
              while ($fila = $result->fetch_row()) {

                   $salida= $salida. '
                         <tr>
                             <td><a href="index.php?gestion&gComentarios&modificar&not='.$fila[0].'"><img class="checkGestion" src="imagenes/logos/engranaje.jpg"/></a></td>
                             <td>'.$fila[0].'</td>
                             <td>'.$fila[1].'</td>
                             <td>'.$fila[2].'</td>
                             <td>'.$fila[3].'</td>
                             <td>'.$fila[4].'</td>
                             <td>'.$fila[5].'</td>
                             <td>'.$fila[6].'</td>';
                             $ruta=$fila[7];

                            $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>

                           </tr>";
                  $contador++;
              }
         }
         $salida=$salida . ' </tbody></table>';
         $conexion->close();
         return $salida;
    }


    function modificarDatosComentario($idNoticia,$idComentario){
        echo '
        <form method="POST" action="index.php?gestion&gComentarios&modificar&not='.$idNoticia.'&idc='.$idComentario.'">
        <p class="f25">Nuevo texto de comentario</p>: <textarea id="texto_com" name="text_comentario" onKeyUp="javascript:compruebaPalabra('."'texto_com'".')"
                                   ></textarea>
        <input type="hidden" name="idn" value='.$idNoticia.' />
        <input type="hidden" name="idc" value='.$idComentario.' />
        <input id="boton_enviar_form" type="submit" value="Enviar" name="enviarcomentario">
        </form>';
    }

    function mostrarComentariosNoticiaAModificar($idNoticia){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("select * from comentarios where idNoticia='$idNoticia'");
        $salida="<h1 class='center'>Comentarios de la noticia".$idNoticia."</h1>
        <form method='POST' action='index.php?gestion&gComentarios&modificar&not='$idNoticia'>
             Introducir idComentario: <input type='text' name='idComentarioModificar'/>
             <input type='hidden' name='hid' value='$idNoticia'/>
             <input id='boton_enviar_form' type='submit' value='Modificar' name='modificarComentario'>
        </form>
        <table class='table2'>
            <thead>
                        <tr>
                            <th scope='col' >idNoticia</th>
                            <th scope='col' >idComentario</th>
                            <th scope='col' >autor</th>
                            <th scope='col'>correoElectronico</th>
                            <th scope='col' >fecha</th>
                            <th scope='col' >hora</th>
                            <th scope='col' >texto</th>
                            <th scope='col' >ip</th>
                        </tr>
                    </thead>
            <tbody>
            ";
            if($result){
                $contador=1;
                while ($fila = $result->fetch_row()) {

                     $salida= $salida. '
                           <tr>
                               <td>'.$fila[0].'</td>
                               <td>'.$fila[1].'</td>
                               <td>'.$fila[2].'</td>
                               <td>'.$fila[3].'</td>
                               <td>'.$fila[4].'</td>
                               <td>'.$fila[5].'</td>
                               <td>'.$fila[6].'</td>
                               <td>'.$fila[7].'</td>

                             </tr>';
                    $contador++;
                }
           }
           $salida=$salida . ' </tbody></table>';
           $conexion->close();
           return $salida;
    }
    function formularioInsertarComentario($idNoticia){
         return '
                   <form id="form_comentarios" method="POST" action="index.php?gestion&gComentarios&Insertar&not='.$idNoticia.'">
                        <table id="formulario_comentario">
                             <tr><td class="cabecera_comentario" colspan="2">Escribe tu comentario</td></tr>
                             <tr><td><textarea id="texto_com" name="text_comentario" onKeyUp="javascript:compruebaPalabra('."'texto_com'".')"
                                                        ></textarea></td></tr>
                             <tr><td colspan="2"><p><input id="boton_enviar_form" type="submit" value="Enviar" name="enviarcomentario"></p></td></tr>
                        </table>
                   </form>
            ';
    }

    function mostrarComentariosNoticia($idNoticia){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("select * from comentarios where idNoticia='$idNoticia'");
        $salida="<h1 class='center'>Comentarios de la noticia".$idNoticia."</h1>
        <form method='POST' action='index.php?gestion&gComentarios&eliminar&not='$idNoticia'>
             Introducir idComentario: <input type='text' name='idComentarioBorrar'/>
             <input type='hidden' name='hid' value='$idNoticia'/>
             <input id='boton_enviar_form' type='submit' value='Eliminar' name='eliminarComentario'>
        </form>
        <table class='table2'>
            <thead>
                        <tr>
                            <th scope='col' >idNoticia</th>
                            <th scope='col' >idComentario</th>
                            <th scope='col' >autor</th>
                            <th scope='col'>correoElectronico</th>
                            <th scope='col' >fecha</th>
                            <th scope='col' >hora</th>
                            <th scope='col' >texto</th>
                            <th scope='col' >ip</th>
                        </tr>
                    </thead>
            <tbody>
            ";
            if($result){
                $contador=1;
                while ($fila = $result->fetch_row()) {

                     $salida= $salida. '
                           <tr>
                               <td>'.$fila[0].'</td>
                               <td>'.$fila[1].'</td>
                               <td>'.$fila[2].'</td>
                               <td>'.$fila[3].'</td>
                               <td>'.$fila[4].'</td>
                               <td>'.$fila[5].'</td>
                               <td>'.$fila[6].'</td>
                               <td>'.$fila[7].'</td>

                             </tr>';
                    $contador++;
                }
           }
           $salida=$salida . ' </tbody></table>';
           $conexion->close();
           return $salida;
    }

    function eliminarComentario($idNoticia,$idComentario){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("delete from comentarios where idNoticia=$idNoticia and idComentario=$idComentario");
         $conexion->close();
         if($result){
             echo '<script language="javascript">alert("Comentario eliminado correctamente");</script>';
             echo '<script language="javascript"> window.location.href = "index.php?noticia='.$idNoticia.'"</script>';
         }
    }

    function modificarComentario($idNoticia,$idComentario,$texto){
              $conexion=new Database();
              $conexion->connect();
              $conexion->query("SET NAMES 'utf8'");
              $idNoticia=$_GET['not'];
              $result=$conexion->query("select autor,correoElectronico,fecha,hora,ip from comentarios where idNoticia=$idNoticia AND idComentario=$idComentario");
              $fila = $result->fetch_row();
              //=$result->fetch_assoc();
            //  $autor=$fila['autor']; $correo=$fila['correoElectronico']; $fecha=$fila['fecha']; $hora= $fila['hora']; $ip=$fila['ip'];
              $autor=$fila[0]; $correo=$fila[1]; $fecha=$fila[2]; $hora= $fila[3]; $ip=$fila[4];
              //echo " <h1>".$idNoticia." ".$idComentario." ".$texto." </h1>";


              $result2=$conexion->query("UPDATE `comentarios` SET `idNoticia`=$idNoticia,`idComentario`=$idComentario,`autor`='$autor',
                   `correoElectronico`='$correo',`fecha`='$fecha',`hora`='$hora',`texto`='$texto',`ip`='$ip'
                   WHERE idNoticia=$idNoticia and idComentario=$idComentario");
              $conexion->close();
              if($result2){
                 echo '<script language="javascript">alert("Comentario modificado correctamente");</script>';
                 echo '<script language="javascript"> window.location.href = "index.php?noticia='.$idNoticia.'"</script>';
              }
    }
    function mostrarNoticiasDisponiblesParaObservarComentario(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select id,seccion,etiqueta,titular,autor,fechaPublicacion,fechaModificacion,fotografia from noticias");
         $salida="<h1 class='center'>Ver Comentarios</h1>
         <table class='table2'>
              <thead>
                         <tr>
                             <th scope='col'></th>
                             <th scope='col' >id</th>
                             <th scope='col' >seccion</th>
                             <th scope='col' >etiqueta</th>
                             <th scope='col'>titular</th>
                             <th scope='col' >autor</th>
                             <th scope='col' >fechaPublicacion</th>
                             <th scope='col' >fechaModificacion</th>
                             <th scope='col' >fotografia</th>
                         </tr>
                     </thead>
              <tbody>
              ";

         if($result){
              $contador=1;
              while ($fila = $result->fetch_row()) {

                   $salida= $salida. '
                         <tr>
                             <td><a href="index.php?gestion&gComentarios&verComentarios&not='.$fila[0].'"><img class="checkGestion" src="imagenes/logos/check.png"/></a></td>
                             <td>'.$fila[0].'</td>
                             <td>'.$fila[1].'</td>
                             <td>'.$fila[2].'</td>
                             <td>'.$fila[3].'</td>
                             <td>'.$fila[4].'</td>
                             <td>'.$fila[5].'</td>
                             <td>'.$fila[6].'</td>';
                             $ruta=$fila[7];

                            $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>

                          </tr>";
                  $contador++;
              }
         }
         $salida=$salida . ' </tbody></table>';
         $conexion->close();
         return $salida;
    }

    function mostrarComentariosNoticiaAObservar($idNoticia){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("select * from comentarios where idNoticia='$idNoticia'");
        $salida="<h1 class='center'>Comentarios de la noticia".$idNoticia."</h1>
        <table class='table2'>
            <thead>
                        <tr>
                            <th scope='col' >idNoticia</th>
                            <th scope='col' >idComentario</th>
                            <th scope='col' >autor</th>
                            <th scope='col'>correoElectronico</th>
                            <th scope='col' >fecha</th>
                            <th scope='col' >hora</th>
                            <th scope='col' >texto</th>
                            <th scope='col' >ip</th>
                        </tr>
                    </thead>
            <tbody>
            ";
            if($result){
                $contador=1;
                while ($fila = $result->fetch_row()) {

                     $salida= $salida. '
                           <tr>
                               <td>'.$fila[0].'</td>
                               <td>'.$fila[1].'</td>
                               <td>'.$fila[2].'</td>
                               <td>'.$fila[3].'</td>
                               <td>'.$fila[4].'</td>
                               <td>'.$fila[5].'</td>
                               <td>'.$fila[6].'</td>
                               <td>'.$fila[7].'</td>

                             </tr>';
                    $contador++;
                }
           }
           $salida=$salida . ' </tbody></table>';
           $conexion->close();
           return $salida;
    }

    /*GESTOR DE NOTICIAS*/

    function mostrarGestorNoticias(){
         return "
         <div class='menu_gestor'>
          <h1 >Gestor de noticias</h1>
          <a class='enlace_gestorespec' href='index.php?gestion&gNoticias&aniadeNoticia'><p>1. Añadir Noticia</p></a>
          <a class='enlace_gestorespec' href='index.php?gestion&gNoticias&eliminarNoticia'><p>2. Eliminar noticia</p></a>
          <a class='enlace_gestorespec' href='index.php?gestion&gNoticias&modificarNoticia'><p>3. Modificar noticia</p></a>
          <a class='enlace_gestorespec' href='index.php?gestion&gNoticias&ordenarNoticia'><p>4. Mostrar ordenado por secciones y subsecciones</p></a>
          <a class='enlace_gestorespec' href='index.php?gestion&gNoticias&cambiarEstadoNoticia'><p>5. Cambiar estado noticias</p></a>
          </div>
        ";
    }


    function mostrarformularioSeccion(){
         $salida= '
         <h1>Elige la sección</h1>
         <form method="POST" action="index.php?gestion&gNoticias&aniadeNoticia">
          <select name="seccion">
         ';

         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select principal from menu");
         if($result){
              while ($fila = $result->fetch_assoc() ) {
                         $salida=$salida.'<option value='.$fila['principal'].'> '.$fila['principal'].'</option>';
              }
         }
         $salida=$salida.'</select>
         <input id="boton_enviar_form" type="submit" value="Aceptar" name="seleccionSeccion">
         </form>';

         $conexion->close();
         return $salida;
    }

    function formularioInsertarNoticia($seccion){
         $salida='<h1 class="center">Insertar Noticia Sección '.$seccion.'</h1>
         <div id="formInsertarNoticia">
              <form method="POST" action="index.php?gestion&gNoticias&aniadeNoticia&secc='.$seccion.'">
              <p class="f20">Etiqueta: <input type="text" name="etiqueta" /></p>
              <p class="f20">Titular: <textarea rows="4" cols="40"  name="titular"></textarea></p>
              <p class="f20">Subtitulo: <textarea rows="4" cols="40"  name="subtitulo"></textarea></p>
              <p class="f20">Entradilla: <textarea  rows="4" cols="40" name="entradilla"></textarea></p>
              <p class="f20">Cuerpo: <textarea rows="8" cols="100"  name="cuerpo"></textarea></p>
              <p class="f20">Fotografia (ruta): <textarea  name="foto"></textarea></p>
              <input id="boton_enviar_form" type="submit" value="Aceptar" name="aniadeNot">
              </form>
           </div>';
         return $salida;
    }

    function crearIdNoticia(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select id from noticias order by id desc");
         $num=$result->fetch_assoc();
         $res=$num['id'];
         $conexion->close();
         $res+=1;
         return $res;
    }

    function getFecha(){

        $fecha = getdate();
        $anio = $fecha['year'];
        $dia = $fecha['mday'];
        $mes = $fecha['mon'];
        $fech=$anio.'-'.$mes.'-'.$dia;

        return $fech;
    }

    function getAutor(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $usuario=$_SESSION['user'];
         $result=$conexion->query("select nombre,apellido1,apellido2 from usuarios where usuario='$usuario'");
         $fila=$result->fetch_assoc();
         $nombre=$fila['nombre']." ".$fila['apellido1']." ".$fila['apellido2'];

         return $nombre;
    }

    function insertarNoticia($datos){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("INSERT INTO `noticias`(`id`, `seccion`, `etiqueta`, `titular`, `subtitulo`, `entradilla`, `autor`, `fechaPublicacion`,
              `fechaModificacion`, `cuerpo`, `fotografia`, `estado`)
              VALUES ($datos[0],'$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]','$datos[9]','$datos[10]','$datos[11]')");
         if($result){
              echo '<script language="javascript">alert("Noticia agregada correctamente");</script>';
              echo '<script language="javascript"> window.location.href = "index.php?noticia='.$datos[0].'"</script>';
         }
         $conexion->close();
    }

    function mostrarformularioSeccionEliminar(){
              $salida= '
              <h1>Elige la sección</h1>
              <form method="POST" action="index.php?gestion&gNoticias&eliminarNoticia">
               <select name="seccion">
              ';

              $conexion=new Database();
              $conexion->connect();
              $conexion->query("SET NAMES 'utf8'");
              $result=$conexion->query("select principal from menu");
              if($result){
                   while ($fila = $result->fetch_assoc() ) {
                              $salida=$salida.'<option value='.$fila['principal'].'> '.$fila['principal'].'</option>';
                   }
              }
              $salida=$salida.'</select>
              <input id="boton_enviar_form" type="submit" value="Aceptar" name="seleccionSeccion">
              </form>';

              $conexion->close();
              return $salida;
     }

    function mostrarConjuntoNoticiasAEliminar($seccion){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("select id,seccion,titular,autor,fechaPublicacion,fechaModificacion,fotografia,estado from noticias where seccion='$seccion'");
        $salida="<h1 class='center'>Noticias de ".$seccion."</h1>
        <form method='POST' action='index.php?gestion&gNoticias&eliminarNoticia'>
             Introducir idNoticia: <input type='text' name='idNoticiaEliminar'/>
             <input id='boton_enviar_form' type='submit' value='Eliminar' name='NoticiaEliminada'>
        </form>
        <table class='table2'>
            <thead>
                        <tr>

                            <th scope='col' >id</th>
                            <th scope='col' >seccion</th>
                            <th scope='col' >titular</th>
                            <th scope='col' >autor</th>
                            <th scope='col' >fechaPublicacion</th>
                            <th scope='col' >fechaModificacion</th>
                            <th scope='col' >fotografia</th>
                            <th scope='col' >estado</th>
                        </tr>
                    </thead>
            <tbody>
            ";
            if($result){
                $contador=1;
                while ($fila = $result->fetch_row()) {

                     $salida= $salida. '
                           <tr>
                               <td>'.$fila[0].'</td>
                               <td>'.$fila[1].'</td>
                               <td>'.$fila[2].'</td>
                               <td>'.$fila[3].'</td>
                               <td>'.$fila[4].'</td>
                               <td>'.$fila[5].'</td>';

                              $ruta=$fila[6];

                              $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>
                              <td>$fila[7]</td>
                             </tr>";
                    $contador++;
                }
           }
           $salida=$salida . ' </tbody></table>';
           $conexion->close();
           return $salida;

    }

    function eliminarNoticia($idNoticia){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("delete from noticias where id=$idNoticia");
        if($result){
            echo '<script language="javascript">alert("Noticia eliminada correctamente");</script>';
            echo '<script language="javascript"> window.location.href = "index.php"</script>';
        }
    }

    function mostrarformularioSeccionModificar(){
              $salida= '
              <h1>Elige la sección</h1>
              <form method="POST" action="index.php?gestion&gNoticias&modificarNoticia">
               <select name="seccion">
              ';

              $conexion=new Database();
              $conexion->connect();
              $conexion->query("SET NAMES 'utf8'");
              $result=$conexion->query("select principal from menu");
              if($result){
                   while ($fila = $result->fetch_assoc() ) {
                              $salida=$salida.'<option value='.$fila['principal'].'> '.$fila['principal'].'</option>';
                   }
              }
              $salida=$salida.'</select>
              <input id="boton_enviar_form" type="submit" value="Aceptar" name="seleccionSeccion">
              </form>';

              $conexion->close();
              return $salida;
     }

    function mostrarConjuntoNoticiasAModificar($seccion){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("select id,seccion,titular,autor,fechaPublicacion,fechaModificacion,fotografia,estado from noticias where seccion='$seccion'");
        $salida="<h1 class='center'>Noticias de ".$seccion."</h1>
        <form method='POST' action='index.php?gestion&gNoticias&modificarNoticia'>
             Introducir idNoticia: <input type='text' name='idNoticiaModificar'/>
             <input id='boton_enviar_form' type='submit' value='Modificar' name='NoticiaModificar'>
        </form>
        <table class='table2'>
            <thead>
                        <tr>

                            <th scope='col' >id</th>
                            <th scope='col' >seccion</th>
                            <th scope='col' >titular</th>
                            <th scope='col' >autor</th>
                            <th scope='col' >fechaPublicacion</th>
                            <th scope='col' >fechaModificacion</th>
                            <th scope='col' >fotografia</th>
                            <th scope='col' >estado</th>
                        </tr>
                    </thead>
            <tbody>
            ";
            if($result){
                $contador=1;
                while ($fila = $result->fetch_row()) {

                     $salida= $salida. '
                           <tr>
                               <td>'.$fila[0].'</td>
                               <td>'.$fila[1].'</td>
                               <td>'.$fila[2].'</td>
                               <td>'.$fila[3].'</td>
                               <td>'.$fila[4].'</td>
                               <td>'.$fila[5].'</td>';
                               $ruta=$fila[6];
                               $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>
                               <td>$fila[7]</td>

                             </tr>";
                    $contador++;
                }
           }
           $salida=$salida . ' </tbody></table>';
           $conexion->close();
           return $salida;

    }

    function formularioParaModificarNoticia($idNoticia){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select * from noticias where id=$idNoticia");
         $fila=$result->fetch_row();
         $id=$fila[0];$seccion=$fila[1];$etiqueta=$fila[2];$titular=$fila[3];$subtitulo=$fila[4];
         $entradilla=$fila[5];$autor=$fila[6];$fechaPublicacion=$fila[7];$fechaModificacion=$fila[8];
         $cuerpo=$fila[9];$fotografia=$fila[10];$estado=$fila[11];

         $salida="<h1>Editar Noticia</h1>
         <form method='POST' action='index.php?gestion&gNoticias&modificarNoticia'>
           <p>Id: <input type='text' name='id' value=$id /></p>
           <p>Seccion: <input type='text' name='seccion' value='$seccion' /></p>
           <p>Etiqueta: <input type='text' name='etiqueta' value='$etiqueta' /></p>
           <p>Titular: <textarea rows='4' cols='40'  name='titular'>$titular</textarea></p>
           <p>subtitulo: <textarea rows='4' cols='40'  name='subtitulo'>$subtitulo</textarea></p>
           <p>Entradilla: <textarea rows='4' cols='40'  name='entradilla'>$entradilla</textarea></p>
           <p>Autor: <input type='text' name='autor' value='$autor' /></p>
           <p>fechaPublicacion: <input type='text' name='fechaPublicacion' value=$fechaPublicacion /></p>
           <p>fechaModificacion: <input type='text' name='fechaModificacion' value=$fechaModificacion/></p>
           <p>Cuerpo:<textarea rows='8' cols='100'  name='cuerpo'>$cuerpo</textarea></p>
           <p>Foto: <input type='text' name='fotografia' value='$fotografia' /></p>
           <p>Estado: <input type='text' name='estado' value='$estado' /></p>
           <input id='boton_enviar_form' type='submit' value='Modificar' name='ModificadaNoticia'>
        </form>
         ";
         $conexion->close();
         return $salida;

    }

    function actualizarNoticia($datos){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");

         /*$result=$conexion->query("UPDATE `noticias` SET `id`=$datos[0],`seccion`='$datos[1]',`etiqueta`='$datos[2]',
              `titular`='$datos[3]',`subtitulo`='$datos[4]',`entradilla`='$datos[5]',`autor`='$datos[6]',`fechaPublicacion`='$datos[7]',
              `fechaModificacion`='$datos[8]',`cuerpo`='$datos[9]',`fotografia`='$datos[10]',`estado`='$datos[11]' WHERE id=$datos[0]");*/

         $id=$datos[0];$seccion=$datos[1];$etiqueta=$datos[2];$titular=$datos[3];$subtitulo=$datos[4];
         $entradilla=$datos[5];$autor=$datos[6];$fechaPublicacion=$datos[7];$fechaModificacion=$datos[8];
         $cuerpo=$datos[9];$fotografia=$datos[10];$estado=$datos[11];

         /*$result=$conexion->query("UPDATE noticias SET id=$datos[0],seccion='$datos[1]',etiqueta='$datos[2]', titular='$datos[3]',
              subtitulo='$datos[4]',entradilla='$datos[5]',autor='$datos[6]',fechaPublicacion='$datos[7]',fechaModificacion='$datos[8]',
              cuerpo='$datos[9]', fotografia='$datos[10]', estado='$datos[11]'");*/
           $result=$conexion->query("UPDATE noticias SET id=$id,seccion='$seccion',etiqueta='$etiqueta', titular='$titular',subtitulo='$subtitulo',entradilla='$entradilla',autor='$autor',fechaPublicacion='$fechaPublicacion',fechaModificacion='$fechaModificacion',cuerpo='$cuerpo', fotografia='$fotografia', estado='$estado' WHERE id=$id");

         if($result){
              echo '<script language="javascript">alert("Noticia actualizada correctamente");</script>';
              echo '<script language="javascript"> window.location.href = "index.php?noticia='.$datos[0].'"</script>';

         }
         $conexion->close();

    }
    function mostrarformularioBuscarSeccion(){
      $salida= '
      <h1>Elige la sección</h1>
      <form method="POST" action="index.php?gestion&gNoticias&ordenarNoticia">
       <select name="seccion">
      ';

      $conexion=new Database();
      $conexion->connect();
      $conexion->query("SET NAMES 'utf8'");
      $result=$conexion->query("select principal from menu");
      if($result){
           while ($fila = $result->fetch_assoc() ) {
                      $salida=$salida.'<option value='.$fila['principal'].'> '.$fila['principal'].'</option>';
           }
      }
      $salida=$salida.'</select>
      <input id="boton_enviar_form" type="submit" value="Aceptar" name="seleccionSeccion">
      </form>';

      $conexion->close();
      return $salida;
    }


    function mostrarNoticiasSeccion($seccion){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("select id,seccion,titular,autor,fechaPublicacion,fechaModificacion,fotografia,estado from noticias where seccion='$seccion'");
        $salida="<h1 class='center'>Noticias de ".$seccion."</h1>
        <form method='POST' action='index.php?gestion&gNoticias&ordenarNoticia'>
             Introducir idNoticia: <input type='text' name='idNoticiaConsultar'/>
             <input id='boton_enviar_form' type='submit' value='Consultar' name='noticiaConsultar'>
        </form>
        <table class='table2'>
            <thead>
                        <tr>

                            <th scope='col' >id</th>
                            <th scope='col' >seccion</th>
                            <th scope='col' >titular</th>
                            <th scope='col' >autor</th>
                            <th scope='col' >fechaPublicacion</th>
                            <th scope='col' >fechaModificacion</th>
                            <th scope='col' >fotografia</th>
                            <th scope='col' >estado</th>
                        </tr>
                    </thead>
            <tbody>
            ";
            if($result){
                $contador=1;
                while ($fila = $result->fetch_row()) {

                     $salida= $salida. '
                           <tr>
                               <td>'.$fila[0].'</td>
                               <td>'.$fila[1].'</td>
                               <td>'.$fila[2].'</td>
                               <td>'.$fila[3].'</td>
                               <td>'.$fila[4].'</td>
                               <td>'.$fila[5].'</td>';
                               $ruta=$fila[6];
                               $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>
                               <td>$fila[7]</td>

                             </tr>";
                    $contador++;
                }
           }
           $salida=$salida . ' </tbody></table>';
           $conexion->close();
           return $salida;
    }

    function mostrarNoticiasCambiarEstado(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select id,seccion,etiqueta,titular,autor,fechaPublicacion,fechaModificacion,fotografia,estado from noticias");
         $salida="<h1 class='center'>Cambiar estado</h1>
         <table class='table2'>
              <thead>
                         <tr>
                             <th scope='col'></th>
                             <th scope='col' >id</th>
                             <th scope='col' >seccion</th>
                             <th scope='col' >etiqueta</th>
                             <th scope='col'>titular</th>
                             <th scope='col' >autor</th>
                             <th scope='col' >fechaPublicacion</th>
                             <th scope='col' >fechaModificacion</th>
                             <th scope='col' >fotografia</th>
                             <th scope='col' >estado</th>
                         </tr>
                     </thead>
              <tbody>
              ";

         if($result){
              $contador=1;
              while ($fila = $result->fetch_row()) {

                   $salida= $salida. '
                         <tr>
                             <td><a href="index.php?gestion&gNoticias&cambiarEstadoNoticia&not='.$contador.'"><img class="checkGestion" src="imagenes/logos/check.png"/></a></td>
                             <td>'.$fila[0].'</td>
                             <td>'.$fila[1].'</td>
                             <td>'.$fila[2].'</td>
                             <td>'.$fila[3].'</td>
                             <td>'.$fila[4].'</td>
                             <td>'.$fila[5].'</td>
                             <td>'.$fila[6].'</td>';
                             $ruta=$fila[7];

                            $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>
                            <td>$fila[8]</td>
                           </tr>";
                  $contador++;
              }
         }
         $salida=$salida . ' </tbody></table>';
         $conexion->close();
         return $salida;
    }

    function mostrarMenuCambiarEstado($idNoticia){
      $salida="
        <h2>Elige el estado</h2>
        <form method='POST' action='index.php?gestion&gNoticias&cambiarEstadoNoticia&not=$idNoticia'>
             <select name='opcion'>
                <option value='PENDIENTE'>PENDIENTE</OPTION>
                <option value='PUBLICADA'>PUBLICADA</OPTION>
                <option value='RECHAZADA'>RECHAZADA</OPTION>
            </select>
             <input id='boton_enviar_form' type='submit' value='Modificar' name='modificarEstado'>
        </form>
      ";

      return $salida;
    }

    function actualizarEstadoNoticia($idNoticia,$estado){
      $conexion=new Database();
      $conexion->connect();
      $conexion->query("SET NAMES 'utf8'");
      $result=$conexion->query("UPDATE noticias SET estado='$estado' WHERE id=$idNoticia");
      echo "<h1>".$conexion->connection->error."</h1>";
      if($result){
        echo '<script language="javascript">alert("Estado modificado correctamente");</script>';
        echo '<script language="javascript"> window.location.href = "index.php?gestion&gNoticias&cambiarEstadoNoticia"</script>';
      }

    }
    /*------------------------publicidad--------------------*/
    function mostrarPublicidad(){
              $database= new Database();
              $database->connect();
              $resultado=$database->query("SELECT * FROM publicidad");

               $salida='<div id="publicidad">';
               for($a=0;$a<4;$a++){
                    $publi=$resultado->fetch_assoc();
               if (!is_null($publi)){
                    $salida = $salida . '<div class="adv">

                                         <a  href="php/actualizador.php?ruta='.$publi['ruta'].'"><img src="'.$publi['ruta'].'" alt="adv" class="advs" /></a>
                                         <p class="text-publi"> '.$publi['texto'].' </p>
                                         </div>';
                                    }
                }
                $salida = $salida . '</div>';

               $database->close();
               return $salida;
    }

    function mostrarGestorPublicidad(){
              return "
              <div class='menu_gestor'>
               <h1>Gestor de publicidades</h1>
               <a class='enlace_gestorespec' href='index.php?gestion&gPublicidad&InsertarPub'><p>1. Insertar publicidad</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gPublicidad&eliminarPub'><p>2. Eliminar publicidad</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gPublicidad&modificarPub'><p>3. Modificar publicidad</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gPublicidad&verPub'><p>4. Ver publicidades</p></a>
               </div>
              ";
    }

    function formularioInsertarPublicidad(){
         return '
                   <form id="form_publi" method="POST" action="index.php?gestion&gPublicidad&InsertarPub">
                   <fieldset>
                        <legend class="nombre_form">Insertar nueva publicidad</legend>

                        <div class="form_publi">
                             <label for="id">ID de la publicidad:</label>
                             <input type="text" id="id" name="id_publicidad" />
                        </div>

                        <div class="form_publi">
                             <label for="ruta">Ruta de la imagen:</label>
                             <input type="text" id="ruta" name="ruta_publicidad" />
                        </div>

                        <div class=form_publi>
                             <label for="msg">Texto de la publicidad:</label>
                             <input type="text" name="texto_publicidad" />
                        </div>

                        <div class="button">
                             <button id="boton_enviar_form" type="submit" name="enviarpublicidad" >Subir datos</button>
                        </div>

                   </fieldset>
                   </form>
            ';
    }

    function insertarPublicidad($id,$ruta,$texto){
       $conexion=new Database();
       $conexion->connect();
       $conexion->query("SET NAMES 'utf8'");
       $result=$conexion->query("INSERT INTO `publicidad`(`id`,`ruta`,`texto`) VALUES ('$id','$ruta','$texto')");
       if($result){
         echo '<script language="javascript">alert("publicidad insertado correctamente");</script>';
         echo '<script language="javascript"> window.location.href = "index.php?gestion&gPublicidad&verPub"</script>';
       }
       else{
            echo '<script language="javascript">alert("Fallo al insertar los datos");</script>';
            echo '<script language="javascript"> window.location.href = "index.php?gestion&gPublicidad&verPub"</script>';
       }

       $conexion->close();
    }

    function formularioEliminarPublicidad(){
         return '
                   <form id="form_publi" method="POST" action="index.php?gestion&gPublicidad&eliminarPub">
                   <fieldset>
                        <legend class="nombre_form">Eliminar una publicidad</legend>

                        <div class="form_publi">
                             <label for="id">ID de la publicidad a eliminar:</label>
                             <input type="text" id="id" name="id_publicidad" />
                        </div>

                        <div class="button">
                             <button id="boton_enviar_form" type="submit" name="eliminarpublicidad" >Eliminar publicidad</button>
                        </div>

                   </fieldset>
                   </form>
            ';
    }

    function eliminarPublicidad($id){
       $conexion=new Database();
       $conexion->connect();
       $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("delete from publicidad where id = '$id'");
       if($result){
         echo '<script language="javascript">alert("publicidad eliminado correctamente");</script>';
         echo '<script language="javascript"> window.location.href = "index.php?gestion&gPublicidad&verPub"</script>';
       }
       else{
            echo '<script language="javascript">alert("Fallo al eliminar los datos");</script>';
            echo '<script language="javascript"> window.location.href = "index.php?gestion&gPublicidad&verPub"</script>';
       }
         $conexion->close();
    }

    function mostrarPublicidadesAEliminar(){
       $conexion=new Database();
       $conexion->connect();
       $conexion->query("SET NAMES 'utf8'");
       $result=$conexion->query("select id,ruta,texto,contador from publicidad");
       $salida="
       <table class='table3'>
            <thead>
                        <tr>

                            <th scope='col' >id</th>
                            <th scope='col' >texto</th>
                            <th scope='col' >contador</th>
                            <th scope='col' >iamgen</th>

                        </tr>
                    </thead>
            <tbody>
            ";
            if($result){
                $contador=1;
                while ($fila = $result->fetch_row()) {

                     $salida= $salida. '
                           <tr>
                               <td>'.$fila[0].'</td>
                               <td>'.$fila[2].'</td>
                               <td>'.$fila[3].'</td>';

                              $ruta=$fila[1];

                              $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>

                             </tr>";
                    $contador++;
                }
           }
           $salida=$salida . ' </tbody></table>';
           $conexion->close();
           return $salida;

    }


    function formularioModificarPublicidad(){
         return '
                   <form id="form_publi" method="POST" action="index.php?gestion&gPublicidad&modificarPub">
                   <fieldset>
                        <legend class="nombre_form">Eliminar una publicidad</legend>

                        <div class="form_publi">
                             <label for="id">ID de la publicidad a modificar:</label>
                             <input type="text" id="id" name="id_publicidad" />
                        </div>

                        <div class="form_publi">
                             <label for="ruta">Nueva ruta de la imagen:</label>
                             <input type="text" id="ruta" name="ruta_publicidad" />
                        </div>

                        <div class=form_publi>
                             <label for="msg">Nuevo texto de la publicidad:</label>
                             <input type="text" name="texto_publicidad" />
                        </div>

                        <div class="button">
                             <button id="boton_enviar_form" type="submit" name="modificarpublicidad" >Modificar publicidad</button>
                        </div>

                   </fieldset>
                   </form>
            ';
    }

    function modificarPublicidad($id,$ruta,$texto){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("Update publicidad Set ruta='$ruta',texto='$texto' where id='$id'");
           if($result){
            echo '<script language="javascript">alert("publicidad modificado correctamente");</script>';
            echo '<script language="javascript"> window.location.href = "index.php?gestion&gPublicidad&verPub"</script>';
       }
       else{
            echo '<script language="javascript">alert("Fallo al modificar los datos");</script>';
            echo '<script language="javascript"> window.location.href = "index.php?gestion&gPublicidad&verPub"</script>';
       }
         $conexion->close();
    }


    function mostrarPublicidadesParaModificar(){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("select id,ruta,texto,contador from publicidad");
         $salida="<h1 class='center'>Modificar Publicidad</h1>
         <table class='table3'>
              <thead>
                         <tr>
                             <th scope='col' >id</th>
                             <th scope='col' >texto</th>
                             <th scope='col' >contador</th>
                             <th scope='col'>imagen</th>
                         </tr>
                     </thead>
              <tbody>
              ";

         if($result){
              $contador=1;
              while ($fila = $result->fetch_row()) {

                   $salida= $salida. '
                         <tr>
                             <td>'.$fila[0].'</td>
                             <td>'.$fila[2].'</td>
                             <td>'.$fila[3].'</td>';
                             $ruta=$fila[1];

                            $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>

                           </tr>";
                  $contador++;
              }
         }
         $salida=$salida . ' </tbody></table>';
         $conexion->close();
         return $salida;
    }


    function mostrarPublicidades(){
        $conexion=new Database();
        $conexion->connect();
        $conexion->query("SET NAMES 'utf8'");
        $result=$conexion->query("select id,ruta,texto,contador from publicidad");
        $salida="<h1 class='center'>Ver Publicidades</h1>
        <table class='table3'>
             <thead>
                        <tr>
                            <th scope='col' >id</th>
                            <th scope='col' >texto</th>
                            <th scope='col' >contador</th>
                            <th scope='col' >imagen</th>
                        </tr>
                    </thead>
             <tbody>
             ";

             if($result){
                  while ($fila = $result->fetch_row()) {
                       $salida= $salida. '
                             <tr>
                                 <td>'.$fila[0].'</td>
                                 <td>'.$fila[2].'</td>
                                 <td>'.$fila[3].'</td>';
                                 $ruta=$fila[1];

                                $salida = $salida. "<td><img src='$ruta' class='imgNoticiaGestion'/></td>

                              </tr>";
                  }
             }
             $salida=$salida . ' </tbody></table>';
             $conexion->close();
             return $salida;
    }


    /*---------------------gestor secciones-------------------------*/
    function mostrarGestorSeccion(){
              return "
              <div class='menu_gestor'>
               <h1>Gestor de Secciones</h1>
               <a class='enlace_gestorespec' href='index.php?gestion&gSecciones&InsertarSec'><p>1. Insertar nueva seccion</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gSecciones&eliminarSec'><p>2. Eliminar una seccion</p></a>
               <a class='enlace_gestorespec' href='index.php?gestion&gSecciones&modificarSec'><p>3. Modificar una seccion</p></a>
               </div>
              ";
    }

    function insertarSeccion($principal){
       $conexion=new Database();
       $conexion->connect();
       $conexion->query("SET NAMES 'utf8'");
       $result=$conexion->query("INSERT INTO `menu`(`principal`) VALUES ('$principal')");
       if($result){
         echo '<script language="javascript">alert("seccion insertado correctamente");</script>';
         echo '<script language="javascript"> window.location.href = "index.php"</script>';
       }
       else{
            echo '<script language="javascript">alert("Fallo al insertar los datos");</script>';
            echo '<script language="javascript"> window.location.href = "index.php"</script>';
       }

       $conexion->close();
    }

    function formularioInsertarSeccion(){
         return '
                   <form id="form_publi" method="POST" action="index.php?gestion&gSecciones&InsertarSec">
                   <fieldset>
                        <legend class="nombre_form">Insertar una seccion</legend>

                        <div class="form_publi">
                             <label for="seccion_principal">Nombre de la seccion a insertar:</label>
                             <input type="text" id="principal" name="seccion_principal" />
                        </div>

                        <div class="button">
                             <button id="boton_enviar_form" type="submit" name="insertarseccion" >Insertar seccion</button>
                        </div>

                   </fieldset>
                   </form>
            ';
    }

    function formularioEliminarSeccion(){
         return '
                   <form id="form_publi" method="POST" action="index.php?gestion&gSecciones&eliminarSec">
                   <fieldset>
                        <legend class="nombre_form">Eliminar una seccion</legend>

                        <div class="form_publi">
                             <label for="nombre_seccion">Nombre de la seccion a eliminar:</label>
                             <input type="text" id="nombre" name="nombre_seccion" />
                        </div>

                        <div class="button">
                             <button id="boton_enviar_form" type="submit" name="eliminarseccion" >Eliminar seccion</button>
                        </div>

                   </fieldset>
                   </form>
            ';
    }

    function eliminarSeccion($nombre){
       $conexion=new Database();
       $conexion->connect();
       $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("delete from menu where principal = '$nombre'");
       if($result){
         echo '<script language="javascript">alert("seccion eliminado correctamente");</script>';
         echo '<script language="javascript"> window.location.href = "index.php"</script>';
       }
       else{
            echo '<script language="javascript">alert("Fallo al eliminar los datos");</script>';
            echo '<script language="javascript"> window.location.href = "index.php"</script>';
       }
         $conexion->close();
    }

    function formularioModificarSeccion(){
         return '
                   <form id="form_publi" method="POST" action="index.php?gestion&gSecciones&modificarSec">
                   <fieldset>
                        <legend class="nombre_form">Modificar una seccion</legend>

                        <div class="form_publi">
                             <label for="nombre_original">Nombre de la seccion a modificar:</label>
                             <input type="text" id="nombre_o" name="nombre_original" />
                        </div>

                        <div class="form_publi">
                             <label for="nombre_nuevo">Nuevo nombre de la seccion:</label>
                             <input type="text" id="Nombre_n" name="nombre_nuevo" />
                        </div>

                        <div class="button">
                             <button id="boton_enviar_form" type="submit" name="modificarseccion" >Modificar seccion</button>
                        </div>

                   </fieldset>
                   </form>
            ';
    }

    function modificarSeccion($nombre_original,$nombre_nuevo){
         $conexion=new Database();
         $conexion->connect();
         $conexion->query("SET NAMES 'utf8'");
         $result=$conexion->query("Update menu Set principal='$nombre_nuevo' where principal='$nombre_original'");
           if($result){
            echo '<script language="javascript">alert("seccion modificado correctamente");</script>';
            echo '<script language="javascript"> window.location.href = "index.php"</script>';
       }
       else{
            echo '<script language="javascript">alert("Fallo al modificar los datos");</script>';
            echo '<script language="javascript"> window.location.href = "index.php"</script>';
       }
         $conexion->close();
    }

 }
?>
