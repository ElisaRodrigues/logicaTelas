<?php

//ARRUMAR O getVendedor

require_once '../database/Conexao.php';
require_once '../models/Administrador.php';

class CrudAdministrador{

    private $conexao;

    public function __construct(){
        $this->conexao = Conexao::getConexao();
    }

    //cadastrar user
    //OKAY
    public function cadastrar($usuario){

        $sql = "INSERT INTO usuarios (nome, email, senha, telefone) VALUES ('{$usuario->getNome()}', '{$usuario->getEmail()}', '{$usuario->getSenha()}', '{$usuario->getTelefone()}')";
        $this->conexao->exec($sql);

        $id = $this->conexao->lastInsertId(); //pega o ultimo id cadastrado
        $sq = "INSERT INTO administrador (razao_social, nome_fantasia, cnpj, id_usuarios) VALUES ('{$usuario->razao_social}', '{$usuario->nome_fantasia}', '{$usuario->cnpj}', '{$id}')";
        $this->conexao->exec($sq);
    }

    //retorna todos os users em forma de um array associativo
    //OKAy
    public function getAdministradores(){
        $sql = "select * from administrador, usuarios";
        $administradores = $this->conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        print_r($administradores);
    }

    //retorna um produto em forma de array associativo
    //EM PRODUÇÃO -- indefinido nome, email,senha, telefone,  id (o que esta cadastrado na table usuarios)
    public function getAdministrador($idAdministrador){
        //$consulta = $this->conexao->query("SELECT * FROM administrador WHERE idAdministrador  = $idAdministrador");
       // $administrador = $consulta->fetch(PDO::FETCH_ASSOC);

          $sql = "SELECT usuarios.nome,email,senha,telefone, administrador.razao_social,nome_fantasia,cnpj
                  FROM administrador INNER JOIN usuarios ON administrador.id_usuarios = usuarios.idUsuarios
                  WHERE usuaros.idUsuarios = id_usuarios ";

          $administrador = $this->conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        print_r($administrador);

        return new Administrador($administrador['nome'], $administrador['email'], $administrador['senha'], $administrador['telefone'], $administrador['razao_social'], $administrador['nome_fantasia'], $administrador['cnpj'], $administrador['id']);

    }

    //excluir administrador
    //OKAY
    public function excluir($idAdministrador){
        $this->conexao->exec("DELETE FROM administrador WHERE idAdministrador = $idAdministrador");
    }
}

$adm = new Administrador("elie","elie@teste.com", "123", 65432189, "elie", "elie" ,46587427649);

$crud = new CrudAdministrador();

$crud->getAdministrador(1);

//$crud->cadastrar($adm);

//$crud->excluir(9);