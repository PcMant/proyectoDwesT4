<?php
include 'php/Phtml/Phtml.php';
$pag = new Phtml('Añadir alumno');
$pag->openDiv("class='col-12 row justify-content-center'");
$pag->titulo('Añadir alumno');
$pag->openForm("class='col-12 col-sm-12  col-lg-12 col-xl-3 row' action='php/con-mysql/insert-alumnos.php'");

$pag->openDiv("class='mb-3'");
$pag->label('curso','Curso',"class='form-label'");
$pag->input('text','curso','curso',"class='form-control' aria-describedby='curso'");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('nombre','Nombre*',"class='form-label'");
$pag->input('name','nombre','nombre',"class='form-control' aria-describedby='nombre' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('apellidos','Apellidos*',"class='form-label'");
$pag->input('name','apellidos','apellidos',"class='form-control' aria-describedby='apellidos' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('dni','DNI sin la letra',"class='form-label'");
$pag->input('number','dni','dni',"class='form-control' aria-describedby='dmi'");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('fecha_nac','Fecha de nacimiento*',"class='form-label'");
$pag->input('date','fecha_nac','fecha_nac',"class='form-control' aria-describedby='fecha de nacimiento' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('direccion','Dirección*',"class='form-label'");
$pag->input('text','direccion','direccion',"class='form-control' aria-describedby='dirección' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('localidad','Localidad*',"class='form-label'");
$pag->input('text','localidad','localidad',"class='form-control' aria-describedby='localidad' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('cp','Código postal*',"class='form-label'");
$pag->input('number','cp','cp',"class='form-control' aria-describedby='cp' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('telf','Teléfono*',"class='form-label'");
$pag->input('number','telf','telf',"class='form-control' aria-describedby='teléfono' required");
$pag->closeDiv();

$pag->openP('style="font-size: 13px; letter-spacing: -1px"');
$pag->etiquetaGenerica('strong','Los datos marcados con * son obligatorios.');
$pag->closeP();

$pag->openDiv('class="text-center"');
$pag->button('submit','','','Añadir registro','class="btn btn-primary w-100"');
$pag->closeDiv();

$pag->closeForm();
$pag->closeDiv();
$pag->printPagina();
?>