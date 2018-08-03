<?php

//getVendedor

require_once '../database/Conexao.php';
require_once '../models/Vendedor.php';

class CrudVendedor{

    private $conexao;

    public function __construct(){
        $this->conexao = Conexao::getConexao();
    }

    //cadastrar vendedor
    //OKAY
    public function cadastrar($usuario){

        $sql = "INSERT INTO usuarios (nome, email, senha, telefone) VALUES ('{$usuario->getNome()}', '{$usuario->getEmail()}', '{$usuario->getSenha()}', '{$usuario->getTelefone()}')";

        $this->conexao->exec($sql);

        $id = $this->conexao->lastInsertId(); //pega o ultimo id cadastrado

        $sql = "INSERT INTO vendedor (cpf, empresa, id_usuarios, idVendedor) VALUES ('{$usuario->cpf}', '{$usuario->empresa}', '{$id}', {$usuario->idVendedor})";

        $this->conexao->exec($sql);

    }

    //retorna todos os vendedors em forma de um array associativo
    //OKAY
    public function getVendedores(){
        $sql = "select * from vendedor, usuarios";
        $vendedores = $this->conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        print_r($vendedores);
    }

    //retorna um vendedor em forma de array associativo - OKAY
    public function getVendedor($idVendedor, $idUsuarios){
        $consulta = $this->conexao->query("SELECT * FROM vendedor, usuarios WHERE idUsuarios = $idUsuarios and idVendedor  = $idVendedor ");
        $vendedor = $consulta->fetch(PDO::FETCH_ASSOC);

        //print_r($vendedor);

        return new Vendedor($vendedor['nome'], $vendedor['email'], $vendedor['senha'], $vendedor['telefone'], $vendedor['cpf'], $vendedor['empresa'], $vendedor['idVendedor']);
    }

    //excluir vendedor
    //OKAY
    public function excluir($idVendedor){
        $this->conexao->exec("DELETE FROM vendedor WHERE idVendedor = $idVendedor");
    }

}

$ven = new Vendedor("Cidral","bru@teste.com", "123", 99897766, 8987654, "Casas Bahia");

$crud = new CrudVendedor();

//OKAY
//$crud->cadastrar($ven);

//OKAY - TELA INICIO
//$crud->getVendedor(1, 4);

//OKAY - TERMINAL
//$crud->getVendedores();

