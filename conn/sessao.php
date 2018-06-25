<?php
    //Conexão com o banco
    require_once 'conn/conecta_banco.php';
    $erros = array();

    //verifica se houve erro na conexão
    if (!empty($erro_conexao)) {
       $erros [] = "<center>
                        <h3>Houve um erro de conexão.</h3>
                    </center><br>";
    }

    //Inicia sessão
    session_start();

    // Verifica sessão
    if (!isset($_SESSION['logado'])){
        header('Location: index.php');
    }



    //Dados do usuário
    $id = $_SESSION['idUsuario'];
    $sql = "SELECT usu.* FROM usuario usu WHERE usu.idUsuario = $id ";
    $sql_user = mysqli_query($connect, $sql);
    $dados_user = mysqli_fetch_array($connect,$sql_user);

?>
