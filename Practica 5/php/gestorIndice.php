<?php

class GestorIndice{
    public $gestorSecciones;

    function GestorIndice(){
       $this->gestorSecciones=new GestorSeccion();
    }

    function getPortada($enlace){
        include($enlace);

    }

    function get($enlace){
       include($enlace);

    }
    function getSeccion($seccion){
         return  $this->gestorSecciones->getSeccion($seccion);
    }
}
?>
