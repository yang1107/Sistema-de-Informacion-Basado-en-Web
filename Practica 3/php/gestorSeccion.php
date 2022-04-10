<?php
class GestorSeccion{

    function GestorSeccion(){

    }

    function getSeccion($seccion){
      $noticias=new GestorNoticias();
      return $noticias->getNoticiasSeccion($seccion);
    }

    
}
?>
