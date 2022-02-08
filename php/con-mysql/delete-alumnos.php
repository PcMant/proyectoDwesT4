<?php
session_start();

require_once 'credencials.php';

require_once 'login_check.php';

// Parámetros recogidos del formulario
// ?id=&nombre=&apellidos=&dni=
$id = !empty($_GET['id']) ? trim($_GET['id']) : '';
$nombre = !empty($_GET['nombre']) ? trim($_GET['nombre']) : '';
$apellidos = !empty($_GET['apellidos']) ? trim($_GET['apellidos']) : '';
$dni = !empty($_GET['dni']) ? trim($_GET['dni']) : null;

// Compruebo que tengo el permiso y los parámetros requeridos
if(!$_SESSION['bllogin']) header('Location: ../../delete_alumnos.php?formulario=false');
if(!$_SESSION['bllogin'] && !preg_match('/^Editor$/i',$_SESSION['tipo'])){
   header('Location: ../../delete_alumnos.php?formulario=false');
}else{
    // Sentencias
    try {
        // Conexion
        $registro = new PDO("mysql:host=$host_db;port=$port_db;dbname=$database;charset=utf8", $user_db, $pass_db);


        // Criterios para delete en función de los parámetros obtenidos
        $criteriosDelete;
        if(empty($id) && empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`dni`= :dni";
        }elseif(empty($id) && empty($nombre) && !empty($apellidos) && empty($dni)){
            $criteriosDelete = "`apellidos` = :apellidos";
        }elseif(empty($id) && empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`apellidos`= :apellidos AND `dni`= :dni";
        }elseif(empty($id) && !empty($nombre) && empty($apellidos) && empty($dni)){
            $criteriosDelete = "`nombre`= :nombre";
        }elseif(empty($id) && !empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`nombre`= :nombre AND `dni` = :dni";
        }elseif(empty($id) && !empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`nombre`= :nombre AND `dni` = :dni AND `apellidos`= :apellidos";
        }elseif(!empty($id) && empty($nombre) && empty($apellidos) && empty($dni)){
            $criteriosDelete = "`id`= :id";
        }elseif(!empty($id) && empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`id`= :id AND `dni` = :dni";
        }elseif(!empty($id) && empty($nombre) && !empty($apellidos) && empty($dni)){
            $criteriosDelete = "`id`= :id AND `apellidos` = :apellidos";
        }elseif(!empty($id) && empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`id`= :id AND `apellidos` = :apellidos AND `dni` :dni";
        }elseif(!empty($id) && !empty($nombre) && empty($apellidos) && empty($dni)){
            $criteriosDelete = "`id`= :id AND `nombre` = :nombre";
        }elseif(!empty($id) && !empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`id`= :id AND `dni` = :dni, `nombre`= :nombre";
        }elseif(!empty($id) && !empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosDelete = "`id`= :id AND `apellidos` = :apellidos AND `dni` = :dni AND `nombre`= :nombre";
        }else{
            header('Location: ../../delete_alumnos.php?formulario=false');
        }
        
        //Consulta
        $sqlDelete = "DELETE FROM `alumnos` WHERE $criteriosDelete";
        $sentenciaDelete = $registro->prepare($sqlDelete);
        if(!empty($id)) $sentenciaDelete->bindParam(':id', $id);
        if(!empty($dni)) $sentenciaDelete->bindParam(':dni', $dni);
        if(!empty($apellidos)) $sentenciaDelete->bindParam(':apellidos', $apellidos);
        if(!empty($nombre)) $sentenciaDelete->bindParam(':nombre', $nombre);
        $resultadoDelete = $sentenciaDelete->execute();
    
        // Se notifica con alerta si se proceso bien la sentencia sql
        if($resultadoDelete){ 
            $registroDelete = null;
            echo "Insertado correctamente";
            header('Location: ../../delete_alumnos.php?formulario=true');
        }
        else{ 
            $registroDelete = null;
            echo "Algo salió mal. Por favor verifica que la tabla exista";
            header('Location: ../../delete_alumnos.php?formulario=false');
        }

    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
        header('Location: ../../delete_alumnos.php?formulario=false');
    }
}
?>