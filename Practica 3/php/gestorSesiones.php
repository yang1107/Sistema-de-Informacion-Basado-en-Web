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

    function compruebaUsuario($usuario,$password){
         $database= new Database();

         $database->connect();
         $result=$database->query("select * from usuarios where usuario='".$usuario."' AND password='".$password."'");
         $comprobar=mysqli_num_rows($result);
         if($comprobar > 0){
               $_SESSION['user']=$usuario;
               echo '<script language="javascript">alert("Bienvenido'.$usuario.'");</script>';
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
