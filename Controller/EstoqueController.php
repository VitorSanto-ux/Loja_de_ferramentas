<?php

require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Model/EstoqueModel.php";

class EstoqueController
{
    private $estoqueModel;

    public function __construct(PDO $pdo)
    {
        $this->estoqueModel = new EstoqueModel($pdo);
    }

    public function listar()
    {
        return $this->estoqueModel->buscarTodos();
    }

    public function listarProdutos()
    {
        return $this->estoqueModel->buscarProdutos();
    }

    public function cadastrar($id_usuario, $id_produto, $tipo, $quantidade)
    {
        if (
            empty($id_usuario) ||
            empty($id_produto) ||
            !in_array($tipo, ['entrada', 'saida'], true) ||
            !filter_var($quantidade, FILTER_VALIDATE_INT) ||
            $quantidade < 1
        ) {
            return false;
        }

        return $this->estoqueModel->cadastrar(
            $id_usuario,
            $id_produto,
            $tipo,
            $quantidade
        );
        
    }

    public function deletar($id)
    {
        return $this->estoqueModel->deletar($id);
    }

    public function listarUltimasMovimentacoes()
{
    return $this->estoqueModel->buscarUltimasMovimentacoes();
}
}