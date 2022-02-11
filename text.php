<?php
include 'php/Phtml/Phtml.php';

$pag = new Phtml('Inicio');
$pag->cabecera();
$pag->titulo('Página de inicio',1,'class="text-center"');
$pag->footer();
$pag->printPagina();

?>