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
                <a class="navbar-brand" href="#">Olá, <?php echo $dados_user['nome']; ?> </a> 
            </div>


            <!-- Barra de último acesso e saída do sistema -->
            <div class = "ultimoAcesso"> Último acesso : <?php echo $dados_user['ultimoAcesso']; ?> &nbsp;
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