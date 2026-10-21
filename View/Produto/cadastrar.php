<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>

    <h1>Cadastrar Produto</h1>

    <form method="POST">

        <label for="nome">Nome do produto:</label>
        <input type="text" name="nome" id="nome" required>

        <br><br>

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" required>

        <br><br>

        <label for="minimo">Estoque mínimo:</label>
        <input type="number" name="minimo" id="minimo" min="0" required>

        <br><br>

        <label for="estoque">Quantidade em estoque:</label>
        <input type="number" name="estoque" required>

        <br><br>

        <button type="submit" name="cadastrar">Cadastrar produto</button>

    </form>

</body>
</html>

<?php

require_once "C:/Turma2/xampp/htdocs/mvc/mvc/DB/Database.php";
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Controller/ProdutoController.php";

$produtoController = new ProdutoController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $minimo = $_POST['minimo'];
    $estoque = $_POST['estoque'];

    $produtoController->cadastrar($nome, $descricao, $minimo, $estoque);
    header('Location: ../../home.php');
    exit();
}