<?php
if(isset($_GET['compartir'])){
     $titular = htmlspecialchars($_GET['titular']);
     $via = "Via @Diariodeportivo";
     $imagen = htmlspecialchars($_GET['imagen']);

     echo "<h1>" . $titular . "</h1>";
     echo "<p>" . $via . "</p>";
     echo "<img src='$imagen' />";
}
?>
