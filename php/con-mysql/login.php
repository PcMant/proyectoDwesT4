<?php
require_once 'credencials.php';

// Parámetros
$usuario = !empty($_GET['usuario']) ? trim($_GET['usuario']) : '';
$password = !empty($_GET['password']) ? trim(sha1($_GET['password'])) : '';
$mantenerSesion = !empty($_GET['mantener-sesion']) ? $_GET['mantener-sesion'] : '';

// Se comprueba si se introdujo usuario y contraseña
if(empty($usuario) || empty($password)){
    header('Location: ../../login.php?login=false');
}else{
     // Sentencias
     try {
        // Conexion
        $login = new PDO("mysql:host=$host_db;port=$port_db;dbname=$database;charset=utf8", $user_db, $pass_db);
        
        //Consulta
        $sql = 'SELECT `usuario`,`clave` FROM `usuarios` WHERE `usuario`=:usuario AND `clave`=:pass';
        $sentencia = $login->prepare($sql); 
        $sentencia->bindParam(':usuario', $usuario);
        $sentencia->bindParam(':pass', $password);
        $resultado = $sentencia->execute();
        $resultadoDatos = $sentencia->fetchAll();

        //var_dump($resultadoDatos);
    
        // Se notifica con alerta si se proceso bien la sentencia sql
        if($resultado){ 
            // Comprobar si existen las credenciales coincidentes en la base de datos
            if(preg_match("/^$usuario$/",$resultadoDatos[0]['usuario']) && preg_match("/^$password$/",$resultadoDatos[0]['clave'])){

                session_start(); 

                $_SESSION['usuario'] = $usuario;
                $_SESSION['password'] = $password;

                $login = null;
                echo "Insertado correctamente";

                //Cokies para mantener sesión en caso de requerirlo
                if(!empty($mantenerSesion) || $mantenerSesion == 'on'){
                    setcookie('user', $usuario, time()+(60*60*24*365), '/', 'localhost');
                    setcookie('pass', $password, time()+(60*60*24*365), '/', 'localhost');
                }

                //Redirección con la alerta de login ok
                header('Location: ../../index.php?pagina=1&login=true');
            }else{
                $login = null;
                header('Location: ../../login.php?login=false');
            }
        }
        else{ 
            $login = null;
            echo "Algo salió mal. Por favor verifica que la tabla exista";
            header('Location: ../../login.php?login=false');
        }

    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
        header('Location: ../../login.php?login=false');
    }
}
?>