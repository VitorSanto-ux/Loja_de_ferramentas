<?php

require_once "C:/Turma2/xampp/htdocs/mvc/mvc/Model/ProdutoModel.php";

class ProdutoController
{
    private $produtoModel;

    public function __construct($pdo)
    {
        $this->produtoModel = new ProdutoModel($pdo);
    }

    public function listar()
    {
        $produtos = $this->produtoModel->buscarTodos();
        return $produtos;
    }

    public function buscarProduto($id)
    {
        $produto = $this->produtoModel->buscarProduto($id);
        return $produto;
    }

    public function cadastrar($nome, $descricao, $minimo, $estoque)
    {
        return $this->produtoModel->cadastrar(
            $nome,
            $descricao,
            $minimo,
            $estoque
        );
    }

    public function editar($nome, $descricao, $minimo, $estoque, $id)
    {
        return $this->produtoModel->editar(
            $nome,
            $descricao,
            $minimo,
            $estoque,
            $id
        );
    }

    public function deletar($id)
    {
        return $this->produtoModel->deletar($id);
    }
}