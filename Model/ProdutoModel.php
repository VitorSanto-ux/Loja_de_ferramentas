<?php

class ProdutoModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM produtos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarProduto($id)
    {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $descricao, $minimo, $estoque)
    {
        $sql = "INSERT INTO produtos (nome, descricao, minimo, estoque)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nome,
            $descricao,
            $minimo,
            $estoque
        ]);
    }

    public function editar($nome, $descricao, $minimo, $estoque, $id)
    {
        $sql = "UPDATE produtos
                SET nome = ?, descricao = ?, minimo = ?, estoque = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nome,
            $descricao,
            $minimo,
            $estoque,
            $id
        ]);
    }

    
public function deletar($id)
{
    $sql = "DELETE FROM produtos WHERE id = ?";
    $comando = $this->pdo->prepare($sql);
    $comando->execute([$id]);

    return $comando->rowCount() > 0;
}

}