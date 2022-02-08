<?php require_once 'php/header.php'; //header ?>


<?php
// Recogiendo parámetros
$_SESSION['id'] = !empty($_GET['id']) ? $_GET['id'] : '';
$_SESSION['dni'] = !empty($_GET['dni']) ? $_GET['dni'] : '';
$_SESSION['apellidos'] = !empty($_GET['apellidos']) ? $_GET['apellidos'] : '';
$_SESSION['nombre'] = !empty($_GET['nombre']) ? $_GET['nombre'] : '';
?>

    <h1>Resultados de la consulta a la base de datos</h1>
    Criterios de búsqueda:
    <ul>
        <li><strong>Id</strong>: <?=$_SESSION['id']?></li>
        <li><strong>DNI</strong>: <?=$_SESSION['dni']?></li>
        <li><strong>Apellidos</strong>: <?=$_SESSION['apellidos']?></li>
        <li><strong>Nombre</strong>: <?=$_SESSION['nombre']?></li>
    <ul>

<?php
/*En caso de tener sesión iniciada se mostrará un listado de todos los alumnos
De lo contrario se mostrará un login.*/
if($_SESSION['bllogin']){
    echo '<h2>Listado de alumnos</h2>';
    require_once 'php/con-mysql/select-alumnos.php';
}else{
    echo '
        <div class="col-12 row justify-content-center">
            <div class="col-12 col-sm-12  col-lg-12 col-xl-3">
                <h2 class="text-center">Inicio de sesión</h2>
        </div>
    </div>
    ';
    require_once 'php/formulario_login.php';
}
?>

<?php require_once 'php/footer.php'; //footer?>