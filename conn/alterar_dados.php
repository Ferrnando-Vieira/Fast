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

$sql = "";

if (isset($_GET['idUsr'])){

    $idUsuario = $_GET['idUsr'];

    //Verificação de quais campos foram preenchidos e concatena com a string de inserção dos mesmos.
    if (!empty($_POST['email']) and !is_null($_POST['email'])) {
        $email = mysqli_escape_string($connect, $_POST['email']);
        $sql = $sql."UPDATE usuario set email = ".$email." WHERE idUsuario = $idUsuario;";
    }

    if (!empty($_POST['telefone']) and !is_null($_POST['telefone'])) {
        $telefone = mysqli_escape_string($connect, $_POST['telefone']);
        $sql = $sql."UPDATE usuario set telefone = ".$telefone." WHERE idUsuario = $idUsuario;";
    }    

    if (!empty($_POST['campus']) and !is_null($_POST['campus'])) {
        $campus = mysqli_escape_string($connect, $_POST['campus']);
        $sql = $sql."UPDATE usuario set idCampus = ".$campus."  WHERE idUsuario = $idUsuario;";
    }    

    if (!empty($_POST['perfil']) and !is_null($_POST['perfil'])) {
        $perfil = mysqli_escape_string($connect, $_POST['perfil']);
        $sql = $sql."UPDATE usuario set idPerfil = ".$perfil."  WHERE idUsuario = $idUsuario;";
    }
    
    if (!empty($_POST['login']) and !is_null($_POST['login'])) {
        $login = mysqli_escape_string($connect, $_POST['login']);
        $login = strtolower($login);

        //Verifica se já há um login igual no sistema.
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

        }else{

            //Se não houver usuário repetido é realizado o update.
            $sql = $sql."UPDATE usuario set login = ".$login."  WHERE idUsuario = $idUsuario;";

        }
        
    }

    if (!empty($_POST['senha']) and !is_null($_POST['senha'])) {

        //Verificação das senha digitadas
        if ($_POST["senha"] === $_POST["confirma_senha"]) {
            
            $senha = mysqli_escape_string($connect, $_POST['senha']);
       
            //Criando o hash da senha para inserção no banco de dados
            $hash_senha = md5($senha);
            $sql = $sql."UPDATE usuario set senha  = ".$hash_senha."  WHERE idUsuario = $idUsuario;";

        }else {
         
            $_SESSION['mensagem'] = "As senhas devem ser iguais.<br>";
            $erro = 1;

        }
        
    }
    
} else {
    $_SESSION['mensagem'] = "Nã foi possível recuperar o usuário.<br>";
    $erro = 1;
}


 //Se não houve erros, é realizada a tentativa de inserir as alterações do usuário no banco
if ($erro == 0) {

    //Verifica se é possível realizar o update dos usuários no banco
    if (mysqli_query($connect, $sql)) {

        $_SESSION['mensagem'] = "Dados alterados com sucesso.";
        header('Location: ../usuario.php?idUsr='.$idUsuario);
        
    //Caso não tenha sido criado é exibido uma mensagem de erro.
    } else {
        $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
        header('Location: ../usuario.php?idUsr='.$idUsuario);
    }
} else {
    //Caso tenha ocorrido algum erro, é retornado uma mensagem com eles.
    $_SESSION['mensagem'] = "Não foi possível alterar os dados. ".$_SESSION['mensagem'];
    header('Location: ../usuario.php?idUsr='.$idUsuario);
}

?>