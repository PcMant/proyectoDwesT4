<?php

// Parametros
$id = !empty($_SESSION['id']) ? $_SESSION['id'] : '';
$dni = $_SESSION['dni'];
$apellidos = $_SESSION['apellidos'];
$nombre = $_SESSION['nombre'];
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
        $paginas = $total_alumnos_db/10;
        $paginas = ceil($paginas);
        if($paginas < 1) $paginas = 1;

        // Forzando parámetro pagina 
        if(empty($_GET['pagina']) || $_GET['pagina'] > $paginas || $_GET['pagina'] < 1) header("Location:".basename($_SERVER['SCRIPT_FILENAME'], '.php')."?pagina=1");

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
?>

<?php if($_SESSION['bllogin']): ?>
    <table class="table table table-striped table-bordered">
        <tr class="text-center">
            <th>Id</th>
            <th>Curso</th>
            <th>Apellidos</th>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Fecha de nacimiento</th>
            <th>Dirección</th>
            <th>Localidad</th>
            <th>CP</th>
            <th>Teléfono</th>
        </tr>


        <?php if(count($resultado) < 1): //En caso de 0 resultados muestro una fila vacia?>
            <tr>
                <td>ㅤ</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?>

        <?php foreach ($resultado_alumnos as $dato): //Listando datos?>
            <tr>
                <td><?=$dato['id']?></td>
                <td><?=$dato['curso']?></td>
                <td><?=$dato['apellidos']?></td>
                <td><?=$dato['nombre']?></td>
                <td><?=$dato['dni']?></td>
                <td><?=$dato['fecha_nac']?></td>
                <td><?=$dato['direccion']?></td>
                <td><?=$dato['localidad']?></td>
                <td><?=$dato['cp']?></td>
                <td><?=$dato['telf']?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : '';?>">
                <a class="page-link" href=".?pagina=<?=empty($_GET['pagina']) || $_GET['pagina']<=1 ? '1' : $_GET['pagina']-1?>">
                    Anterior
                </a>
            </li>

            <?php for($i=$_GET['pagina']-1;$i<$paginas && $i<$_GET['pagina']+3;$i++): ?>
                <li class="page-item <?php if($_GET['pagina'] == $i+1) echo 'active';?> <?php echo $_GET['pagina'] > $paginas ? 'disabled' : ''?>">
                    <a class="page-link" href=".?pagina=<?=$i+1?>">
                        <?=$i+1?>
                    </a>
                </li>
            <?php endfor ?>
            
            <li class="page-item">
                <a class="page-link" href=".?pagina=<?=empty($_GET['pagina']) ? '1' : $_GET['pagina']+1;?>">
                    Siguiente
                </a>
            </li>
        </ul>
    </nav>

    </div>
<?php endif; ?>