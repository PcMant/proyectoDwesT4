<div class="col-12 row justify-content-center">
    <div class="col-12 col-sm-12  col-lg-12 col-xl-3">
        <!--h1>Inicio de sesión</h1-->
        <form method="get" action="php/con-mysql/login.php">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Usuario</label>
                <input type="name" class="form-control" id="usuario" name="usuario" aria-describedby="usuario">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" aria-describedby="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="mantener-sesion" name="mantener-sesion">
                <label class="form-check-label" for="mantener-sesion">Mantener sesión</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>
    </div>
</div>