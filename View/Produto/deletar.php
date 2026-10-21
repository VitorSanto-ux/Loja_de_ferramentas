<?php
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/DB/Database.php";
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Controller/ProdutoController.php";

$ProdutoController = new ProdutoController($pdo);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $produto = $ProdutoController->deletar($id);
    header('Location: ../../home.php');
} else {
    header('Location: ../../home.php');
}

?>