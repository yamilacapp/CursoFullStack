<?php

include_once "config.php";
include_once "entidades/usuario.php";

$usuario=new Usuario();
$usuario->usuario="admin";
$usuario->clave=$usuario->encriptarClave("admin123");
$usuario->nombre="Yamila";
$usuario->apellido="Cappari";
$usuario->correo="yamila@hotmail.com";
$usuario->insertar();
?>