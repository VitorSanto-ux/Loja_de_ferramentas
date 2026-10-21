<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/mvc/mvc/DB/Database.php";
require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Controller/EstoqueController.php";



$estoqueController = new EstoqueController($pdo);

if (!isset($_SESSION['id_usuario'])) {
    die("Faça login para acessar esta página.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_produto = $_POST['id_produto'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $quantidade = $_POST['quantidade'] ?? '';

    $resultado = $estoqueController->cadastrar(
        $id_usuario,
        $id_produto,
        $tipo,
        $quantidade
    );

    if ($resultado) {
        echo "<script>
            alert('Movimentação cadastrada com sucesso!');
            window.location.href = 'home.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Erro ao cadastrar movimentação!');
            window.location.href = 'home.php';
        </script>";
        exit;
    }
}


$produtos = $estoqueController->listarProdutos();

$estoques = $estoqueController->listar();

$ultimas_movimentacoes = $estoqueController->listarUltimasMovimentacoes();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="nav">
        <h1>Seja bem-vindo, <?= htmlspecialchars($_SESSION['nome']) ?></h1>

        <a href="logout.php" class="btn-logout">Sair</a>

    </div>

    <div class="form-movimentacoes">

        <div class="container">
            <h2>Cadastrar movimentação</h2>

            <form method="POST" action="">

                <label for="id_produto">Produto:</label>

                <select name="id_produto" id="id_produto" required>
                    <option value="">Selecione o produto</option>

                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?= $produto['id'] ?>">
                            <?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <br><br>

                <label for="tipo">Tipo de movimentação:</label>

                <select name="tipo" id="tipo" required>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>

                <br><br>

                <label for="quantidade">Quantidade:</label>

                <input
                    type="number"
                    name="quantidade"
                    id="quantidade"
                    min="1"
                    required>

                <br><br>

                <button type="submit">Cadastrar movimentação</button>

            </form>

        </div>

    </div>

    <hr>


    <h2>Produtos cadastrados</h2>

    <a href="./View/Produto/cadastrar.php" class="cadastro-produtos">Cadastrar produto</a>

    <br><br>


    <div class="pesquisa-container">
        <input
            type="text"
            id="pesquisaProduto"
            placeholder="Pesquisar produto pelo nome...">
    </div>

    <?php
    $produtos_baixos = [];

    foreach ($produtos as $produto) {
        if ((int) $produto['estoque'] < 11) {
            $produtos_baixos[] = $produto;
        }
    }
    ?>

    <?php if (!empty($produtos_baixos)): ?>
        <div class="alerta-estoque">
            <strong>Produtos com estoque baixo!</strong>

            <ul>
                <?php foreach ($produtos_baixos as $produto): ?>
                    <li>
                        <?= htmlspecialchars($produto['nome']) ?> -
                        Estoque atual: <?= (int) $produto['estoque'] ?> unidades.
                        Mínimo: 11 unidades.
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>




    <?php if (empty($produtos)): ?>

        <p>Nenhum produto encontrado!</p>

    <?php else: ?>

        <table border="1" cellpadding="5" cellspacing="0" id="tabelaProdutos">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Estoque mínimo</th>
                    <th>Estoque atual</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr class="<?= (int) $produto['estoque'] < 11 ? 'estoque-baixo' : '' ?>">
                        <td><?= $produto['id'] ?></td>

                        <td>
                            <?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td><?= $produto['minimo'] ?></td>

                        <td><?= $produto['estoque'] ?></td>
                        <td>
                            <a href="View/Produto/editar.php?id=<?= $produto['id'] ?>">
                                Editar
                            </a>

                            <a href="View/Produto/deletar.php?id=<?= $produto['id'] ?>"
                                onclick="return confirm('Tem certeza que deseja deletar este produto?')">
                                Deletar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    <?php endif; ?>

    <hr>

    <h1>Últimas movimentações</h1>

    <?php if (empty($ultimas_movimentacoes)): ?>

        <p>Nenhuma movimentação encontrada!</p>

    <?php else: ?>

        <table border="1" cellpadding="5" cellspacing="0">

            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Usuário</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Data</th>
            </tr>

            <?php foreach ($ultimas_movimentacoes as $movimentacao): ?>

                <tr>
                    <td><?= $movimentacao['id'] ?></td>

                    <td>
                        <?= htmlspecialchars($movimentacao['produto'], ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($movimentacao['usuario'], ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($movimentacao['tipo'], ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td><?= $movimentacao['quantidade'] ?></td>

                    <td>
                        <?= date(
                            'd/m/Y H:i',
                            strtotime($movimentacao['data_movimentacao'])
                        ) ?>
                    </td>


                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</body>

</html>

<script>
    const pesquisa = document.getElementById('pesquisaProduto');
    const tabela = document.getElementById('tabelaProdutos');

    pesquisa.addEventListener('input', function() {
        const texto = pesquisa.value.toLowerCase().trim();
        const linhas = tabela.querySelectorAll('tbody tr');

        linhas.forEach(function(linha) {
            const nome = linha.cells[1].textContent.toLowerCase();

            linha.style.display = nome.includes(texto) ? '' : 'none';
        });
    });
</script>