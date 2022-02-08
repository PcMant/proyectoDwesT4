<?php require_once 'php/header.php'; //header?>

<?php
//Reinicio de los parámetros
$_SESSION['id'] = '';
$_SESSION['dni'] = '';
$_SESSION['apellidos'] = '';
$_SESSION['nombre'] = '';
?>

<div class="col-12 row justify-content-center">
    <h1>Buscar alumnos</h1>
    <form class="col-12 col-sm-12  col-lg-12 col-xl-3" action="resultados.php" method="get">
        <div class="mb-3">
            <label for="id" class="form-label">Id</label>
            <input type="number" class="form-control" id="id" name="id" aria-describedby="id">
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="name" class="form-control" id="nombre" name="nombre" aria-describedby="nombre">
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="name" class="form-control" id="apellidos" name="apellidos" aria-describedby="apellidos">
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label">DNI sin la letra</label>
            <input type="number" class="form-control" id="dni" name="dni" aria-describedby="dni">
        </div>
        <input type="hidden" name="pagina" value="1" />
        <div class="text-center"><button type="submit" class="btn btn-primary w-100">Buscar</button></div>
    </form>
</div>

<?php require_once 'php/footer.php'; //footer?>