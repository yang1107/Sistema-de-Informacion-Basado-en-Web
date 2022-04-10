<?php
include_once('database.php');
$conexion=new Database();
$conexion->connect();
$conexion->query("SET NAMES 'utf8'");
$ruta=$_GET['ruta'];
$sal= $conexion->query("select id,contador from publicidad where ruta='$ruta'");

$sal2=$sal->fetch_assoc();
$id=$sal2['id'];
$contador_nuevo=$sal2['contador']+1;
$result=$conexion->query("Update publicidad Set contador='$contador_nuevo' where id='$id'");

if($result){
echo '<script language="javascript"> window.location.href = "../index.php"</script>';
}
$conexion->close();
 ?>
