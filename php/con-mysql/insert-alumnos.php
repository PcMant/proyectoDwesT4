<?php
session_start();

require_once 'credencials.php';

require_once 'login_check.php';

// Parámetros recogidos del formulario
// ?curso=&nombre=&apellidos=&dni=&fecha_nac=&direccion=&localidad=&cp=&telf=
$curso = !empty($_GET['curso']) ? trim($_GET['curso']) : '';
$nombre = !empty($_GET['nombre']) ? trim($_GET['nombre']) : '';
$apellidos = !empty($_GET['apellidos']) ? trim($_GET['apellidos']) : '';
$dni = !empty($_GET['dni']) ? trim($_GET['dni']) : '';
$fecha_nac = !empty($_GET['fecha_nac']) ? trim($_GET['fecha_nac']) : '';
$direccion = !empty($_GET['direccion']) ? trim($_GET['direccion']) : '';
$localidad = !empty($_GET['localidad']) ? trim($_GET['localidad']) : '';
$cp = !empty($_GET['cp']) ? trim($_GET['cp']) : '';
$telf = !empty($_GET['telf']) ? trim($_GET['telf']) : '';

// Compruebo que tengo el permiso y los parámetros requeridos
if(empty($nombre) || empty($apellidos) || empty($fecha_nac) || 
    empty($direccion) || empty($localidad) || empty($cp) || empty($telf) &&
    !$_SESSION['bllogin'] && !preg_match('/^Editor$/i',$_SESSION['tipo'])
){
    header('Location: ../../insert_alumnos.php?formulario=false');
}else{
    // Sentencias
    try {
        // Comprobación de parámetros opcionales
        $dniC = !empty($dni) ? '`dni`, ' : '';
        $dniCV = !empty($dni) ? ':dni,' : '';
        $cursoC = !empty($curso) ? '`curso`, ' : '';
        $cursoCV = !empty($curso) ? ':curso,' : '';

        // Conexion
        $registro = new PDO("mysql:host=$host_db;port=$port_db;dbname=$database;charset=utf8", $user_db, $pass_db);

        //Consulta
        $sqlInsert = "INSERT INTO `alumnos` ($dniC`apellidos`,`nombre`,`fecha_nac`,$cursoC`direccion`,`localidad`,`cp`,`telf`) 
            VALUES ($dniCV:apellidos,:nombre,:fecha_nac,$cursoCV:direccion,:localidad,:cp,:telf)";
        $sentenciaInsert = $registro->prepare($sqlInsert); 
        if(!empty($dni)) $sentenciaInsert->bindParam(':dni', $dni);
        $sentenciaInsert->bindParam(':apellidos', $apellidos);
        $sentenciaInsert->bindParam(':nombre', $nombre);
        $sentenciaInsert->bindParam(':fecha_nac', $fecha_nac);
        if(!empty($curso)) $sentenciaInsert->bindParam(':curso', $curso);
        $sentenciaInsert->bindParam(':direccion', $direccion);
        $sentenciaInsert->bindParam(':localidad', $localidad);
        $sentenciaInsert->bindParam(':cp', $cp);
        $sentenciaInsert->bindParam(':telf', $telf);
        $resultadoInsert = $sentenciaInsert->execute();
    
        // Se notifica con alerta si se proceso bien la sentencia sql
        if($resultadoInsert){ 
            $registroInsert = null;
            echo "Insertado correctamente";
            header('Location: ../../insert_alumnos.php?formulario=true');
        }
        else{ 
            echo $sqlInsert;
            $registroInsert = null;
            echo "Algo salió mal. Por favor verifica que la tabla exista";
            header('Location: ../../insert_alumnos.php?formulario=false');
        }

    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
        header('Location: ../../insert_alumnos.php?formulario=false');
    }

}
?>