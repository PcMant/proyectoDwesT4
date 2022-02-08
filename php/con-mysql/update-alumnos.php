<?php
session_start();

require_once 'credencials.php';

require_once 'login_check.php';

// Parámetros recogidos del formulario
// ?id=&curso=&nombre=&apellidos=&dni=&fecha_nac=&direccion=&localidad=&cp=&telf=
$id = !empty($_GET['id']) ? trim($_GET['id']) : '';
$curso = !empty($_GET['curso']) ? trim($_GET['curso']) : null;
$nombre = !empty($_GET['nombre']) ? trim($_GET['nombre']) : '';
$apellidos = !empty($_GET['apellidos']) ? trim($_GET['apellidos']) : '';
$dni = !empty($_GET['dni']) ? trim($_GET['dni']) : null;
$fecha_nac = !empty($_GET['fecha_nac']) ? trim($_GET['fecha_nac']) : '';
$direccion = !empty($_GET['direccion']) ? trim($_GET['direccion']) : '';
$localidad = !empty($_GET['localidad']) ? trim($_GET['localidad']) : '';
$cp = !empty($_GET['cp']) ? trim($_GET['cp']) : '';
$telf = !empty($_GET['telf']) ? trim($_GET['telf']) : '';

// Compruebo que tengo el permiso y los parámetros requeridos
if(empty($id) || empty($nombre) || empty($apellidos) || empty($fecha_nac) || 
    empty($direccion) || empty($localidad) || empty($cp) || empty($telf) &&
    !$_SESSION['bllogin'] && !preg_match('/^Editor$/i',$_SESSION['tipo'])
){
    header('Location: ../../update_alumnos.php?formulario=false');
}else{
    // Sentencias
    try {

        // Comprobación de parámetros opcionales
        $dniC = !empty($dni) ? '`dni` = :dni,' : '';
        $cursoC = !empty($curso) ? '`curso` =:curso,' : '';

        // Conexion
        $registro = new PDO("mysql:host=$host_db;port=$port_db;dbname=$database;charset=utf8", $user_db, $pass_db);
        
        //Consulta
        $sqlUpdate = "UPDATE `alumnos` 
            SET `id` = :id, $dniC `apellidos` = :apellidos,`nombre` = :nombre,`fecha_nac` = :fecha_nac,
                $cursoC `direccion` =:direccion,`localidad` = :localidad,`cp` = :cp,`telf` = :telf WHERE `id` = :id";
        $sentenciaUpdate = $registro->prepare($sqlUpdate);
        $sentenciaUpdate->bindParam(':id', $id);
        if(!empty($dni)) $sentenciaUpdate->bindParam(':dni', $dni);
        $sentenciaUpdate->bindParam(':apellidos', $apellidos);
        $sentenciaUpdate->bindParam(':nombre', $nombre);
        $sentenciaUpdate->bindParam(':fecha_nac', $fecha_nac);
        if(!empty($curso)) $sentenciaUpdate->bindParam(':curso', $curso);
        $sentenciaUpdate->bindParam(':direccion', $direccion);
        $sentenciaUpdate->bindParam(':localidad', $localidad);
        $sentenciaUpdate->bindParam(':cp', $cp);
        $sentenciaUpdate->bindParam(':telf', $telf);
        $resultadoUpdate = $sentenciaUpdate->execute();
    
        // Se notifica con alerta si se proceso bien la sentencia sql
        if($resultadoUpdate){ 
            $registroUpdate = null;
            echo "Insertado correctamente";
            header('Location: ../../update_alumnos.php?formulario=true');
        }
        else{ 
            $registroUpdate = null;
            echo "Algo salió mal. Por favor verifica que la tabla exista";
            header('Location: ../../update_alumnos.php?formulario=false');
        }

    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
        header('Location: ../../update_alumnos.php?formulario=false');
    }

}
?>