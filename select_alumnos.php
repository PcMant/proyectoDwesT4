<?php
include 'php/Phtml/Phtml.php';
$pag = new Phtml('Buscar alumnos');
$pag->openDiv("class='col-12 row justify-content-center'");
$pag->titulo('Buscar alumnos');
$pag->openForm("class='col-12 col-sm-12  col-lg-12 col-xl-3 row' action='resultados.php'");

$pag->openDiv("class='mb-3'");
$pag->label('id','Id',"class='form-label'");
$pag->input('number','id','id',"class='form-control' aria-describedby='id'");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('nombre','Nombre',"class='form-label'");
$pag->input('name','nombre','nombre',"class='form-control' aria-describedby='nombre'");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('apellidos','Apellidos',"class='form-label'");
$pag->input('name','apellidos','apellidos',"class='form-control' aria-describedby='apellidos'");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('dni','DNI sin la letra',"class='form-label'");
$pag->input('number','dni','dni',"class='form-control' aria-describedby='dmi'");
$pag->closeDiv();

$pag->openDiv('class="text-center"');
$pag->button('submit','','','Buscar','class="btn btn-primary w-100"');
$pag->closeDiv();

$pag->closeForm();
$pag->closeDiv();
$pag->printPagina();
?>