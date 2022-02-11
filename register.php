<?php
include 'php/Phtml/Phtml.php';
$pag = new Phtml('Registro');
$pag->openDiv("class='col-12 row justify-content-center'");
$pag->titulo('Registro',1,'class="text-center"');
$pag->openForm("class='col-12 col-sm-12  col-lg-12 col-xl-3 row' action='php/con-mysql/registro.php'");

$pag->openDiv("class='mb-3'");
$pag->label('usuario','Usuario*',"class='form-label'");
$pag->input('name','usuario','usuario',"class='form-control' aria-describedby='usuario' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('password','Contraseña*',"class='form-label'");
$pag->input('password','password','password',"class='form-control' aria-describedby='contraseña' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('password2','Repita la contraseña*',"class='form-label'");
$pag->input('password','password2','password2',"class='form-control' aria-describedby='repita contraseña' required");
$pag->closeDiv();

$pag->openDiv("class='mb-3'");
$pag->label('tipo','Tipo*',"class='form-label'");
$pag->openSelect('tipo','tipo','class="form-select"');
$pag->option('visor','Visor');
$pag->option('editor','Editor');
$pag->closeSelect();
$pag->closeDiv();

$pag->openP('style="font-size: 13px; letter-spacing: -1px"');
$pag->etiquetaGenerica('strong','Los datos marcados con * son obligatorios.');
$pag->closeP();

$pag->openDiv('class="text-center"');
$pag->button('submit','','','Registrarse','class="btn btn-primary w-100"');
$pag->closeDiv();

$pag->closeForm();
$pag->closeDiv();
$pag->printPagina();