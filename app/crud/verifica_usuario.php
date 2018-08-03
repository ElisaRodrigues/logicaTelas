<?php
    session_start();

function login(){
    $login = $_POST['email'];
	$senha = $_POST['senha'];

	$usuarios = file_get_contents('usuarios.json');
    $usuarios = json_decode($usuarios, true);


/*
    //usuario
    $sql ="SELECT email, senha FROM usuarios WHERE email = {$login} and senha = {$senha}";
    $usuario = $sql->fetchAll(PDO::FETCH_ASSOC);
    //usuarios
    $sql = "SELECT * FROM usuarios";
    $usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
*/


$usuario_existe = false;

    foreach ($usuarios as $usuario){

        if ($login == $usuario['email'] && $senha == $usuario['senha'] ) {

            $usuario_existe = true;
            //deu certo;
            $_SESSION['usuario_login']  = $login;
            $_SESSION['usuario_senha']  = $senha;
            $_SESSION['usuario_online'] = true;

            //redirecionar
           // if ($)
            header('Location: ../views/tela_perfil_admin.php');

        }
    }

    if ($usuario_existe == false){
        header('Location: ../views/login.html');
    }

}


function logout(){
    session_destroy();
    header('Location: ../views/login.html');
}

if ($_GET['acao'] == 'login'){
    login();
} elseif($_GET['acao'] == 'logout') {
    logout();
}
