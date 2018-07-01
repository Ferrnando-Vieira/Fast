<!DOCTYPE html>
<?php include_once 'conn/sessao.php'; ?>

<html>

    <header>  
        <?php include_once 'common/header.php'; ?>
        <link href="js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    </header>

    <body>
        <!-- Inicio Corpo -->
        <div id="wrapper">    
                 
            <!-- Menu do sistema -->
            <?php include_once 'common/menu.php'; ?>
        
            <!-- Ínicio do agrupamento de chamados -->
            <div id="page-wrapper" >
                <div id="page-inner">
                    <!-- Titulo da pagina --> 
                    <center>
                        <div class="row">
                            <div class="col-md-12">
                                <h2> Buscar Usuário </h2>                         
                            </div>
                        </div>
                    </center>
                </hr>
                <!-- Fim do Título da Página -->

                <div class="row">
                    <div class="col-md-12">
                        <!-- Tabela de chamados -->
                        <div class="panel panel-default">
                            <div class="panel-heading"></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nome Completo</th>
                                                <th>E-mail</th>
                                                <th>Campus</th>
                                                <th>Telefone</th>
                                                <th>Perfil</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                                                                            
                                            <?php 

                                                if ($perfil != 4) { 
                                                    $condicao = "usu.idPerfil <> 4";
                                                } else {
                                                    $condicao = "1 = 1";
                                                }

                                                $sql = "SELECT
                                                            CONCAT(usu.nome,' ',usu.sobrenome) as nome_completo, usu.email
                                                          , cam.nomeCampus as campus, usu.telefone ,per.nomePerfil as perfil 
                                                          , usu.idUsuario                                                            
                                                        FROM 
                                                            usuario usu
                                                          , perfil per
                                                          , campus cam
                                                        WHERE 
                                                            $condicao
                                                            and usu.idPerfil = per.idPerfil
                                                            and usu.idCampus = cam.idCampus
                                                        ORDER BY
                                                            campus asc, nome_completo asc";

                                                $usuarios = mysqli_query($connect, $sql);

                                                while ($dados = mysqli_fetch_array($usuarios)) {
                                            ?>
                                            <tr class="odd gradeX">                                                     
                                                <td><?php echo "<a href='usuario.php?idUsr=".$dados['idUsuario']."' 
                                                                          id='link_tabela'>".$dados['nome_completo']."</a>"; ?></td>                                                
                                                <td><?php echo "<a href='usuario.php?idUsr=".$dados['idUsuario']."' 
                                                                          id='link_tabela'>".$dados['email']."</a>"; ?></td>  
                                                <td><?php echo "<a href='usuario.php?idUsr=".$dados['idUsuario']."' 
                                                                          id='link_tabela'>".$dados['campus']."</a>"; ?></td>  
                                                <td><?php echo "<a href='usuario.php?idUsr=".$dados['idUsuario']."' 
                                                                          id='link_tabela'>".$dados['telefone']."</a>"; ?></td>  
                                                <td><?php echo "<a href='usuario.php?idUsr=".$dados['idUsuario']."' 
                                                                          id='link_tabela'>".$dados['perfil']."</a>"; ?></td>                                              
                                            </tr>
                                            
                                            <?php }; 
                                                 ?>

                                        </tbody>
                                    </table>
                                </div>                            
                            </div>
                        </div>
                        <!--Fim da tabela de chamados -->
                    </div>
                </div>   

                <!-- Rodapé --> 
                <div class="animated fadeIn footer">
                        &copy; 2018 Fast.
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
