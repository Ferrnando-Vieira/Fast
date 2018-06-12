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
        <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
                    <a href="conn/logout.php" class="btn btn-danger square-btn-adjust">Sair</a> 
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
        
            <!-- Ínicio do agrupamento de chamados -->
            <div id="page-wrapper" >
                <div id="page-inner">
                    <!-- Titulo da pagina --> 
                    <center>
                        <div class="row">
                            <div class="col-md-12">
                            <h2>Acompanhamento de Chamados</h2>                         
                            </div>
                        </div>
                    </center>
                    <hr/>
                <!-- Fim do Título da Página -->

                <div class="row">
                    <div class="col-md-12">
                        <!-- Tabela de chamados -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Acompanhamento de Chamados
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Chamado</th>
                                                <th>Responsável</th>
                                                <th>Data</th>
                                                <th>Local</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td>000001</td>
                                                <td>Fernando Vieira</td>
                                                <td>18/06/2018</td>
                                                <td class="center">Sala 1004</td>
                                                <td class="center">Em atendimento</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>                            
                            </div>
                        </div>
                        <!--Fim da tabela de chamados -->
                    </div>
                </div>                  
            </div>
            <!-- Fim do agrupamento de chamados -->
        </div>  
        <!-- Fim do corpo -->

        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <script src="js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="js/dataTables/jquery.dataTables.js"></script>
        <script src="js/dataTables/dataTables.bootstrap.js"></script>
            <script>
                $(document).ready(function () {
                    $('#dataTables-example').dataTable();
                });
        </script>
            <!-- CUSTOM SCRIPTS -->
        <script src="js/custom.js"></script>
       
    </body>
</html>
