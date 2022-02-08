<?php
// Variables de sesión complementarias al tema del login
$_SESSION['bllogin'] = false;
$_SESSION['tipo'] = 'Invitado';

//Comporbación de cookies en caso de variables de sesión vacia, esto mantiene la sesión lo que duren las cookies
if(!empty($_COOKIE['user']) && !empty($_COOKIE['pass']) && (empty($_SESSION['usuario']) || empty($_SESSION['password']))){
    $_SESSION['usuario'] = $_COOKIE['user'];
    $_SESSION['password'] = $_COOKIE['pass'];
}

//Comprobación de sesión por cada carga de la página de los credenciales
if(!empty($_SESSION['usuario']) && !empty($_SESSION['password'])){

    // Dependiendo de la ruta se carga un fichero u otro
    if(preg_match('/^con-mysql$/i',basename(__DIR__)) == 1){
        require_once 'credencials.php';
    }else{
        require_once 'php/con-mysql/credencials.php';
    }


// Sentencias
try {
        // Conexion
        $loginCheck = new PDO('mysql:host=localhost;dbname=escuela', $user_db, $pass_db);
        
        //Consulta
        $sqlLoginCheck = 'SELECT `usuario`,`clave`,`tipo` FROM `usuarios` WHERE `usuario`=:usuario AND `clave`=:pass';
        $sentenciaLoginCheck = $loginCheck->prepare($sqlLoginCheck); 
        $sentenciaLoginCheck->bindParam(':usuario', $_SESSION['usuario']);
        $sentenciaLoginCheck->bindParam(':pass', $_SESSION['password']);
        $resultadoLoginCheck = $sentenciaLoginCheck->execute();
        $resultadoDatosLoginCheck = $sentenciaLoginCheck->fetchAll();

        // Se comprueba si se ejecuto bien la sentencia sql
        if($resultadoLoginCheck){ 
            // Comprobar si existen las credenciales coincidentes en la base de datos
            if($_SESSION['usuario'] == $resultadoDatosLoginCheck[0]['usuario'] && $_SESSION['password'] == $resultadoDatosLoginCheck[0]['clave']){

                $_SESSION['bllogin'] = true;
                $_SESSION['tipo'] = $resultadoDatosLoginCheck[0]['tipo'];

            }else{
                header('Location: php/logout.php');
            }
        }
        else{ 
            echo "Algo salió mal. Por favor verifica que la tabla exista";
            header('Location: php/logout.php');
        }

    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
        header('Location: php/logout.php');
    }

    if(!$_SESSION['bllogin']) header('Location: php/logout.php');
}
?>