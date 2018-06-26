<?php
//Inicia conexão
require_once 'conecta_banco.php';


//Inicia sessão
session_start();

// Verifica sessão
if (!isset($_SESSION['logado'])){
    header('Location: index.php');
}

//Id do usuario que abriu sessão
$id = $_SESSION['idUsuario'];

$erro = 0; // 0 = sem erro, 1 = com erro


$nome = mysqli_escape_string($connect, $_POST['nome']);
$sobrenome = mysqli_escape_string($connect, $_POST['sobrenome']);
$email = mysqli_escape_string($connect, $_POST['email']);
$telefone = mysqli_escape_string($connect, $_POST['telefone']);
$genero = mysqli_escape_string($connect, $_POST['genero']);
$campus = mysqli_escape_string($connect, $_POST['campus']);
$perfil = mysqli_escape_string($connect, $_POST['perfil']);
$login = mysqli_escape_string($connect, $_POST['login']);
$login = strtolower($login);

//Verificação das senha digitadas
if ($_POST["senha"] === $_POST["confirma_senha"]) {
    $senha = mysqli_escape_string($connect, $_POST['senha']);

    //Criando o hash da senha para inserção no banco de dados
    $hash_senha = md5($senha);
 }
 else {
    $_SESSION['mensagem'] = "As senhas devem ser iguais.<br>";
    $erro = 1;
 }

$verifica_login = " SELECT usu.* FROM usuario usu
                    WHERE usu.login = $login;";

$retorno = mysqli_query($connect, $verifica_login);

//Se há retorno então já existe login
if (mysqli_num_rows($retorno)>=1){
    if (is_null($_SESSION['mensagem'])) {
        $_SESSION['mensagem'] = "Já existe um usuário com este Login.";
        $erro = 1;
    } else {
        $_SESSION['mensagem'] = $_SESSION['mensagem']."Já existe um usuário com este Login.";
        $erro = 1;
    }
}

 //Se não houve erros, é realizada a tentativa de inserir o usuário no banco
if ($erro == 0) {

    // SQL para criação do usuário
    $ins_usuario = "INSERT INTO usuario (idPerfil,idCampus, nome, sobrenome, email, telefone ,genero, login, senha) 
                    VALUES ($perfil, $campus, '$nome', '$sobrenome', '$email', '$telefone','$genero', '$login', '$hash_senha');";

    //verifica se foi possível criar o usuário
    if (mysqli_query($connect, $ins_usuario)) {

        $_SESSION['mensagem'] = "Usuário criado com sucesso.";
        header('Location: ../cadastro.php');
        
    //Caso não tenha sido criado é exibido uma mensagem de erro.
    } else {
        $_SESSION['mensagem'] = "Não foi possível criar o usuário, tente novamente mais tarde.";
        header('Location: ../cadastro.php');
    }
} else {
    //Caso tenha ocorrido algum erro, é retornado uma mensagem com eles.
    $_SESSION['mensagem'] = "Não foi possível criar o usuário. ".$_SESSION['mensagem'];
    header('Location: ../cadastro.php');
}

?>