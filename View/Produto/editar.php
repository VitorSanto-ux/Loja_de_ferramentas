<?php

require_once "C:/Turma2/xampp/htdocs/mvc/mvc/DB/Database.php";
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Controller/ProdutoController.php";

$ProdutoController = new ProdutoController($pdo);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $produto = $ProdutoController->buscarProduto($id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>
<body>
    <form method="post">
       <label for="nome">Nome:</label>
       <input type="text" name="nome" value="<?=$produto['nome'];?>" required><br> 
       
       <label for="descricao">Descrição:</label>
       <input type="text" name="descricao" value="<?=$produto['descricao'];?>" required><br> 
       
       <label for="estoque_minimo">Estoque Mínimo:</label>
       <input type="number" name="minimo" value="<?=$produto['minimo'];?>" readonly><br> 
       
       <label for="estoque_atual">Estoque Atual:</label>
       <input type="number" name="estoque" value="<?=$produto['estoque'];?>"><br>  

       <input type="submit">
    </form>
</body>
</html>
<?php
} else {
    header('Location: home.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $estoque_minimo = $_POST['minimo'];
    $estoque_atual = $_POST['estoque'];

    $ProdutoController->editar($nome, $descricao, $estoque_minimo, $estoque_atual, $id);

    header('Location: ../../home.php');
}

?>
