<?php

class EstoqueModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarTodos()
    {
        $sql = "SELECT e.*, p.nome AS produto, u.nome AS usuario
                FROM estoque e
                INNER JOIN produtos p ON e.id_produto = p.id
                INNER JOIN usuarios u ON e.id_usuario = u.id
                ORDER BY e.id DESC";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarProdutos()
    {
        $sql = "SELECT * FROM produtos ORDER BY nome";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function cadastrar($id_usuario, $id_produto, $tipo, $quantidade)
{
    try {
        $this->pdo->beginTransaction();

        
        $sql = "SELECT estoque FROM produtos WHERE id = ? FOR UPDATE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_produto]);

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            $this->pdo->rollBack();
            return false;
        }

        $estoqueAtual = (int) $produto['estoque'];
        $quantidade = (int) $quantidade;

        
        if ($tipo === 'saida' && $estoqueAtual < $quantidade) {
            $this->pdo->rollBack();
            return false;
        }

      
        if ($tipo === 'entrada') {
            $sql = "UPDATE produtos
                    SET estoque = estoque + ?
                    WHERE id = ?";
        } else {
            $sql = "UPDATE produtos
                    SET estoque = estoque - ?
                    WHERE id = ?";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$quantidade, $id_produto]);

       
        $sql = "INSERT INTO estoque
                (id_usuario, id_produto, tipo, quantidade)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $id_usuario,
            $id_produto,
            $tipo,
            $quantidade
        ]);

        $this->pdo->commit();

        return true;

    } catch (Throwable $e) {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }

        throw $e;
    }
}


    public function deletar($id)
    {
        $sql = "DELETE FROM estoque WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function buscarUltimasMovimentacoes()
{
    $sql = "SELECT
                e.id,
                p.nome AS produto,
                u.nome AS usuario,
                e.tipo,
                e.quantidade,
                e.data_movimentacao
            FROM estoque e
            INNER JOIN produtos p ON e.id_produto = p.id
            INNER JOIN usuarios u ON e.id_usuario = u.id
            ORDER BY e.id DESC
            LIMIT 5";

    $comando = $this->pdo->prepare($sql);
    $comando->execute();

    return $comando->fetchAll(PDO::FETCH_ASSOC);
}
}