<?php
include 'php/Phtml/Phtml.php';

$pag = new Phtml('Inicio');
$pag->cabecera();
$pag->titulo('Página de inicio');
$pag->footer();
$pag->printPagina();

?>