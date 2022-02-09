<?php 

class Phtml{

    protected $titulo;
    protected $paginaUp;
    protected $paginaDown;


    public function __construct($nuevoTitulo="PcMant"){
        $this->titulo = $nuevoTitulo.'-NombreEscuela';
        $this->pagina = '';
    }

    public function __set($name,$value){
        $this->$name = $value;
    }

    public function __get($name){
        return $this->$name;
    }

    public final function printPagina(){
        // Inicio de sesión
        session_start();

        // Comprobacción del login
        require_once('php/con-mysql/login_check.php');

        // Imprimiendo pagina parte superior
        echo $this->$paginaUp;
        require_once 'php/Phtml/Alertas.php';

        // Login, resultados o vacio
        if(preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || preg_match('/proyectoPhp*/',basename($_SERVER['REQUEST_URI']))){
            // Login
            require_once 'php/con-mysql/select-alumnos.php';
        }elseif(preg_match('/^insert_alumnos.php*/i',basename($_SERVER['REQUEST_URI']))){
            // Listado de datos
            require_once 'php/formulario_login.php';
        }

        // Imprimiendo parte inferior
        echo $this->$paginaDown;
    }

    public function addContenido($contenido,$pos=0){
        if($pos==1){
            $this->paginaUp.= $contenido."\n";
        }else{
            $this->paginaDown.= $contenido."\n";
        }
    }

    public function cabecera(){
        $usuario = empty($_SESSION['usuario']) && empty($_SESSION['password']) ? 'Invitado' : $_SESSION['usuario'];
        $inicio = preg_match('/^index.php*/i',basename($_SERVER['REQUEST_URI'])) || preg_match('/proyectoPhp*/',basename($_SERVER['REQUEST_URI'])) ? 'active' : '';
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
                                    <a class='nav-link active {$addAlumno}' href='insert_alumnos.php'>Añadir alumno</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link active {$editAlumno}' href='update_alumnos.php' tabindex='-1' aria-disabled='true'>Editar alumno</a>
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

        $this->addContenido($temp,0);
    }

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
        $this->addContenido($temp,1);
    }

    public function titulo($titulo,$h=0,$pos=0){
        $temp = "<h{$h}>{$titulo}</h{$h}>";
        $this->addContenido($temp,$pos);
    }

    public function etiquetaGenerica($etiqueta,$contenido,$pos){
        $temp = "<{$etiqueta}>{$contenido}</{$etiqueta}>";
        $this->addContenido($temp,$pos);
    }

    public function openForm(){}

    public function closeForm($pos=0){
        $temp = '</form>';
        $this->addContenido($temp,$pos);
    }

    public function input(){}
}