<!DOCTYPE html>
<html>
<head>
     <link rel="stylesheet" type="text/css" href="../../css/main_css.css" />
     <meta charset="UTF-8">
     <meta name="author" content="Jonathan Martín Valera y Yang Chen">
     <title>Imprimir noticia</title>
</head>

<body>


               <div id="ima_log">
                    <img alt="Diario Deportivo"  id="logo" src="../../imagenes/logos/logo.png"/>
               </div>
     

     <?php
          include_once('../gestorNoticias.php');
          include_once('../database.php');

          if(isset($_GET['noticia'])){
               $id = htmlspecialchars($_GET['noticia']);
               $gestorNoticias = new GestorNoticias();
               $noticia = $gestorNoticias->getNoticiaImp($id, "../../");
               echo $noticia;
          }else{
               echo "Error ID incorrecto...";
          }
     ?>
</body>

</html>
