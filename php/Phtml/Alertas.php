<?php
class Alertas{

    public function error($mensaje){
        return "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Error!</strong> {$mensaje}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }

    public function aviso($mensaje){
        return "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Aviso!</strong> {$mensaje}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
}

$alerta = new Alertas();

// Comprobación de sesión y muestra una alerta de ser necesario
if(
    (empty($_SESSION['usuario']) || empty($_SESSION['password'])) &&
    (!preg_match('/^login.php*/i',basename($_SERVER['REQUEST_URI'])) &&
    !preg_match('/^register.php*/i',basename($_SERVER['REQUEST_URI']))) &&
    !$_SESSION['bllogin']
    )
        echo $alerta->error('
        Los usuarios invitados no pueden interacturar con la base de datos ni consultar datos, debe de iniciar sesión con un usuario registrado con suficientes privilegios.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <p>
            Para poder hacer uso de esta plataforma no puede hacer uso de ella como Invitado, deberá de ser un usuario
            registrado.
        </p>
        <p>
            Existen dos tipos de cuentas:
        </p>
        <ul>
            <li><strong>Visor</strong>: Este solo puede consultar los datos de los alumnos.</li>
            <li><strong>Editor</strong>: Este puede Añadir datos de alumnos, modificarlos y consultar.</li>
        </ul>
        <a href="login.php" class="btn btn-primary mt-1">Iniciar sesión</a>
        <a href="register.php" class="btn btn-primary mt-1">Registrarse</a>   
        ');

// Comprobación de privilegios mostrando una alerta si es necesario
if((
    preg_match('/^insert_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ||
    preg_match('/^update_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ||
    preg_match('/^delete_alumnos.php*/i',basename($_SERVER['REQUEST_URI']))
    ) && $_SESSION['bllogin'] && !preg_match('/^Editor$/i',$_SESSION['tipo'])
) 
    echo $alerta->error('No dispones de suficientes privilegios para esta acción.');

// Inicio de sesión
if(isset($_GET['login']) && $_GET['login'] == 'true'){
    echo $alerta->aviso('Has iniciado sesión correctamente.');
}else if(isset($_GET['login']) && $_GET['login'] == 'false'){
    echo $alerta->error('Contraseña o cuenta introduccida incorrectamente, intentalo de nuevo.');
}

// Formulario standar
if(isset($_GET['formulario']) && $_GET['formulario'] == 'true'){
    echo $alerta->aviso('Formulario procesado correctamente.');
}else if(isset($_GET['formulario']) && $_GET['formulario'] == 'false'){
    echo $alerta->error('Faltan datos o algunos de los datos introducciodos son incorrectos, introducelos nuevamente.');
}

// Aviso registro de usuario
if(isset($_GET['registro']) && $_GET['registro'] == 'true'){
    echo $alerta->aviso('El registro se ha realizado correctamente.');
}else if(isset($_GET['registro']) && $_GET['registro'] == 'false'){
    echo $alerta->error('Faltan datos o algunos de los datos introducciodos son incorrectos, introducelos nuevamente.');
}
?>