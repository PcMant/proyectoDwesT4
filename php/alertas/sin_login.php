<?php
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Los usuarios invitados no pueden interacturar con la base de datos ni consultar datos, debe de iniciar sesión con un usuario registrado con suficientes privilegios.
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
</div>';
?>