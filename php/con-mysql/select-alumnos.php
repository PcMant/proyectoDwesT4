<?php
require_once 'php/Phtml/Resultados.Php';

// Parametros
$id = !empty($_SESSION['id']) ? $_SESSION['id'] : '';
$dni = !empty($_SESSION['dni']) ? $_SESSION['dni'] : '';
$apellidos = !empty($_SESSION['apellidos']) ? $_SESSION['apellidos'] : '';
$nombre = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';
$criteriosSelect = '';

if($_SESSION['bllogin']){
    try {

        // Criterios para select paginado en función de los parámetros obtenidos
        if(empty($id) && empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `dni`= :dni";
        }elseif(empty($id) && empty($nombre) && !empty($apellidos) && empty($dni)){
            $criteriosSelect = "WHERE `apellidos` = :apellidos";
        }elseif(empty($id) && empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `apellidos`= :apellidos AND `dni`= :dni";
        }elseif(empty($id) && !empty($nombre) && empty($apellidos) && empty($dni)){
            $criteriosSelect = "WHERE `nombre`= :nombre";
        }elseif(empty($id) && !empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `nombre`= :nombre AND `dni` = :dni";
        }elseif(empty($id) && !empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `nombre`= :nombre AND `dni` = :dni AND `apellidos`= :apellidos";
        }elseif(!empty($id) && empty($nombre) && empty($apellidos) && empty($dni)){
            $criteriosSelect = "WHERE `id`= :id";
        }elseif(!empty($id) && empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `id`= :id AND `dni` = :dni";
        }elseif(!empty($id) && empty($nombre) && !empty($apellidos) && empty($dni)){
            $criteriosSelect = "WHERE `id`= :id AND `apellidos` = :apellidos";
        }elseif(!empty($id) && empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `id`= :id AND `apellidos` = :apellidos AND `dni` :dni";
        }elseif(!empty($id) && !empty($nombre) && empty($apellidos) && empty($dni)){
            $criteriosSelect = "WHERE `id`= :id AND `nombre` = :nombre";
        }elseif(!empty($id) && !empty($nombre) && empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `id`= :id AND `dni` = :dni, `nombre`= :nombre";
        }elseif(!empty($id) && !empty($nombre) && !empty($apellidos) && !empty($dni)){
            $criteriosSelect = "WHERE `id`= :id AND `apellidos` = :apellidos AND `dni` = :dni AND `nombre`= :nombre";
        }else{
            $criteriosSelect = '';
        }

        $mbd = new PDO("mysql:host=$host_db;port=$port_db;dbname=$database;charset=utf8", $user_db, $pass_db);
        // echo 'conectado';

        // Llamar a todos los alumnos
        $sql = "SELECT * from alumnos $criteriosSelect";
        $sentencia = $mbd->prepare($sql);
        if(!empty($id)) $sentencia->bindParam(':id', $id);
        if(!empty($dni)) $sentencia->bindParam(':dni', $dni);
        if(!empty($apellidos)) $sentencia->bindParam(':apellidos', $apellidos);
        if(!empty($nombre)) $sentencia->bindParam(':nombre', $nombre);
        $sentencia->execute();

        $resultado = $sentencia->fetchAll();

        $alumnos_x_pagina = 10;

        //Contar alumnos de nuestra base de datos
        $total_alumnos_db = $sentencia->rowCount();
        $paginas = $total_alumnos_db/$alumnos_x_pagina;
        $paginas = ceil($paginas);
        if($paginas < 1) $paginas = 1;

        // Forzando parámetro pagina 
        if(empty($_GET['pagina']) || $_GET['pagina'] > $paginas || $_GET['pagina'] < 1) echo "<script>location.replace('".basename($_SERVER['SCRIPT_FILENAME'],'.php').".php?pagina=1');</script>";
         /*header("Location:".basename($_SERVER['SCRIPT_FILENAME'], '.php')."?pagina=1")*/;

        // Consulta paginada
        $iniciar = ($_GET['pagina']-1)*$alumnos_x_pagina;

        $sql_alumnos = "SELECT * FROM alumnos $criteriosSelect LIMIT :iniciar,:alumnos"; /*Preparada usando placeholders */
        $sentencia_alumnos = $mbd->prepare($sql_alumnos); 
        $sentencia_alumnos->bindParam(':iniciar', $iniciar,PDO::PARAM_INT);
        $sentencia_alumnos->bindParam(':alumnos', $alumnos_x_pagina,PDO::PARAM_INT);
        if(!empty($id)) $sentencia_alumnos->bindParam(':id', $id);
        if(!empty($dni)) $sentencia_alumnos->bindParam(':dni', $dni);
        if(!empty($apellidos)) $sentencia_alumnos->bindParam(':apellidos', $apellidos);
        if(!empty($nombre)) $sentencia_alumnos->bindParam(':nombre', $nombre);
        $sentencia_alumnos->execute();

        $resultado_alumnos = $sentencia_alumnos->fetchAll();

    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}


if($_SESSION['bllogin']){
    $resultados = new Resultados();
    $resultados->openTable("class='text-center'");
    $resultados->openTr();
    $resultados->openTh();$resultados->texto('Id');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('Curso');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('Apellidos');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('Nombre');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('DNI');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('Fecha de nacimiento');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('Dirección');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('Localidad');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('CP');$resultados->closeTh();
    $resultados->openTh();$resultados->texto('Teléfono');$resultados->closeTh();
    $resultados->closeTr();

    // En caso de 0 resultados muestro una fila vacia
    if(count($resultado) < 1){
        $resultados->openTr();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->openTd();$resultados->closeTd();
        $resultados->closeTr();
    }

    // Listando los datos
    foreach ($resultado_alumnos as $dato){
        $resultados->openTr();
        $resultados->openTd();$resultados->texto($dato['id']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['curso']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['apellidos']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['nombre']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['dni']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['fecha_nac']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['direccion']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['localidad']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['cp']);$resultados->closeTd();
        $resultados->openTd();$resultados->texto($dato['telf']);$resultados->closeTd();
        $resultados->closeTr();
    }

    $resultados->closeTable();
    $resultados->paginacion($paginas,4);
    $resultados->printHtml();
}


?>