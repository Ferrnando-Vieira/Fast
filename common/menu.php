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
                <a class="navbar-brand" href="<?php echo $home; ?>">Olá, <?php echo $dados_user['nome']; ?> </a> 
            </div>


            <!-- Barra de último acesso e saída do sistema -->
            <div class = "ultimoAcesso"> Último acesso : <?php echo DATE('d/m/Y H:i:s', strtotime($ultimo_acesso)); ?> &nbsp;
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
                        <a <?php if ($_SERVER['PHP_SELF'] == "/home.php") { echo "class='active-menu' "; } ?>  href="home.php">
                            <i class="fa fa-bolt fa-3x" aria-hidden="true"></i> Abrir chamado
                        </a>
                    </li>
                    
                    <li> <a <?php if ($_SERVER['PHP_SELF'] == "/acompanhamento.php") { echo "class='active-menu' "; } ?> href="acompanhamento.php">            
                            <i class="fa fa-table fa-3x"></i> 
                            <?php
                                if ($perfil == 1) {
                                    echo 'Acompanhamento';
                                } else {
                                    echo 'Fila de Chamados';
                                }
                            ?>
                        </a> 
                    </li>
                                            
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-3x"></i> 
                        
                        <?php
                            if ($perfil == 1) {
                                echo 'Histórico';
                            } else {
                                echo 'Chamados por Status';
                            }
                        ?>                        
                        <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="acompanhamento.php">Abertos</a> </li>
                            <li> <a href="acompanhamento.php">Em atendimento</a> </li>                        
                            <li> <a href="acompanhamento.php">Resolvidos</a> </li>                                             
                        </ul>
                    </li>  

                    <li> <a <?php if ($_SERVER['PHP_SELF'] == "/contato.php") { echo "class='active-menu' "; } ?> href="contato.php"><i class="fa fa-square-o fa-3x"></i>Contatos</a> </li>

                </ul> 
            </div>        
        </nav>  
        <!-- Fim Menu Lateral -->