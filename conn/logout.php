<?php
    //Fim de sessão

    session_start();
    session_unset();
    session_destroy();

    //Página onde o usuário será redirecionado
    header('Location: ../index.php');
?>