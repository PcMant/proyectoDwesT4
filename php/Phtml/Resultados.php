<?php
require_once 'php/Phtml/Phtml.php';

class Resultados extends Phtml {

    public function __construct($nuevoTitulo="PcMant"){

        $this->titulo = $nuevoTitulo.'-NombreEscuela';
        $this->pagina = '';
    }

    public function openTable($atributos='',$pos=0){
        $temp = "<table class='table table table-striped table-bordered' {$atributos}>";
        $this->addContenido($temp,$pos);
    }


    public function paginacion($paginas){

        $disableP = $_GET['pagina']<=1 ? 'disabled' : '';
        $prev = empty($_GET['pagina']) || $_GET['pagina']<=1 ? '1' : $_GET['pagina']-1;
        $next = empty($_GET['pagina']) ? '1' : $_GET['pagina']+1;

        echo "<nav aria-label='Page navigation'>
        <ul class='pagination justify-content-center'>
            <li class='page-item {$disableP}'>
                <a class='page-link' href='?pagina= {$prev}'>
                    Anterior
                </a>
            </li>";
			
			for($i=$_GET['pagina']-1;$i<$paginas && $i<$_GET['pagina']+3;$i++){
                $i1 = $i+1;
                $statusNP = $_GET['pagina'] == $i1 ? 'active' : '';
                $$statusNP = $_GET['pagina'] > $paginas ? 'disabled' : '';
				echo "<li class='page-item {$statusNP} {$$statusNP}'>";
                echo  '<a class="page-link" href="?pagina='.$i1.'">'.$i1.'</a></li>';
			}
            $statusNP = null;
            $$statusNP = null;
            
            echo "<li class='page-item''>
                <a class='page-link' href='?pagina= {$next}'>
                    Siguiente
                </a>
            </li>
        </ul>
    </nav>";
    }

}

?>