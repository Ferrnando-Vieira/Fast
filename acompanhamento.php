<!DOCTYPE html>
<?php include_once 'conn/sessao.php'; 

    if (isset($_GET['status']) and $_GET['status'] <> 0 ) {
        $status_chamado = $_GET['status'];
    } elseif (isset($_GET['status']) and $_GET['status'] == 0) {
        $status_chamado = null;        
    } else {
        $_SESSION['mensagem'] = "Não foi possível exibir os chamados, tente novamente mais tarde.";
    }    

    header("Refresh:30");
?>

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
                                        if ($usuario_comum) {
                                            echo 'Acompanhamento de Chamados';
                                        } else {
                                            echo 'Fila de chamados';
                                        }
                                             
                                        if(isset($_SESSION['mensagem'])) {
                                            $alerta = $_SESSION['mensagem'];
                                            echo "<h5>$alerta</h5>";
                                        }
                    
                                        unset($_SESSION['mensagem']);
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
                                                        if ($usuario_comum) {
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

                                                if (is_null($status_chamado)) {

                                                    //Caso o usuário tenha clicado para ver o histórico, ele só verá os chamados dele
                                                    if ($usuario_comum) {
                                                        $condicao = "usu.idUsuario = $id AND cha.idStatus not in (4,5)";

                                                    //Caso não seja um usuário comum e o mesmo tenha clicado para ver quais chamados estão com ele    
                                                    }elseif (isset($_GET['idUsr']) and !$usuario_comum){
                                                        $condicao = "nsi.idUsuario = $id AND cha.idStatus not in (4,5)";

                                                    //Caso não seja um usuaŕio comum e o mesmo tenha clicado para ver a fila de chamados
                                                    }else {
                                                        $condicao =  "cha.idStatus not in (4,5) and cha.idUsuarioNSI is null";
                                                    }

                                                //Chamados por Status
                                                }else{
                                                    
                                                    //Caso seja um usuário comum, ele verá apenas os chamados no status escolhido que ele criou
                                                    if ($usuario_comum) {
                                                        $condicao = "usu.idUsuario = $id AND cha.idStatus = $status_chamado";

                                                    //Caso não seja um usuaŕio comum e o mesmo tenha clicado para algum status, ele verá todos os chamados daquele status
                                                    } else {
                                                        $condicao =  "cha.idStatus = $status_chamado";
                                                    }
                                                }

                                                $sql = "SELECT cha.ticket as ticket, coalesce(concat(nsi.nome, nsi.sobrenome), 'Sem responsável no momento') as responsavel
                                                                , cha.dtHoraAbertura as horaChamado, cha.local as 'local'
                                                                , sta.nomeStatus as descricao, cha.idChamado as codChamado
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
                                                    <td><?php echo "<a href='detalhamento.php?idChamado=".$dados['codChamado']."' 
                                                                                       id='link_tabela'>".$dados['ticket']."</a>"; 
                                                        ?>
                                                    </td>                                         

                                                    <td><?php
                                                            if ($usuario_comum) {
                                                                echo "<a href='detalhamento.php?idChamado=".$dados['codChamado']."'
                                                                                         id='link_tabela'>".$dados['responsavel']."</a>";
                                                            } else {
                                                                echo "<a href='detalhamento.php?idChamado=".$dados['codChamado']."'
                                                                                         id='link_tabela'>".$dados['usuario']."</a>";
                                                            }                                                        
                                                        ?>
                                                    </td>

                                                    <td><?php echo "<a href='detalhamento.php?idChamado=".$dados['codChamado']."' 
                                                                                       id='link_tabela'>".DATE('d/m/Y H:i:s', strtotime($dados['horaChamado']))."</a>"; 
                                                        ?>
                                                    </td>      

                                                    <td><?php echo "<a href='detalhamento.php?idChamado=".$dados['codChamado']."' 
                                                                                       id='link_tabela'>".$dados['local']."</a>"; 
                                                        ?>
                                                    </td>  

                                                    <td><?php echo "<a href='detalhamento.php?idChamado=".$dados['codChamado']."' 
                                                                                       id='link_tabela'>".$dados['descricao']."</a>"; 
                                                        ?>
                                                    </td> 

                                                </tr>
                                            
                                            <?php }; ?>

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
