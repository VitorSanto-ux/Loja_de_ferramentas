
<?php

if (empty($ultimas_movimentacoes)) {
    echo "<p>Nenhuma movimentação encontrada!</p>";
    return;
}

echo "<h2>Últimas movimentações</h2>";

echo "<table border='1' cellpadding='5' cellspacing='0'>";

echo "<tr>
        <th>ID</th>
        <th>Produto</th>
        <th>Usuário</th>
        <th>Tipo</th>
        <th>Quantidade</th>
        <th>Data</th>
      </tr>";

foreach ($ultimas_movimentacoes as $movimentacao) {

    $id = $movimentacao['id'];
    $produto = htmlspecialchars($movimentacao['produto'], ENT_QUOTES, 'UTF-8');
    $usuario = htmlspecialchars($movimentacao['usuario'], ENT_QUOTES, 'UTF-8');
    $tipo = htmlspecialchars($movimentacao['tipo'], ENT_QUOTES, 'UTF-8');
    $quantidade = $movimentacao['quantidade'];
    $data = date('d/m/Y H:i', strtotime($movimentacao['data_movimentacao']));

    echo "<tr>";
    echo "<td>{$id}</td>";
    echo "<td>{$produto}</td>";
    echo "<td>{$usuario}</td>";
    echo "<td>{$tipo}</td>";
    echo "<td>{$quantidade}</td>";
    echo "<td>{$data}</td>";
    echo "</tr>";
}

echo "</table>";
?>