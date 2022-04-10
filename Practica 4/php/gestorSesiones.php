<?php

class GestorSesiones{


    function GestorSesiones(){
    }

    function getLogin(){
        return "<div id='login'>
          <div id='cabecera_form'>
          <h2 id='titulo_login'>LOG IN</h2>
          </div>
          <form method='POST' action='#'>
            <fieldset id='cuerpo_form'>

              <p class='p_form'><label class='titulo_form'>Usuario</label></p>
              <p class='input_p'><input class='input_form' type='text' id='email' name='usuario'/></p>

              <p class='p_form'>Password</p>
              <p class='input_p'><input class='input_form' type='password' id='password' name='password' /></p>
              <p><input class='input_submit' type='submit' value='Entrar' name='enviar'></p>

            </fieldset>
      </div> ";
    }
    function getFormularioRegistro(){
        return "<div id='login'>
          <div id='cabecera_form'>
          <h2 id='titulo_login'>Registrarse</h2>
          </div>
          <form method='POST' action='#'>
            <fieldset id='cuerpo_form'>

              <p class='p_form'><label class='titulo_form'>Usuario</label></p>
              <p class='input_p'><input class='input_form' type='text' id='email' name='usuario'/></p>

              <p class='p_form'>Password</p>
              <p class='input_p'><input class='input_form' type='password' id='password' name='password' /></p>

             <p class='p_form'>Vuelve a introducir Password</p>
             <p class='input_p'><input class='input_form' type='password' id='password' name='password' /></p>

              <p class='p_form'><label class='titulo_form'>Nombre</label></p>
              <p class='input_p'><input class='input_form' type='text' id='email' name='nombre'/></p>

              <p class='p_form'><label class='titulo_form'>Primer apellido</label></p>
              <p class='input_p'><input class='input_form' type='text' id='email' name='apellido1'/></p>

              <p class='p_form'><label class='titulo_form'>Segundo apellido</label></p>
              <p class='input_p'><input class='input_form' type='text' id='email' name='apellido2'/></p>

              <p class='p_form'><label class='titulo_form'>Correo electrónico</label></p>
              <p class='input_p'><input class='input_form' type='text' id='email' name='correo'/></p>

             <p class='p_form'>
              Introduce el tipo de usuario<br/>
               <select name='tipo'>
                    <option value='Redactor'>Redactor</option>
                    <option value='Jefe'>Editor jefe</option>
                    <option value='Normal'>Usuario normal</option>
               </select>
            </p>

              <p><input class='input_submit' type='submit' value='Enviar' name='enviarRegistro'></p>

            </fieldset>
      </div> ";
    }

    function creaUsuario($usuario,$password,$nombre,$apellido1,$apellido2,$correo,$tipoUsuario){
         $database= new Database();
         $database->connect();
         $insert = "INSERT INTO usuarios (`usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `correoElectronico`, `rol`)
                                            VALUES ('$usuario', '$password', '$nombre', '$apellido1', '$apellido2', '$correo', '$tipoUsuario')";
         $result = $database->query($insert);
        // $result=$database->query("INSERT INTO `usuarios`(`usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `correoElectronico`, `rol`) VALUES ('kk','','','','','','')");

         echo '<script language="javascript">alert("Creado el usuario correctamente");</script>';
         echo '<script language="javascript"> window.location.href = "index.php"</script>';


        $database->close();
    }


    function compruebaUsuario($usuario,$password){
         $database= new Database();

         $database->connect();
         $result=$database->query("select * from usuarios where usuario='".$usuario."' AND password='".$password."'");
         $comprobar=mysqli_num_rows($result);
         if($comprobar > 0){
               $_SESSION['user']=$usuario;
               echo '<script language="javascript">alert("Bienvenido '.$usuario.'");</script>';
               echo '<script language="javascript"> window.location.href = "index.php"</script>';
         }
         else{
             echo '<script language="javascript">alert("USUARIO O PASSWORD INCORRECTO, VUELVA A INTENTARLO");</script>';
             echo '<script language="javascript"> window.location.href = "index.php?login"</script>';

         }
         $database->close();
    }
    function desconectar(){
         session_destroy();
         unset($_SESSION['user']);
         echo '<script language="javascript">alert("Has sido desconectado de su sesión");</script>';
         echo '<script language="javascript"> window.location.href = "index.php"</script>';
    }
}
?>
