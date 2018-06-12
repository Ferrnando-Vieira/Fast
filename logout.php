<?php
    //Fim de sessão

    session_start();
    session_unsert();
    session_destroy();
    header('Location: index.php');
?>