<?php
require_once 'php/Phtml/Phtml.php';

/* Clase que genera el html necesario para mostrar los resultados de consulta 
y que hereda de la clase Phtml*/
class Resultados extends Phtml {

    public function __construct($nuevoTitulo="PcMant"){

        $this->titulo = $nuevoTitulo.'-NombreEscuela';
        $this->pagina = '';
    }

    /* Método que abre una tabla utilizando los estilos de Bootstrap */
    public function openTable($atributos='',$pos=0){
        $temp = "<table class='table table table-striped table-bordered' {$atributos}>";
        $this->addContenido($temp,$pos);
    }

    /* Método que genera un paginador en html funcional por Get, 
    funciona en función de los parametos de cantidad de páginas*/
    public function paginacion($paginas,$cantidad_Num_x_Pagina=0,$pos=0){

        $disableP = $_GET['pagina']<=1 ? 'disabled' : '';
        $prev = empty($_GET['pagina']) || $_GET['pagina']<=1 ? '1' : $_GET['pagina']-1;
        $next = empty($_GET['pagina']) ? '1' : $_GET['pagina']+1;
        $cantidad_Num_x_Pagina = $cantidad_Num_x_Pagina <=0 ? PHP_INT_MAX-1 : $cantidad_Num_x_Pagina-1;
        $paginas = $cantidad_Num_x_Pagina <=0 ? PHP_INT_MAX-1 : $paginas;

        $temp = "<nav aria-label='Page navigation'>
        <ul class='pagination justify-content-center'>
            <li class='page-item {$disableP}'>
                <a class='page-link' href='?pagina= {$prev}'>
                    Anterior
                </a>
            </li>";
			
			for($i=$_GET['pagina']-1;$i<$paginas && $i<$_GET['pagina']+$cantidad_Num_x_Pagina;$i++){
                $i1 = $i+1;
                $statusNP = $_GET['pagina'] == $i1 ? 'active' : '';
                $$statusNP = $_GET['pagina'] > $paginas ? 'disabled' : '';
				$temp.= "<li class='page-item {$statusNP} {$$statusNP}'>".'<a class="page-link" href="?pagina='.$i1.'">'.$i1.'</a></li>';
			}
            $statusNP = null;
            $$statusNP = null;
            
            $temp.= "<li class='page-item''>
                <a class='page-link' href='?pagina= {$next}'>
                    Siguiente
                </a>
            </li>
        </ul>
    </nav>";
    $this->addContenido($temp,$pos);
    }

}

?>