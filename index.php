<!DOCTYPE html>
<?php
    //Conexão com o banco
    require_once 'conn/login.php';
    $erros = array();

    //verifica se houve erro na conexão
    if (!empty($erro_conexao)) {
       $erros [] = "<center>
                        <h3>Houve um erro de conexão.</h3>
                    </center><br>";
    }

    //Inicia sessão
    session_start();

    //Verifica se os dados estão corretos
    if (isset($_POST['enviar'])){
       
        $login = mysqli_escape_string($connect, $_POST['login']);
        $senha = mysqli_escape_string($connect, $_POST['senha']);

        $sql = "SELECT 
                    usu.*
                FROM 
                    usuario usu
                WHERE
                        usu.login = lower('$login') 
                    AND usu.senha = (SELECT PASSWORD('$senha')) ";

        $retorno = mysqli_query($connect, $sql);

        if (mysqli_num_rows($retorno) == 0) {
            $erros[] = "<center>
                            <h3>Usuário ou Senha incorretos.</h3>
                        </center><br>";
        } else {
            $dados = mysqli_fetch_array($retorno);
            $_SESSION['logado'] = true;
            $_SESSION['idUsuario'] = $dados ['idUsuario'];
            header('Location: home.php');
        }
    }
?>

<html>

    <head>
        <meta charset="utf-8">      
        <title>Fast Suporte</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="192x192" href="img/icon/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">   
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="theme-color" content="#2179af"> 
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    
    </head>     
  
    <body>
        
        <!--Card-->
        <div class="card animated fadeIn">
            <!-- Logo animada -->
            <center><img class="center animated rollIn logo_raio" src="img/fast_logo.png" alt="logo"></center>
            <hr>
            <!-- Logo completa -->
            <img class="logo_full" src="img/fast_full.png">  
            <!-- Formulário de Login -->     
            <div id="sidebar">
                <div style="width: 100%;">
                    <div class="container">
                                <?php
                                    // Se houver erros será exibido mensagem
                                    if(!empty($erros)) {
                                       foreach ($erros as $erro){
                                           echo $erro;
                                       }
                                    }
                                ?>

                        <div class="wrapper">
                            <form class="form-signin" action="" method="POST">
                                
                                <input type="text" size="34" class="form-control" name="login" placeholder="Usuário" required="" autofocus="" style="width: 100%;" /><br />
                                <input type="password" size="34" class="form-control" name="senha" placeholder="Senha" required="" style="width: 100%;" />
                                <center> 
                                    <a href="#">
                                        <button type="submit" class="button location" name="enviar"> Enviar </button>
                                    </a>
                                </center>
                                <br>
                            </form>                            
                        </div>
                    </div>
                </div> 
            </div>  

            <div class="esqsenha">
                <center> <a href="#" style="color:#2179AF">Esqueceu a senha?</a></center>
            </div>

            <p class="icons animated pulse">                    
                <span class="fa-stack fa-lg"> </span>            
            </p>
        </div>
        
    </body>

   <!--footer-->
    <footer class="animated fadeIn">
        &copy; 2018 Fast.
    </footer>
   
</html>
