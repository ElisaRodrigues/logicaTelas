<?php

require_once __DIR__. '../crud/CrudAdministrador.php';
require_once __DIR__. '../models/Administrador.php';
require_once __DIR__. '../views/tela_perfil_admin.php';

function cadastrarAdmin(){
    $crud = new CrudAdministrador();
    include '../views/cadastro_admin.html';
}

function salvarAdmin(){ //DANDO ERRO
    echo "<pre>";

    $usuario = new Administrador($_POST['nome'], $_POST['email'], $_POST['senha'],  $_POST['telefone'], $_POST['razao_social'], $_POST['nome_fantasia'], $_POST['cnpj']);
    $adm = new CrudAdministrador();
    $resultado = $adm->cadastrar($usuario);

    header("Location: usuario_controller.php");
}

function listarAdmins(){
    $crud = new CrudAdministrador();
    $listaAdmins = $crud->getAdministradores();
    //require '../views/tela_perfil_admin.php';
}

function editar ($id){
/*    $crud     = new CrudProdutos();
    $tipos = $crud->getTiposProduto();
    $tamanhos = $crud->getTamanhos();
    $cores =  $crud->getCores();
    $produto  = $crud->getProduto($id);
    //include '../views/editar_produto.php';
*/
}

function excluirAdmin($id){
    $crud = new CrudAdministrador();
    $crud->excluir($id);
    listarAdmins();
}

//ROTAS
if (isset($_GET['acao']) && !empty($_GET['acao']) ) {

    if ($_GET['acao'] == 'cadastrar') {
        echo "chegou na rota";
        cadastrarAdmin();

    } elseif ($_GET['acao'] == 'salvar') {
        salvarAdmin();

    } elseif ($_GET['acao'] == 'editar') {
        editar($_GET['id']);

    } elseif ($_GET['acao'] == 'excluir') {
        excluirAdmin($_GET['id']);

    } elseif ($_GET['acao'] == 'listar') {
        listarAdmins();

    } else {
        //echo "sera redirecionado pra lista";
        require '../views/cadastro_admin.html';
    }
} else {
    require '../views/cadastro_admin.html';
}