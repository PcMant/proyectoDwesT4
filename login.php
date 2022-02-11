<?php
include 'php/Phtml/Phtml.php';

$pag = new Phtml('Inicio de sesión');
$pag->cabecera();
$pag->titulo('Inicio de sesión',1,'class="text-center"');
$pag->footer();
$pag->printPagina();

?>