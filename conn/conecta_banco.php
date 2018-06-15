<?php

//Nome do servidor
Define (_SERVIDOR, "");

//Usuário do Banco
Define (_LOGIN, "");

//Senha do Banco 
Define (_SENHA, "");

//Nome do Banco
Define (_DBNAME, "");

// Conexão com o Banco de Dados
$connect = mysqli_connect (_SERVIDOR, _LOGIN, _SENHA, _DBNAME);

//Alterando codificação para UTF-8
mysqli_set_charset($connect, "utf8");

if (mysqli_connect_error()) {
    
    //Varival com o erro da conexão
    $GLOBALS['$erro_conexao'];
    $erro_conexao = "Falha de conexão: ".mysqli_connect_error();
}

?>