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

//Verificar se é possível pegar o id do chamado
if (isset($_GET['idChamado'])) {
    $idChamado = $_GET['idChamado'];
}else{
    $_SESSION['mensagem'] = "Não foi possível salva as alterações, código do chamado não identificado.";
    header('Location: ../acompanhamento.php?status=0');   
}

//Verificar se a opção de mostrar a observação foi selecionada
if (isset($_POST['mostrarObs'])){
    header("Location: ../detalhamento.php?idChamado=".$idChamado."&mostrarObs=true");


//Verificar se a opção de apropriação de chamado foi selecionada
} elseif (isset($_POST['apropriar'])) {

    $sql = "UPDATE chamado SET idUsuarioNSI = ".$id." WHERE idChamado = ".$idChamado;

    if (mysqli_query($connect, $sql)) {
        $_SESSION['mensagem'] = "Chamado apropriado com sucesso.";    
    } else {
        $_SESSION['mensagem'] = "Não foi possível apropriar o chamado, tente novamente mais tarde";
    }

    //Chamados apropriados vão para o status Em atendimento
    $sql = "UPDATE chamado SET idStatus = 2 WHERE idChamado = ".$idChamado;

    mysqli_query($connect, $sql);

    header("Location: ../detalhamento.php?idChamado=".$idChamado); 


//Verificar se a opção de desapropriação de chamado foi selecionada
} elseif (isset($_POST['desapropriar'])) {    
    
    if (empty($_GET['idResponsavel'])) {
        $_SESSION['mensagem'] = "Não foi possível realizar a desapropriação, o chamado não possui responsável.";
        header("Location: ../detalhamento.php?idChamado=".$idChamado);
    } else {
    $sql = "UPDATE chamado SET idUsuarioNSI = NULL WHERE idChamado = ".$idChamado;
    
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Chamado desapropriado com sucesso.";    
        } else {
            $_SESSION['mensagem'] = "Não foi possível desapropriar o chamado, tente novamente mais tarde";
        }
    
    
    //Chamado desapropriados mudam para o status aberto
    $sql = "UPDATE chamado SET idStatus = 1 WHERE idChamado = ".$idChamado;

    mysqli_query($connect, $sql);

    $observacao = "Chamado desapropriado.";
    $observacao = mysqli_escape_string($connect, $observacao);

    $sql = "INSERT INTO observacaoChamado (idChamado, idUsuario, datahoraObservacao, descricaoObservacao)
    VALUES ($idChamado, $id, now(),'$observacao' ); ";

    mysqli_query($connect, $sql);

    header("Location: ../detalhamento.php?idChamado=".$idChamado);    
        
    }
//Se foi inserção de observação/alteração de status
} else {  
    
    $observacao = mysqli_escape_string($connect, $_POST['observacao']);
    $status = mysqli_escape_string($connect, $_POST['status']);
   
    $sql = "UPDATE chamado SET idUsuarioNSI = ".$id." WHERE idChamado = ".$idChamado."; ";

        //Verifica se é possível realizar as alterações
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Chamados atualizado com sucesso.";            
        //Caso não seja possível é exibido uma mensagem de erro.
        } else {
            $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
            die();
        } 

    if (!empty ($observacao) and !is_null($observacao)) {

        $sql = "INSERT INTO observacaoChamado (idChamado, idUsuario, datahoraObservacao, descricaoObservacao)
                VALUES ($idChamado, $id, now(),'$observacao' ); ";

        //Verifica se é possível realizar as alterações
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Chamados atualizado com sucesso.";

        //Caso não seja possível é exibido uma mensagem de erro.
        } else {
            $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
            die();
        }                
    }
    
    if (!empty ($status) and !is_null($status)) {

        $sql = "UPDATE chamado SET idStatus = $status WHERE idChamado = $idChamado; ";    

        //Verifica se é possível realizar as alterações
        if (mysqli_query($connect, $sql)) {
            $_SESSION['mensagem'] = "Chamados atualizado com sucesso.";                 
        //Caso não tenha sido criado é exibido uma mensagem de erro.
        } else {
            $_SESSION['mensagem'] = "Não foi possível alterar os dados, tente novamente mais tarde.";
            die();
        }  
    }
 
    header("Location: ../detalhamento.php?idChamado=".$idChamado); 

}

?>