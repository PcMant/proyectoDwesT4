<?php 
    // Comprobación de sesión y muestra una alerta de ser necesario
    if(
        (empty($_SESSION['usuario']) || empty($_SESSION['password'])) &&
        (!preg_match('/^login.php*/i',basename($_SERVER['REQUEST_URI'])) &&
        !preg_match('/^register.php*/i',basename($_SERVER['REQUEST_URI']))) &&
        !$_SESSION['bllogin']
        )
            require_once 'php/alertas/sin_login.php';

    // Comprobación de privilegios mostrando una alerta si es necesario
    if((
        preg_match('/^insert_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ||
        preg_match('/^update_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ||
        preg_match('/^delete_alumnos.php*/i',basename($_SERVER['REQUEST_URI']))
        ) && $_SESSION['bllogin'] && !preg_match('/^Editor$/i',$_SESSION['tipo'])
    ) 
        require_once 'php/alertas/sin_privilegio.php';

    // Inicio de sesión
    if(isset($_GET['login']) && $_GET['login'] == 'true'){
        require_once 'php/alertas/login_ok.php';
    }else if(isset($_GET['login']) && $_GET['login'] == 'false'){
        require_once 'php/alertas/login_error.php';
    }

    // Formulario standar
    if(isset($_GET['formulario']) && $_GET['formulario'] == 'true'){
        require_once 'php/alertas/formulario_success.php';
    }else if(isset($_GET['formulario']) && $_GET['formulario'] == 'false'){
        require_once 'php/alertas/error_formulario.php';
    }

    // Aviso registro de usuario
    if(isset($_GET['registro']) && $_GET['registro'] == 'true'){
        require_once 'php/alertas/registro_ok.php';
    }else if(isset($_GET['registro']) && $_GET['registro'] == 'false'){
        require_once 'php/alertas/error_formulario.php';
    }
?>