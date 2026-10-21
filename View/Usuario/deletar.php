<?php

require_once "C:/Turma2/xampp/htdocs/mvc/mvc/DB/Database.php";
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Controller/UsuarioController.php";

$UsuarioController = new UsuarioController($pdo);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $usuario = $UsuarioController->deletar($id);
    header('Location: ../../index.php');
} else {
    header('Location: ../../index.php');
}
?>