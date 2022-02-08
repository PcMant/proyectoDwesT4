<?php
require_once 'credencials.php';

// Parámetros
$usuario = !empty($_GET["usuario"]) ? trim($_GET["usuario"]) : '';
$password = !empty($_GET["password"]) ? trim($_GET["password"]) : '';
$password2 = !empty($_GET["password2"]) ? trim($_GET["password2"]) : '';
$tipo = !empty($_GET["tipo"]) && (preg_match('/^Editor$/i',$_GET["tipo"]) || preg_match('/^Visor$/i',$_GET["tipo"])) ? trim($_GET["tipo"]) : '';
$fecha = date("Y-m-d");

echo "Usuario->$usuario Password->$password Password2->$password Tipo->$tipo Fecha->$fecha";
echo '<hr/>';

// Compruebo los parámetros, en caso de haber alguno incorrecto se redirije a una alerta de error
if(empty($usuario) || empty($password) || empty($password2) || empty($tipo) || !preg_match("/^$password$/i",$password2)){
    header('Location: ../../register.php?registro=false');

}else{
    // Sentencias
    try {
        // Conexion
        $registro = new PDO("mysql:host=$host_db;port=$port_db;dbname=$database;charset=utf8", $user_db, $pass_db);

        //Cifrado de contraseña
        $password = sha1($password);
        
        //Consulta
        $sql = 'INSERT INTO `usuarios` (`usuario`,`clave`,`fechaAlta`,`tipo`) VALUES (:usuario,:pass,:fecha,:tipo)';
        $sentencia = $registro->prepare($sql); 
        $sentencia->bindParam(':usuario', $usuario);
        $sentencia->bindParam(':pass', $password);
        $sentencia->bindParam(':fecha', $fecha);
        $sentencia->bindParam(':tipo', $tipo);
        $resultado = $sentencia->execute();
    
        // Se notifica con alerta si se proceso bien la sentencia sql
        if($resultado){ 
            $registro = null;
            echo "Insertado correctamente";
            header('Location: ../../index.php?pagina=1&registro=true');
        }
        else{ 
            $registro = null;
            echo "Algo salió mal. Por favor verifica que la tabla exista";
            header('Location: ../../register.php?registro=false');
        }

    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
        header('Location: ../../register.php?registro=false');
    }
}

?>