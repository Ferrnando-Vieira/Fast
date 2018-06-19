<?php
    //Inicia conexão
    require_once 'conecta_banco.php';

    //inicia sessão
    session_start();

    //Id do usuario que abriu sessão
    $id = $_SESSION['idUsuario'];

    //Atualiza datahora do ultimo acesso 
    $sql = "UPDATE usuario
            SET ultimoAcesso = NOW()
            WHERE idUsuario = $id;";

    
    mysqli_query($connect, $sql);

    //encerra conexão
    mysqli_close ();

    //Finaliza sessão
    session_unset();
    session_destroy();

    //Página onde o usuário será redirecionado
    header('Location: ../index.php');
?>