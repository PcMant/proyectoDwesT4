<?php
// Cierro la sesión
session_destroy();

// Caduco las cookies
if(!empty($_COOKIE['user']) || !empty($_COOKIE['pass'])){
    unset($_COOKIE['user']);
    unset($_COOKIE['pass']);
    //Para poder borrarla hay que caducarla
    setcookie('user','', time()-100, '/', 'localhost');
    setcookie('pass','', time()-100, '/', 'localhost');
}

?>