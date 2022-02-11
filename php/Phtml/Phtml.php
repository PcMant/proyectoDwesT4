<?php 
/* Clase generadora de contenido html*/
class Phtml{

    protected $titulo = '';
    protected $paginaUp = '';
    protected $paginaDown = '';

    public function __construct($nuevoTitulo="PcMant"){

        // Inicio de sesión
        session_start();

        $this->titulo = $nuevoTitulo.'-NombreEscuela';
        $this->pagina = '';
    }

    public function __set($name,$value){
        $this->$name = $value;
    }

    public function __get($name){
        return $this->$name;
    }

    /** Método que solo imprime contenido y no la página entera */
    public function printHtml(){
        echo $this->paginaUp;
        echo $this->paginaDown;
    }

    /** Método para imprimir la pagina resultante */
    public final function printPagina(){
        // Comprobacción del login
        require_once('php/con-mysql/login_check.php');

        // Imprimiendo cabecera
        echo $this->cabecera();

        // Alertas
        require_once 'php/Phtml/Alertas.php';

        // Imprimiendo pagina parte superior
        echo $this->paginaUp;

        // Login, resultados o vacio según página
        if($_SESSION['bllogin'] && (preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || 
            preg_match('/proyectoDwesT4*/',basename($_SERVER['REQUEST_URI'])) || preg_match('/^resultados.php*/i',basename($_SERVER['REQUEST_URI'])))){
            
            if(preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || 
                preg_match('/proyectoDwesT4*/i',basename($_SERVER['REQUEST_URI']))){
                    /*en caso de ser la página principal y reinicia los criterios de busqueda ya que comparte tablas*/
                    echo '<h2>Listado de alumnos</h2>';
                    $_SESSION['id'] = '';
                    $_SESSION['dni'] = '';
                    $_SESSION['apellidos'] = '';
                    $_SESSION['nombre'] = '';
                }elseif(preg_match('/^resultados.php*/i',basename($_SERVER['REQUEST_URI']))){

                    // Recogida de datos
                    $_SESSION['id'] = !empty($_GET['id']) ? $_GET['id'] : '';
                    $_SESSION['dni'] = !empty($_GET['dni']) ? $_GET['dni'] : '';
                    $_SESSION['apellidos'] = !empty($_GET['apellidos']) ? $_GET['apellidos'] : '';
                    $_SESSION['nombre'] = !empty($_GET['nombre']) ? $_GET['nombre'] : '';

                    echo "
                    <h1>Resultados de la consulta a la base de datos</h1>
                    Criterios de búsqueda:
                    <ul>
                        <li><strong>Id</strong>: {$_SESSION['id']}</li>
                        <li><strong>DNI</strong>: {$_SESSION['dni']}</li>
                        <li><strong>Apellidos</strong>: {$_SESSION['apellidos']}</li>
                        <li><strong>Nombre</strong>: {$_SESSION['nombre']}</li>
                    <ul><br/>
                    ";
                }

            // Login
            $host_db = $_SESSION['host_db'];
            $port_db = $_SESSION['port_db'];
            $user_db = $_SESSION['user_db'];
            $pass_db = $_SESSION['pass_db'];
            $database = $_SESSION['database'];
            require_once 'php/con-mysql/select-alumnos.php';

        }elseif(!$_SESSION['bllogin'] && (preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || 
        preg_match('/proyectoDwesT4*/i',basename($_SERVER['REQUEST_URI'])) || preg_match('/^resultados.php*/i',basename($_SERVER['REQUEST_URI'])))){

            echo $this->login();
        }

        if(preg_match('/^login.php*/i',basename($_SERVER['REQUEST_URI']))) echo $this->login();

        // Imprimiendo parte inferior
        echo $this->paginaDown;
        echo $this->footer();
    }

    /* Método que va añadiendo el contenido para luego posteriormente generar html con los otros métodos*/
    public function addContenido($contenido,$pos=0){
        if($pos==1){
            $this->paginaDown.= $contenido."\n";
        }else{
            $this->paginaUp.= $contenido."\n";
        }
    }

    /* Metodo que devuelve un formulario de inicio de sesión */
    public function login(){
        return '<div class="col-12 row justify-content-center">
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
                </div>';
    }

    /* Metodo que retorna cabecera */
    public function cabecera(){
        require_once('php/con-mysql/login_check.php');
        $usuario = empty($_SESSION['usuario']) && empty($_SESSION['password']) ? 'Invitado' : $_SESSION['usuario'];
        $inicio = preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || preg_match('/proyectoDwesT4*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';
        $addAlumno = preg_match('/^insert_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';
        $editAlumno = preg_match('/^update_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';
        $delAlumno = preg_match('/^delete_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';
        $consultarAlumno = preg_match('/^select_alumnos.php*/i',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';

        $temp ="
        <!DOCTYPE html>
        <html lang='es'>
        
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta name='viewport' content='initial-scale=1' />
            <link rel='shortcut icon' href='images/favicon.png'>
            <link rel='stylesheet' type='text/css' href='css/styles.css' />
            <link rel='stylesheet' type='text/css' href='libs/bootstrap/css/bootstrap.min.css' />
            <title>{$this->titulo}</title>
        </head>
        
        <body>
            <!--INICO CABECERA-->
            <header id='header' class='sticky-top'>
                <nav class='navbar navbar-expand-lg navbar-light navbar-dark bg-success sticky-top'>
                    <div class='container-md'>
                        <a class='navbar-brand logo' href='index.php?pagina=1'><img src='images/logo.png' />NombreEscuela</a>
                        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbar'
                            aria-controls='navbar' aria-expanded='false' aria-label='Toggle navigation'>
                            <span class='navbar-toggler-icon'></span>
                        </button>
                        <div class='collapse navbar-collapse' id='navbar'>
                            <ul class='navbar-nav me-auto my-2 my-lg-0'>
                                <li class='nav-item'>
                                    <a class='nav-link {$inicio}' aria-current='page' href='index.php?pagina=1'>Inicio</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link {$addAlumno}' href='insert_alumnos.php'>Añadir alumno</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link {$editAlumno}' href='update_alumnos.php' tabindex='-1' aria-disabled='true'>Editar alumno</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link {$delAlumno}' href='delete_alumnos.php' tabindex='-1' aria-disabled='true'>Eliminar alumnos</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link {$consultarAlumno}' href='select_alumnos.php' tabindex='-1' aria-disabled='true'>Consultar alumnos</a>
                                </li>
                            </ul>
                            <ul class='navbar-nav'>
                                <li class='nav-item dropdown'>
                                    <a class='nav-link dropdown-toggle active' id='navbarDropdown' role='button'
                                        data-bs-toggle='dropdown' aria-expanded='false'>
                                        {$usuario}
                                    </a>
                                    <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                        <li><a class='dropdown-item' href='login.php'>Iniciar sesión</a></li>
                                        <li><a class='dropdown-item' href='register.php'>Registrarse</a></li>
                                        <li>
                                            <hr class='dropdown-divider'>
                                        </li>
                                        <li><a class='dropdown-item' href='php/logout.php'>Cerrar sesion</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <!-- FIN CABECERA -->
        
            <!-- Inicio de contenido -->
            <main id='main' class='container container-md bg-light mt-2 p-5'>
        ";

        return $temp;
    }

    /* Método que retorna el footer */
    public function footer(){
        $temp = "
            </main>
            <!-- Fin de contenido -->
    
            <!--FOOTER-->
            <footer if='footer' class='container-md bg-light mt-2 p-5'>
                &copy; Created by <a href='https://www.pcmant.com/' target='_blank'>Juan Molina - PcMant</a>
            </footer>
    
            <!--Scripts para bootstrap y dependencias-->
            <script type='text/javascript' src='libs/bootstrap/js/bootstrap.bundle.min.js'></script>
        </body>
    
        </html>
        ";
        
        return $temp;
    }

    /* Genera un titulo de cualquiera de los tamaños de html*/
    public function titulo($titulo,$h=1,$atributos='',$pos=0){
        $temp = "<h{$h} {$atributos}>{$titulo}</h{$h}>";
        $this->addContenido($temp,$pos);
    }

    /* Añade contenido de cualquier tipo en texto plano*/
    public function texto($texto,$pos=0){
        $this->addContenido($texto,$pos);
    }

    /* Añade cualquier etiqueta no contemplada por la clase*/
    public function etiquetaGenerica($etiqueta,$contenido,$atributos='',$pos=0){
        $temp = "<{$etiqueta} {$atributos}>{$contenido}</{$etiqueta}>";
        $this->addContenido($temp,$pos);
    }

    /* Abre cualquier etiqueta  no contemplada por la clase */
    public function openGenerica($etiqueta,$atributos='',$pos=0){
        $temp = "<{$etiqueta} {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Cierra cualquier etiqueta no contemplada por la clase*/
    public function closeGenerica($etiqueta){
        $temp = "</{$etiqueta}>";
        $this->addContenido($temp,$pos);
    }

    /* Abre un párrafo*/
    public function openP($atributos,$pos=0){
        $temp = "<p {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Cierra párrafo*/
    public function closeP($pos=0){
        $this->addContenido('</p>',$pos);
    }

    /* Abre div*/
    public function openDiv($atributos,$pos=0){
        $temp = "<div {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Cierra div*/
    public function closeDiv($pos=0){
        $temp = '</div>';
        $this->addContenido($temp,$pos);
    }

    /* Crea enlace*/
    public function enlace($url='',$contenido='',$atributos='',$pos=0){
        $temp = "<a href='{$url}' {$atributos}>{$contenido}</a>";
        $this->addContenido($temp,$pos);
    }

    /*Crea un párrafo con texto plano o cualquier contenido*/
    public function parrafo($contenido='',$atributos='',$pos=0){
        $temp = "<p {$atributos}>{$contenido}</p>";
        $this->addContenido($temp,$pos);
    }

    /* Abre una tabla*/
    public function openTable($atributos='',$pos=0){
        $temp = "<table {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Abre una fila de tabla*/
    public function openTr($atributos='',$pos=0){
        $temp = "<tr {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Abre Encabezado de tabla*/
    public function openTh($atributos='',$pos=0){
        $temp = "<th {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Abre celda de tabla */
    public function openTd($atributos='',$pos=0){
        $temp = "<td {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Cierra celda de tabla*/
    public function closeTd($pos=0){
        $temp = '</td>';
        $this->addContenido($temp,$pos);
    }

    /* Cierra encabezado de tabla*/
    public function closeTh($pos=0){
        $temp = '</th>';
        $this->addContenido($temp,$pos);
    }

    /* Cierra fila de tabla*/
    public function closeTr($pos=0){
        $temp = '</tr>';
        $this->addContenido($temp,$pos);
    }

    /* Cierra tabla*/
    public function closeTable($pos=0){
        $temp = '</table>';
        $this->addContenido($temp,$pos);
    }

    /* Abre una lista No ordenada */
    public function openUl($atributos='',$pos=0){
        $temp = "<ul {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Abre una lista Ordenada */
    public function openOl($atributos='',$pos=0){
        $temp = "<ol {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Abre un elemento de lista*/
    public function openli($atributos='',$pos=0){
        $temp = "<li {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Cierra un elemento de lista */
    public function closeLi($pos=0){
        $temp = '</li>';
        $this->addContenido($temp,$pos);
    }

    /* Cierra lista No ordenada */
    public function closeUl($pos=0){
        $temp = '</ul>';
        $this->addContenido($temp,$pos);
    }

    /* Cierra lista ordenada */
    public function closeOl($pos=0){
        $temp = '</ol>';
        $this->addContenido($temp,$pos);
    }

    /* Abre formulario */
    public function openForm($atributos='',$pos=0){
        $temp = "<form {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Crea un label */
    public function label($for,$contenido,$atributos='',$pos=0){
        $temp = "<label for='{$for}'  {$atributos} >{$contenido}</label>";
        $this->addContenido($temp,$pos);
    }

    /* Crea un input*/
    public function input($type,$name,$id='',$atributos='',$pos=0){
        $temp = "<input type='{$type}' name='{$name}' id='{$id}'  {$atributos} />";
        $this->addContenido($temp,$pos);
    }

    /* Crea un Ares de texto */
    public function textarea($name,$id,$contenido='',$atributos='',$pos=0){
        $temp = "<textarea name='{$name}' id='{$id}'  {$atributos}>{$contenido}</textarea>";
        $this->addContenido($temp,$pos);
    }

    /* Crea un checkbox */
    public function checkbox($name,$value,$id='',$atributos='',$pos=0){
        $temp = "<checkbox value='{$value}' name='{$name}' id='{$id}'  {$atributos} />";
        $this->addContenido($temp,$pos);
    }

    /* Abre un select */
    public function OpenSelect($name,$id,$atributos='',$pos=0){
        $temp = "<select name='{$name}' id='{$id}'  {$atributos} />";
        $this->addContenido($temp,$pos);
    }

    /* Crea opciones de Select */
    public function option($value,$contenido='',$atributos='',$pos=0){
        $temp = "<option value='{$value}' {$atributos}>{$contenido}</option>";
        $this->addContenido($temp,$pos);
    }

    /* Cierra select */
    public function closeSelect($pos=0){
        $temp = '</select>';
        $this->addContenido($temp,$pos);
    }

    /* Crea boton */
    public function button($type,$name='',$id='',$contenido,$atributos='',$pos=0){
        $temp = "<button type='{$type}' name='{$name}' id='{$id}'  {$atributos} >{$contenido}</button>";
        $this->addContenido($temp,$pos);
    }

    /* Cierra formulario */
    public function closeForm($pos=0){
        $temp = '</form>';
        $this->addContenido($temp,$pos);
    }

}