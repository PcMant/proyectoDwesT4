<?php require_once 'php/header.php'; //header?>

<h1>Página de inicio</h1>

<?php
//Reinicio de los parámetros
$_SESSION['id'] = '';
$_SESSION['dni'] = '';
$_SESSION['apellidos'] = '';
$_SESSION['nombre'] = '';
?>

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