<?php require_once 'php/header.php'; //header?>

<div class="row cl-12 justify-content-center">
    <div class="col-12 col-sm-12  col-lg-12 col-xl-3">
        <h1 class="text-center">Registro</h1>
        <form method="get" action="php/con-mysql/registro.php" >
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Usuario*</label>
                <input type="name" class="form-control" id="usuario" name="usuario" aria-describedby="usuario">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña*</label>
                <input type="password" class="form-control" id="password" name="password" aria-describedby="password">
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Repita la contraseña*</label>
                <input type="password" class="form-control" id="password2" name="password2" aria-describedby="password2">
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipor de cuenta*</label>
                <select class="form-select" id="tipo" name="tipo" aria-label="tipo">
                    <option value="visor">Visor</option>
                    <option value="editor">Editor</option>
                </select>
            </div>
            <p style="font-size: 13px; letter-spacing: -1px"><strong >Los datos marcados con * son obligatorios.</strong></p>
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>
    </div>
</div>

<?php require_once 'php/footer.php'; //footer?>