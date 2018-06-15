<?php

//Inicia sessão
session_start();


//Inicia conexão
require_once 'login.php';

$sql = "SELECT DATE_FORMAT(CURDATE(), '%d/%m/%Y ') as dataAtual;";

$aberturaChamado = mysqli_query($connect, $sql);
$campus = mysqli_escape_string($connect, $_POST['campus']);
$local = mysqli_escape_string($connect, $_POST['local']);
$categoria = mysqli_escape_string($connect, $_POST['categoria']);
$descricao = mysqli_escape_string($connect, $_POST['descricao']);


$ticket;

$ins_chamado = "INSERT INTO chamado (idUsuario,idCampus,idCategoria, local ,dtHoraAbertura, ticket ,descricao) 
                VALUES ($userID, $campus, $categoria, $local ,  ,  , $descricao)";

 // Upload de arquivos multiplos para o servidor
if(isset($_POST['enviar'])){
    $totalArquivos = count($_FILES['arquivos_']['name']);
    $contador = 0;

    while ($contador < $totalArquivos) {    

        //Extensão do arquivo
        $extensao = pathinfo($_FILES['arquivos_']['name'][$contador], PATHINFO_EXTENSION);

        //Pasta onde o arquivo será transferido
        $pasta = "/users/user_uplod/";
        //Nome temporário do arquivo
        $temporario = $_FILES['arquivos_']['tmp_name'][$contador];

        //O nome do arquivo é o ticket concatenado com o numero do arquivo.
        $novoNome = $ticket.$contador.".$extensao";
        
        //Arquivo sendo renomeado e transferido para a pasta do servidor.
        if (move_uploaded_file($temporario, $pasta.$novoNome)) {
           $_SESSION['mensagem'] = "Upload dos arquivos realizado! <br>";
        } else {
           $_SESSION['mensagem'] = "<br> Um ou mais arquivos não puderam ser adicionados!";
        }
        
        $contador++;
    }
}

if (mysqli_query($connect, $ins_chamado)) {
    $_SESSION['mensagem'] = $_SESSION['mensagem']."Chamado aberto com sucesso.";
    header('Location: /home.php?sucesso');
} else
    $_SESSION['mensagem'] = "Não foi possível abrir o chamado. ".$_SESSION['mensagem'];
    header('Location /home.php?erro');


?>
