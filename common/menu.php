<?php $pagina_atual = $_SERVER['PHP_SELF']; ?>

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
                    <!-- Link na imagem do usuário para a tela de alteração dos dados -->
                    <?php echo "<a href='usuario.php?idUsr=".$id."'>"; ?>
                        <li class="text-center">
                            <img src="img/find_user.png" class="user-image img-responsive"/>
                        </li>            
                    </a>
                    <li>
                        <a <?php if ($pagina_atual == "/home.php") { echo "class='active-menu' "; } ?>  href="home.php">
                            <i class="fa fa-bolt fa-3x" aria-hidden="true"></i> Abrir Novo
                        </a>
                    </li>
                    
                    <li> <a <?php if ($pagina_atual == "/acompanhamento.php?status=0") { echo "class='active-menu' "; } ?> href="acompanhamento.php?status=0">            
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
                        <a href="#" ><i class="fa fa-sitemap fa-3x"></i> 
                        
                        <?php
                            if ($perfil == 1) {
                                echo 'Histórico';
                            } else {
                                echo 'Chamados por Status';
                            }
                        ?>                        
                        <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php 

                                $sql = "SELECT *
                                        FROM  statusChamado
                                        ORDER BY idStatus ";
                                        
                                $status = mysqli_query ($connect, $sql);

                                while ($dados = mysqli_fetch_array($status)) {
                                    echo "<li> <a href='acompanhamento.php?status=".$dados['idStatus']."'>".$dados['nomeStatus']."</a> </li>";
                                };

                            ?>                                            
                        </ul>
                    </li>  

                    <?php 
                        if (!$usuario_comum) {     

                            echo "<li> <a ";
                            if ($pagina_atual == "/acompanhamento.php?status=0&idUsr=".$id) { 
                                echo "class='active-menu' "; 
                            } 
                            echo "href='acompanhamento.php?status=0&idUsr=".$id."'>            
                                    <i class='fa fa-tv fa-3x'></i> 
                                    Meus Atendimentos
                                </a> 
                            </li>";

                            echo "<li> <a ";
                            if ($pagina_atual == "/buscar.php" or $pagina_atual == "/usuario.php") { 
                                echo "class='active-menu' "; 
                            } 
                            echo "href='buscar.php'>            
                                    <i class='fa fa-group fa-3x'></i> 
                                    Buscar Usuário
                                </a> 
                            </li>";

                            echo "<li> <a ";
                            if ($pagina_atual == "/cadastro.php") { 
                                echo "class='active-menu' "; 
                            } 
                            echo "href='cadastro.php'>            
                                    <i class='fa fa-user-plus fa-3x'></i> 
                                    Criar Usuário
                                </a> 
                            </li>";                            
                        } 
                    ?>

                    <li> 
                        <a <?php if ($pagina_atual == "/contato.php") { echo "class='active-menu' "; } ?> href="contato.php">
                        <i class="fa fa-id-card fa-3x"></i>Contatos</a> 
                    </li>
                    
                </ul> 
            </div>        
        </nav>  
        <!-- Fim Menu Lateral -->