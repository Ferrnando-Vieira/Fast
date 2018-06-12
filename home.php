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

    // Verifica sessão
    if (!isset($_SESSION['logado'])){
        header('Location: index.php');
    }


    //Dados do usuário
    $id = $_SESSION['idUsuario'];
    $sql = "SELECT 
                usu.*
            FROM 
                usuario usu
            WHERE
                usu.idUsuario = $id ";
    $retorno = mysqli_query($connect, $sql);
    $dados= mysqli_fetch_array($retorno);
    mysqli_close($connect);
?>

<html>

    <head>
        <meta charset="utf-8">
        <title>Fast Suporte</title> 
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">               
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link href="css/font-awesome.css" rel="stylesheet" />
        <link href="js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <link href="css/custom.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />     
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

    <!-- Inicio Corpo -->
    <div id="wrapper">         

        <!-- Menu Superior -->
        <nav class="navbar navbar-default navbar-cls-top painelNome" role="navigation" >
            <!--Caixa com nome do usuário -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Olá, <?php echo $dados['nome']; ?> </a> 
            </div>


            <!-- Barra de último acesso e saída do sistema -->
            <div class = "ultimoAcesso"> Último acesso : 09 de Junho de 2018 &nbsp;
                <a href="logout.php" class="btn btn-danger square-btn-adjust">Sair</a> 
            </div>

        </nav>   
        <!-- Fim Menu Superior -->

        <!-- Menu Lateral -->
        <nav class="navbar-default navbar-side" role="navigation">                
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li class="text-center">
                        <img src="img/find_user.png" class="user-image img-responsive"/>
                    </li>            
                    
                    <li>
                        <a class="active-menu"  href="home.php"><i class="fa fa-bolt fa-3x" aria-hidden="true"></i> 
                            Abrir chamado
                        </a>
                    </li>
                    
                    <li> <a href="acompanhamento.php"><i class="fa fa-table fa-3x"></i> Acompanhamento</a> </li>
                                            
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-3x"></i> Histórico<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="acompanhamento.php">Abertos</a> </li>
                            <li> <a href="acompanhamento.php">Em atendimento</a> </li>                        
                            <li> <a href="acompanhamento.php">Resolvidos</a> </li>                                             
                        </ul>
                    </li>  

                    <li> <a href="contato.php"><i class="fa fa-square-o fa-3x"></i>Contatos</a> </li>

                </ul> 
            </div>        
        </nav>  
        <!-- Fim Menu Lateral -->


        <center>
            
            <div id="page-wrapper">

            <div class="row">
                <div class="col-md-12">
                    <h2>Abertura de Chamado</h2>   
                    <h5>Em breve iremos ajuda-lo! </h5>
                </div>
            </div>              

             <hr/>
            
            <form accept-charset="UTF-8" action="enviarDados.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">                        
                        <div class="form-group">                        
                            <label for="subject">Campus</label>
                                <select name="campus" class="form-control" required="required" style="width:50%">
                                    <option value="na" selected="">-</option>
                                    <option value="aimores">Aimorés</option>
                                    <option value="guajajaras">Guajajaras</option>
                                    <option value="barro-preto">Barro Preto</option>
                                    <option value="barro-preto">João Pinheiro 1</option>
                                    <option value="barro-preto">João Pinheiro 2</option>
                                    <option value="linha-verde">Liberdade</option>                                    
                                </select>
                        </div>                   
                    
                        <label for="subject">Local</label>
                        <input type="text" class="form-control" name="local" style="width:50%"
                            placeholder="Ex.: Sala 1004">                
                        <p></p> 

                        <label for="subject">Categoria</label>
                            <select id="subject" name="categoria" class="form-control" required="required" style="width:50%" >
                                <option value="na" selected=""> - </option>
                                <option value="product">Áudio e som</option>
                                <option value="service">Datashow</option>
                                <option value="suggestions">Notebook</option>
                                <option value="product">Tela de Projeção</option>
                                <option value="product">Wifi e Conexões</option>
                                <option value="product">Outros</option>
                            </select>
                            <p></p> 
                        <label for="subject">Descrição:</label> &nbsp
                            <div class="span4 well" style="padding-bottom:0" >
                                <textarea class="span4" name="descricao"
                                    placeholder="Descreva o problema..." rows="10" style="width:50%"></textarea>                                            
                            </div>
                        
                        <div class="row">
                            <center>
                                <div class="col-md-3"></div>                                                                
                                <input type="file" class="custom-file-input col-md-4" name="arquivos []" multiple>                                
                                <div class="col-md-1"></div>
                                <button class="btn btn-primary col-md-1" type = "submit" name="enviar"><i class="fa fa-check"></i> &nbsp Enviar</button> 
                                <div class="col-md-3"></div>
                            </center>
                        </div>                        
                        <p></p><p></p>

                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                        </div> 
                    </div>                      
                </div>
            </form>
            <!-- Rodapé --> 
            <div class="animated fadeIn footer">
                    &copy; 2018 Fast.
            </div>
        </div>
 
        </center>        
        <!-- Fim do centro -->
    </div>
    <!-- Fim Div Corpo -->



<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
<script src="js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="js/jquery.metisMenu.js"></script>
 <!-- MORRIS CHART SCRIPTS -->
 <script src="js/morris/raphael-2.1.0.min.js"></script>
<script src="js/morris/morris.js"></script>
  <!-- CUSTOM SCRIPTS -->
<script src="js/custom.js"></script>


</body>
   
</html>
