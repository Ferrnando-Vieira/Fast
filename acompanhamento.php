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
                                <h2>
                                    <?php
                                        if ($perfil == 1) {
                                            echo 'Acompanhamento de Chamados';
                                        } else {
                                            echo 'Fila de chamados';
                                        }
                                                
                                    ?>
                                </h2>                         
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
                                <?php
                                    if ($perfil == 1) {
                                        echo 'Chamados Abertos';                                        
                                    } else {
                                        echo 'Chamados na fila';
                                    }
                                    
                                ?>                            
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Chamado</th>
                                                <th>
                                                    <?php
                                                        if ($perfil == 1) {
                                                            echo 'Nome do Responsável';
                                                        } else {
                                                            echo 'Nome do Usuário';
                                                        }                                                    
                                                    ?>   
                                                </th>
                                                <th>Data de abertura</th>
                                                <th>Local</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                                                                            
                                            <?php 

                                                if ($idPerfil == 1) {
                                                    $condicao = "usu.idUsuario = $id AND cha.idStatus not in (4,5)";
                                                } else {
                                                    $condicao =  "cha.idStatus not in (4,5)";
                                                }

                                                $sql = "SELECT cha.ticket as ticket, coalesce(concat(nsi.nome, nsi.sobrenome), 'Sem responsável no momento') as responsavel
                                                                , cha.dtHoraAbertura as horaChamado, cha.local as 'local'
                                                                , sta.descricaoStatus as descricao, cha.idChamado as codChamado
                                                                , concat(usu.nome, ' ', usu.sobrenome) as usuario 
                                                        FROM 
                                                                chamado cha     
                                                            left join usuario nsi on nsi.idUsuario = cha.idUsuarioNSI                                                                
                                                            join usuario usu on usu.idUsuario = cha.idUsuario  
                                                            join statusChamado sta on sta.idStatus = cha.idStatus                                                           
                                                        WHERE 
                                                            $condicao";

                                                $chamado = mysqli_query($connect, $sql);

                                                while ($dados = mysqli_fetch_array($chamado)) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $dados['ticket'] ?></td>                                                
                                                <td><?php
                                                        if ($perfil == 1) {
                                                            echo $dados['responsavel'];
                                                        } else {
                                                            echo $dados['usuario'];
                                                        }                                                        
                                                    ?>
                                                </td>
                                                <td><?php echo DATE('d/m/Y H:i:s', strtotime($dados['horaChamado'])); ?></td>
                                                <td class="center"><?php echo $dados['local'] ?></td>
                                                <td class="center"><?php echo $dados['descricao'] ?></td>
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
