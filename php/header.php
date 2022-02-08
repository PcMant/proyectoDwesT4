<?php 
// Inicio de sesión
session_start();

// Comprobacción del login
require_once('php/con-mysql/login_check.php');

// Comprobación de la página y en función de eso se aplica un title u otro
if(preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || preg_match('/proyectoPhp*/',basename($_SERVER['REQUEST_URI']))){
    $title= 'Inicio';
}elseif(preg_match('/^insert_alumnos.php*/i',basename($_SERVER['REQUEST_URI']))){
    $title= 'Añadir alumno';
}elseif(preg_match('/^update_alumnos.php*/i',basename($_SERVER['REQUEST_URI']))){
    $title= 'Editar alumno';
}elseif(preg_match('/^delete_alumnos.php*/i',basename($_SERVER['REQUEST_URI']))){
    $title= 'Eliminar alumnos';
}elseif(preg_match('/^select_alumnos.php*/i',basename($_SERVER['REQUEST_URI']))){
    $title= 'Consultar alumnos';
}elseif(preg_match('/^login.php*/i',basename($_SERVER['REQUEST_URI']))){
    $title= 'Iniciar sesión';
}elseif(preg_match('/^register.php*/i',basename($_SERVER['REQUEST_URI']))){
    $title= 'Registrarse';
}elseif(preg_match('/^resultados.php*/i',basename($_SERVER['REQUEST_URI']))){
    $title= 'Registrarse';
}else{
    $title = '';
}

$title = empty($title) ? '' : $title.' - NombreEscuela';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="initial-scale=1" />
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.min.css" />
    <title><?=$title?></title>
</head>

<body>
    <!--INICO CABECERA-->
    <header id="header" class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light navbar-dark bg-success sticky-top">
            <div class="container-md">
                <a class="navbar-brand logo" href="index.php?pagina=1"><img src="images/logo.png" />NombreEscuela</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                    aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav me-auto my-2 my-lg-0">
                        <li class="nav-item">
                            <a class="nav-link 
                                <?php 
                                    echo preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || 
                                    //En este otro comprobar siempre con el nombre de la carpeta que lo contiene, se ha de modificar para adaptarlo
                                    preg_match('/proyectoPhp*/',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';
                                ?>" aria-current="page" href="index.php?pagina=1">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo preg_match('/^insert_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';?>" href="insert_alumnos.php">Añadir alumno</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo preg_match('/^update_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';?>" href="update_alumnos.php" tabindex="-1" aria-disabled="true">Editar alumno</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo preg_match('/^delete_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';?>" href="delete_alumnos.php" tabindex="-1" aria-disabled="true">Eliminar alumnos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo preg_match('/^select_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';?>" href="select_alumnos.php" tabindex="-1" aria-disabled="true">Consultar alumnos</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?=empty($_SESSION['usuario']) && empty($_SESSION['password']) ? 'Invitado' : $_SESSION['usuario']?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="login.php">Iniciar sesión</a></li>
                                <li><a class="dropdown-item" href="register.php">Registrarse</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="php/logout.php">Cerrar sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- FIN CABECERA -->

    <!-- Inicio de contenido -->
    <main id="main" class="container container-md bg-light mt-2 p-5">

    <?php require_once 'php/alertas/alertas.php'; ?>
        