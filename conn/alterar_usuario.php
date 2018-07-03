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


if (isset($_GET['idUsr'])){

    $idUsuario = $_GET['idUsr'];

    //Verificação de quais campos foram preenchidos 
    if (!empty($_POST['email']) and !is_null($_POST['email'])) {
        $email = mysqli_escape_string($connect, $_POST['email']);
        $sql = "UPDATE usuario set email = '".$email."' WHERE idUsuario = $idUsuario;";

        //Verifica se é possível realizar as alterações
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Dados atualizados com sucesso.";

        //Caso não seja possível é exibido uma mensagem de erro.
        } else {
            $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
            $erro = 1;
            
        }   
    }

    if (!empty($_POST['telefone']) and !is_null($_POST['telefone'])) {
        $telefone = mysqli_escape_string($connect, $_POST['telefone']);
        $sql = "UPDATE usuario set telefone = '".$telefone."' WHERE idUsuario = $idUsuario;";

        //Verifica se é possível realizar as alterações
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Dados atualizados com sucesso.";

        //Caso não seja possível é exibido uma mensagem de erro.
        } else {
            $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
            $erro = 1;
            
        }   
    }    

    if (!empty($_POST['campus']) and !is_null($_POST['campus'])) {
        $campus = mysqli_escape_string($connect, $_POST['campus']);
        $sql = "UPDATE usuario set idCampus = ".$campus."  WHERE idUsuario = $idUsuario;";

        //Verifica se é possível realizar as alterações
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Dados atualizados com sucesso.";

        //Caso não seja possível é exibido uma mensagem de erro.
        } else {
            $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
            $erro = 1;
            
        }   
    }    

    if (!empty($_POST['perfil']) and !is_null($_POST['perfil'])) {
        $perfil = mysqli_escape_string($connect, $_POST['perfil']);
        $sql = "UPDATE usuario set idPerfil = ".$perfil."  WHERE idUsuario = $idUsuario;";

        //Verifica se é possível realizar as alterações
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Dados atualizados com sucesso.";

        //Caso não seja possível é exibido uma mensagem de erro.
        } else {
            $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
            $erro = 1;
            
        }   

    }
    
    if (!empty($_POST['login']) and !is_null($_POST['login'])) {
        $login = mysqli_escape_string($connect, $_POST['login']);
        $login = strtolower($login);

        //Verifica se já há um login igual no sistema.
        $verifica_login = " SELECT usu.* FROM usuario usu
                            WHERE usu.login = '$login';";

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
            $sql = "UPDATE usuario set login = '".$login."'  WHERE idUsuario = $idUsuario;";

            //Verifica se é possível realizar as alterações
            if (mysqli_query($connect, $sql)) {
                $_SESSION['mensagem'] = "Dados atualizados com sucesso.";
    
            //Caso não seja possível é exibido uma mensagem de erro.
            } else {
                $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
                $erro = 1;
            }   

        }
        
    }

    if (!empty($_POST['senha']) and !is_null($_POST['senha'])) {

        //Verificação das senha digitadas
        if ($_POST["senha"] === $_POST["confirma_senha"]) {
            
            $senha = mysqli_escape_string($connect, $_POST['senha']);
       
            //Criando o hash da senha para inserção no banco de dados
            $hash_senha = md5($senha);
            $sql = "UPDATE usuario set senha  = '".$hash_senha."'  WHERE idUsuario = $idUsuario;";

            //Verifica se é possível realizar as alterações
            if (mysqli_query($connect, $sql)) {
                $_SESSION['mensagem'] = "Dados atualizados com sucesso.";
    
            //Caso não seja possível é exibido uma mensagem de erro.
            } else {
                $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
                $erro = 1;
            }   

        }else {
         
            $_SESSION['mensagem'] = "As senhas devem ser iguais.<br>";
            $erro = 1;

        }
        
    }

     
    //Verificação se há algum arquivo
    if ($_FILES['foto']['name'] <> "") {           

        //Extensão do arquivo
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

        //Pasta onde o arquivo será transferido
        $pasta = "users/user_img/";
        //Nome temporário do arquivo
        $temporario = $_FILES['foto']['tmp_name'];


        $sql = "SELECT CONCAT(LPAD ($idUsuario, 5, '0')) as nome_imagem";
        $retorno = mysqli_query($connect, $sql);
        $nome = mysqli_fetch_array($retorno);
        $novoNome = $nome['nome_imagem'].".$extensao";

        //Verifica se já há alguma foto de perfil
        if(!is_null($idArquivo) AND !empty($idArquivo)){
            unlink($pasta.$novoNome);

            //Arquivo sendo renomeado e transferido para a pasta do servidor.
            if (move_uploaded_file($temporario, $pasta.$novoNome)) {                

                $upd_arquivo = "UPDATE arquivos SET dtHora_envio = now() WHERE idArquivo = ".$idArquivo;
                mysqli_query($connect, $ins_arquivo);
                
            } else {
                $_SESSION['mensagem']  = $_SESSION['mensagem']."<br> Não foi possível realizar a alteração da imagem de perfil. Favor verificar se a imagem não possui mais de 2MB.";
                $erro = 1;                                                                              
            } 
        }else{
        
            //Arquivo sendo renomeado e transferido para a pasta do servidor.
            if (move_uploaded_file($temporario, "../".$pasta.$novoNome)) {                

                $ins_arquivo = "INSERT INTO arquivos (nome_arquivo, extensao_arquivo, local_arquivo, idUsuario, dtHora_envio)
                                VALUE ('$novoNome', '$extensao', '$pasta', $idUsuario, now())";
                
                //verifica se foi possível inserir o caminho do arquivo no banco
                if (mysqli_query($connect, $ins_arquivo)) {                    

                    $idArquivo = mysqli_insert_id($connect);
                    
                    //Realizado update no usuário para redirecionar para a nova foto.
                    $ins_arquivo = "UPDATE usuario SET idArquivo = ".$idArquivo." WHERE idUsuario = ".$idUsuario;

                    mysqli_query($connect, $ins_arquivo);

                //Caso não tenha sido possível, é informado.
                } else {
                    $_SESSION['mensagem'] = $_SESSION['mensagem']."<br> Não foi possível realizar a alteração da imagem de perfil. Favor verificar se a imagem não possui mais de 2MB.";
                    $erro = 1;                                                                              
                } 

            } else {
                $_SESSION['mensagem']  = $_SESSION['mensagem']."<br> Não foi possível realizar a alteração da imagem de perfil. Favor verificar se a imagem não possui mais de 2MB.";
                $erro = 1;                                                                              
            }        
        } 
    } 

    
} else {
    $_SESSION['mensagem'] = "Nã foi possível recuperar o usuário.<br>";
    $erro = 1;
}


 //Se não houve erros, é realizada a tentativa de inserir as alterações do usuário no banco
if ($erro == 0) {
    header('Location: ../usuario.php?idUsr='.$idUsuario);
} else {
    //Caso tenha ocorrido algum erro, é retornado uma mensagem com eles.
    $_SESSION['mensagem'] = "Ocorreram um ou mais erros. ".$_SESSION['mensagem'];
    header('Location: ../usuario.php?idUsr='.$idUsuario);
}

?>