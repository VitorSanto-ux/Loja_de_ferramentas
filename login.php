<?php
session_start();
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/DB/Database.php";
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Controller/UsuarioController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuarioController = new UsuarioController($pdo);
    $usuarioController->login($email, $senha);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="auth.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required><br>

            <button type="submit">Entrar</button>
            <a href="cadastro.php">Cadastrar</a>
        </form>


    </div>
</body>

</html>