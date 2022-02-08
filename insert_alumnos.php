<?php require_once 'php/header.php'; //header?>

<div class="col-12 row justify-content-center">
            <h1>Añadir alumno</h1>
            <form class="col-12 col-sm-12  col-lg-12 col-xl-3 row" action="php/con-mysql/insert-alumnos.php" >
                <div class="mb-3">
                    <label for="curso" class="form-label">Curso</label>
                    <input type="text" class="form-control" id="curso" name="curso" aria-describedby="nombre">
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre*</label>
                    <input type="name" class="form-control" id="nombre" name="nombre" aria-describedby="nombre">
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos*</label>
                    <input type="name" class="form-control" id="apellidos" name="apellidos" aria-describedby="apellidos">
                </div>
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI sin la letra</label>
                    <input type="number" class="form-control" id="dni" name="dni" aria-describedby="dni">
                </div>
                <div class="mb-3">
                    <label for="fecha_nac" class="form-label">Fecha de nacimiento*</label>
                    <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" aria-describedby="fecha_nac">
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección*</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" aria-describedby="direccion">
                </div>
                <div class="mb-3">
                    <label for="localidad" class="form-label">Localidad*</label>
                    <input type="text" class="form-control" id="localidad" name="localidad" aria-describedby="localidad">
                </div>
                <div class="mb-3">
                    <label for="cp" class="form-label">Código postal*</label>
                    <input type="number" class="form-control" id="cp" name="cp" aria-describedby="cp">
                </div>
                <div class="mb-3">
                    <label for="telf" class="form-label">Teléfono*</label>
                    <input type="number" class="form-control" id="telf" name="telf" aria-describedby="telf">
                </div>
                <p style="font-size: 13px; letter-spacing: -1px"><strong >Los datos marcados con * son obligatorios.</strong></p>
                <div class="text-center"><button type="submit" class="btn btn-primary w-100">Añadir registro</button></div>
            </form>
        </div>

<?php require_once 'php/footer.php'; //footer?>