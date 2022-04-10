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
          include_once('php/GestorContenidos.php');


          $gestorIndice=new GestorIndice();
          $gestorNoticias=new GestorNoticias();
          $gestorSesiones=new GestorSesiones();
          $gestorContenidos=new GestorContenidos();


          $gestorIndice->get('php/head.php');


     echo '<body onscroll="cierraSugerencias()">
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
                else if(isset($_GET['gestion'])&& ($gestorContenidos->comprobarSiEsJefe() || $gestorContenidos->comprobarSiEsRedactor())){
                         if(isset($_GET['gComentarios']) && $gestorContenidos->comprobarSiEsJefe()){
                              if(isset($_GET['Insertar'])){
                                   if(isset($_GET['not'])){
                                        if(isset($_POST['enviarcomentario'])){
                                             $texto=$_POST['text_comentario'];
                                             $idNoticia=$_GET['not'];
                                             $gestorNoticias->insertaComentario($texto,$idNoticia);
                                        }
                                        else{
                                             $idNoticia=$_GET['not'];
                                             echo $gestorContenidos->formularioInsertarComentario($idNoticia);
                                        }
                                   }
                                   else{
                                        echo $gestorContenidos->mostrarNoticiasDisponiblesParaInsertarComentario();
                                   }
                              }



                              else if(isset($_GET['eliminar'])){
                                   if(isset($_GET['not'])){
                                        $idNoticia=$_GET['not'];
                                        if(isset($_POST['eliminarComentario'])){
                                             $idComentario=$_POST['idComentarioBorrar'];
                                             $idNoticia=$_POST['hid'];
                                             $gestorContenidos->eliminarComentario($idNoticia,$idComentario);
                                        }
                                        else{
                                             echo $gestorContenidos->mostrarComentariosNoticia($idNoticia);
                                        }
                                   }
                                   else{
                                        echo $gestorContenidos->mostrarNoticiasDisponiblesParaEliminarComentario();
                                   }
                              }


                              else if(isset($_GET['modificar'])){
                                   if(isset($_GET['not'])){
                                        $idNoticia=$_GET['not'];
                                        if(isset($_POST['modificarComentario'])){
                                             $idComentario=$_POST['idComentarioModificar'];
                                             $idNoticia=$_POST['hid'];
                                             echo $gestorContenidos->modificarDatosComentario($idNoticia,$idComentario);
                                        }
                                        else if(isset($_POST['enviarcomentario'])){
                                             $idNoticia=$_POST['idn'];
                                             $idComentario=$_GET['idc'];
                                             $texto=$_POST['text_comentario'];
                                             $gestorContenidos->modificarComentario($idNoticia,$idComentario,$texto);
                                        }

                                        else{
                                             echo $gestorContenidos->mostrarComentariosNoticiaAModificar($idNoticia);
                                        }

                                   }
                                   else{
                                        echo $gestorContenidos->mostrarNoticiasDisponiblesParaModificarComentario();
                                   }
                              }


                              else if(isset($_GET['verComentarios'])){
                                   if(isset($_GET['not'])){
                                        $idNoticia=$_GET['not'];
                                        echo $gestorContenidos->mostrarComentariosNoticiaAObservar($idNoticia);
                                   }
                                   else{
                                        echo $gestorContenidos->mostrarNoticiasDisponiblesParaObservarComentario();
                                   }


                              }

                              else{
                                   echo $gestorContenidos->mostrarGestorComentarios();
                              }

                         }
                         else if(isset($_GET['gNoticias'])&& ($gestorContenidos->comprobarSiEsJefe() || $gestorContenidos->comprobarSiEsRedactor())){

                              if(isset($_GET['aniadeNoticia'])){
                                   if(isset($_POST['seleccionSeccion'])){
                                        $seccion=$_POST['seccion'];
                                        echo $gestorContenidos->formularioInsertarNoticia($seccion);
                                   }
                                   else if(isset($_POST['aniadeNot'])){
                                        $id=$gestorContenidos->crearIdNoticia(); $autor=$gestorContenidos->getAutor();
                                        $titular=$_POST['titular'];$subtitulo=$_POST['subtitulo'];
                                        $entradilla=$_POST['entradilla'];$cuerpo=$_POST['cuerpo'];
                                        $foto=$_POST['foto']; $estado="PENDIENTE";
                                        $seccion=$_GET['secc'];$etiqueta=$_POST['etiqueta'];
                                        $fecha=$gestorContenidos->getFecha();
                                        $datos[0]=$id;$datos[1]=$seccion;$datos[2]=$etiqueta;$datos[3]=$titular;
                                        $datos[4]=$subtitulo;$datos[5]=$entradilla;$datos[6]=$autor;$datos[7]=$fecha;
                                        $datos[8]=$fecha;$datos[9]=$cuerpo;$datos[10]=$foto;$datos[11]=$estado;

                                        $gestorContenidos->insertarNoticia($datos);

                                   }
                                   else{
                                        echo $gestorContenidos->mostrarformularioSeccion();
                                   }
                              }
                              else if(isset($_GET['eliminarNoticia'])&& ($gestorContenidos->comprobarSiEsJefe())){
                                   if(isset($_POST['seleccionSeccion'])){
                                        $seccion=$_POST['seccion'];
                                        echo $gestorContenidos->mostrarConjuntoNoticiasAEliminar($seccion);
                                   }
                                   else if(isset($_POST['NoticiaEliminada'])){
                                        $idNoticia=$_POST['idNoticiaEliminar'];
                                        $gestorContenidos->eliminarNoticia($idNoticia);
                                   }
                                   else{
                                        echo $gestorContenidos->mostrarformularioSeccionEliminar();
                                   }
                              }

                              else if(isset($_GET['modificarNoticia'])&& ($gestorContenidos->comprobarSiEsJefe())){

                                   if(isset($_POST['seleccionSeccion'])){
                                        $seccion=$_POST['seccion'];
                                        echo $gestorContenidos->mostrarConjuntoNoticiasAModificar($seccion);
                                   }

                                   else if(isset($_POST['NoticiaModificar'])){
                                        $idNoticia=$_POST['idNoticiaModificar'];
                                        $fecha=$gestorContenidos->getFecha();
                                        echo $gestorContenidos->formularioParaModificarNoticia($idNoticia,$fecha);
                                   }

                                   else if(isset($_POST['ModificadaNoticia'])){
                                        $id=$_POST['id'];$seccion=$_POST['seccion'];$etiqueta=$_POST['etiqueta'];$titular=$_POST['titular'];$subtitulo=$_POST['subtitulo'];
                                        $entradilla=$_POST['entradilla'];$autor=$_POST['autor'];$fechaPublicacion=$_POST['fechaPublicacion'];$fechaModificacion=$_POST['fechaModificacion'];
                                        $cuerpo=$_POST['cuerpo'];$fotografia=$_POST['fotografia'];$estado=$_POST['estado'];
                                        $datos[0]=$id;$datos[1]=$seccion;$datos[2]=$etiqueta;$datos[3]=$titular;$datos[4]=$subtitulo;$datos[5]=$entradilla;$datos[6]=$autor;
                                        $datos[7]=$fechaPublicacion;$datos[8]=$fechaModificacion;$datos[9]=$cuerpo;$datos[10]=$fotografia;$datos[11]=$estado;

                                        $gestorContenidos->actualizarNoticia($datos);
                                   }
                                   else{
                                        echo $gestorContenidos->mostrarformularioSeccionModificar();
                                   }
                              }
                              else if(isset($_GET['ordenarNoticia'])&& ($gestorContenidos->comprobarSiEsJefe())){
                                   if(isset($_POST['seleccionSeccion'])){
                                     $seccion=$_POST['seccion'];
                                     echo $gestorContenidos->mostrarNoticiasSeccion($seccion);
                                   }
                                   else if(isset($_POST['noticiaConsultar'])){
                                      $idNoticia=$_POST['idNoticiaConsultar'];
                                      header('location:index.php?noticia='.$idNoticia.' ');
                                   }
                                   else{
                                        echo $gestorContenidos->mostrarformularioBuscarSeccion();
                                   }
                              }
                              else if(isset($_GET['cambiarEstadoNoticia'])&& ($gestorContenidos->comprobarSiEsJefe())){
                                  if(isset($_POST['modificarEstado'])){
                                    $estado=$_POST['opcion'];
                                    $idNoticia=$_GET['not'];
                                    $gestorContenidos->actualizarEstadoNoticia($idNoticia,$estado);
                                  }
                                  else if(isset($_GET['not'])){
                                    $idNoticia=$_GET['not'];
                                    echo $gestorContenidos->mostrarMenuCambiarEstado($idNoticia);
                                  }
                                  else{
                                    echo $gestorContenidos->mostrarNoticiasCambiarEstado();
                                  }

                              }

                              else{
                                   echo $gestorContenidos->mostrarGestorNoticias();
                              }
                         }
                         else if(isset($_GET['gPublicidad'])&& $gestorContenidos->comprobarSiEsJefe()){
                              if(isset($_GET['InsertarPub'])){
                                   if(isset($_POST['enviarpublicidad'])){
                                        $id=$_POST['id_publicidad'];
                                        $ruta=$_POST['ruta_publicidad'];
                                        $texto=$_POST['texto_publicidad'];
                                        $gestorContenidos->insertarPublicidad($id,$ruta,$texto);
                                   }
                                   else{
                                        echo $gestorContenidos->formularioInsertarPublicidad();
                                   }
                              }

                              else if(isset($_GET['eliminarPub'])){
                                   if(isset($_POST['eliminarpublicidad'])){
                                        $id=$_POST['id_publicidad'];
                                        $gestorContenidos->eliminarPublicidad($id);
                                   }
                                   else{
                                        echo $gestorContenidos->formularioEliminarPublicidad();
                                        echo $gestorContenidos->mostrarPublicidadesAEliminar();
                                   }
                              }

                              else if(isset($_GET['modificarPub'])){
                                   if(isset($_POST['modificarpublicidad'])){
                                        $id=$_POST['id_publicidad'];
                                        $ruta=$_POST['ruta_publicidad'];
                                        $texto=$_POST['texto_publicidad'];
                                        $gestorContenidos->modificarPublicidad($id,$ruta,$texto);
                                   }
                                   else{
                                        echo $gestorContenidos->formularioModificarPublicidad();
                                        echo $gestorContenidos->mostrarPublicidadesParaModificar();
                                   }
                              }

                              else if(isset($_GET['verPub'])){
                                   echo $gestorContenidos->mostrarPublicidades();
                              }

                              else{
                                   echo $gestorContenidos->mostrarGestorPublicidad();
                              }
                         }
                         else if(isset($_GET['gSecciones'])&& $gestorContenidos->comprobarSiEsJefe()){
                              if(isset($_GET['InsertarSec'])){
                                   if(isset($_POST['insertarseccion'])){
                                        $nombre=$_POST['seccion_principal'];
                                        $gestorContenidos->insertarSeccion($nombre);
                                   }
                                   else{
                                        echo $gestorContenidos->formularioInsertarSeccion();
                                   }
                              }

                              else if(isset($_GET['eliminarSec'])){
                                   if(isset($_POST['eliminarseccion'])){
                                        $nombre=$_POST['nombre_seccion'];
                                        $gestorContenidos->eliminarSeccion($nombre);
                                   }
                                   else{
                                        echo $gestorContenidos->formularioEliminarSeccion();
                                   }
                              }

                              else if(isset($_GET['modificarSec'])){
                                   if(isset($_POST['modificarseccion'])){
                                        $nombre_o=$_POST['nombre_original'];
                                        $nombre_n=$_POST['nombre_nuevo'];
                                        $gestorContenidos->modificarseccion($nombre_o,$nombre_n);
                                   }
                                   else{
                                        echo $gestorContenidos->formularioModificarSeccion();
                                   }
                              }


                              else{
                                   echo $gestorContenidos->mostrarGestorSeccion();
                              }
                         }
                         else if(isset($_GET['gOrganizadorInicio'])&& $gestorContenidos->comprobarSiEsJefe()){

                         }
                }
                else if(isset($_GET['registrarse'])){

                     if(isset($_POST['enviarRegistro'])){
                          $usuario=$_POST['usuario'];
                          $password=md5($_POST['password']);
                          $nombre=$_POST['nombre'];
                          $apellido1=$_POST['apellido1'];
                          $apellido2=$_POST['apellido2'];
                          $correo=$_POST['correo'];
                          $tipoUsuario=$_POST['tipo'];

                          $gestorSesiones->creaUsuario($usuario,$password,$nombre,$apellido1,$apellido2,$correo,$tipoUsuario);
                     }

                     else{
                          echo $gestorSesiones->getFormularioRegistro();
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
