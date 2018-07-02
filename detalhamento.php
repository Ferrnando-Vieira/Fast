<!DOCTYPE html>

<?php include_once 'conn/sessao.php'; 

    if (isset($_GET['idChamado'])) {
        $idChamado = $_GET['idChamado'];
    }else{
        $_SESSION['mensagem'] = "Não foi possível recuperar o chamado!";
    }

    include_once 'conn/dados_chamado.php'; 

?>

<html>

    <?php include_once 'common/header.php'; ?>

    <body>

    <!-- Inicio Corpo -->
    <div id="wrapper">               

        <!-- Menu do sistema -->
        <?php include_once 'common/menu.php'; ?>

        <center>
            
            <div id="page-wrapper">

            <div class="row">
                <div class="col-md-12">
                    <h2>Detalhamento do chamado</h2>

                    <?php     
                    //Caso não tenha sido possível recuperar o id do chamado será apresentado uma mensagem de erro.
                    if(isset($_SESSION['mensagem'])) {
                        $alerta = $_SESSION['mensagem'];
                        echo "<h5>$alerta</h5>";
                    }

                        unset($_SESSION['mensagem']);
                    ?>  

                </div>  
            </div>              

             <hr/>
            
            <form accept-charset="UTF-8" <?php echo "action='conn/alterar_chamado.php?idChamado=$idChamado' "; ?> method="POST">

                <!-- Linha com nome completo e numero do chamado-->
                <div class="row">    
                    <div class="form-group">                        
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4">
                            <fieldset disabled>                                
                                <div class="col-sm-5" >
                                    <label for="subject">Nome Completo:</label>
                                </div>
                                <?php echo "<input type='text' class='form-control' placeholder='".$dados_chamado['nome_completo']."'> "; ?>                                                                                  
                            </fieldset>                            
                        </div>    

                        <div class="col-sm-3">
                            <fieldset disabled>
                                <div class="col-sm-4">                            
                                    <label for="subject">Ticket:</label>
                                </div>                               
                                <?php echo "<input type='text' class='form-control' placeholder='".$dados_chamado['ticket']."'> "; ?>                                                                           
                            </fieldset>   
                        </div>   

                        <div class="col-sm-3">      
                            <fieldset <?php if($usuario_comum){ echo "disabled";} ?> >                                                            
                                <div class="col-sm-4">                            
                                    <label for="subject">Status:</label>
                                </div>                               
                                <select name="status" class="form-control">                                                                                                           
                                    <?php 

                                        echo "<option value='".$status_chamado['idStatus']."' selected='' >".$status_chamado['nomeStatus']."</option>";

                                        $sql = "SELECT 
                                                    stat.idStatus
                                                , stat.nomeStatus
                                                FROM  
                                                    statusChamado stat
                                                WHERE
                                                    stat.idStatus <> ".$status_chamado['idStatus'];
                                                        
                                        $status = mysqli_query ($connect, $sql);

                                        while ($dados = mysqli_fetch_array($status)) {
                                            echo "<option value='".$dados['idStatus']."'>".$dados['nomeStatus']."</option>";
                                        };
                                    ?>                         
                                </select> 
                            </fieldset>                                                                                            
                        </div> 

                        <div class="col-sm-1"></div>
                    </div>
                </div> 
                <!-- Fim da linha com nome completo e numero do chamado-->                

                <p></p>

                <!-- Linha de alteração de Telefone, E-mail e Perfil-->
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4">      

                            <fieldset disabled>
                                <div class="col-sm-3">
                                        <label for="tel">Email:</label>                                   
                                    </div>
                                        <?php echo "<input type='tel' class='form-control' placeholder='".$dados_chamado['email']."'> "; ?>                                                           
                            </fieldset>

                        </div>


                        <div class='col-sm-3'>
                            <fieldset disabled>
                                <div class="col-sm-5">
                                        <label for="subject">Telefone:</label>
                                </div>
                                <div class="col-sm-7"></div>
                                <?php echo "<input type='tel' class='form-control' placeholder='".$dados_chamado['telefone']."'> "; ?>           
                            </fieldset>  
                        </div>
                        
                    
                        <div class='col-sm-3'>
                            <fieldset disabled>
                                <div class='col-sm-7'>
                                    <label for='subject'>Data de Abertura:</label>                        
                                </div>                        
                                    <?php echo "<input type='tel' class='form-control' placeholder='".DATE('d/m/Y H:i:s', strtotime($dados_chamado['abertura_chamado']))."'> "; ?>                                                                                                                                  
                            </fieldset>
                        </div> 
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <!-- Fim da Linha de alteração de Telefone, E-mail e Perfil -->

                <p></p>

                <!-- Linha de alteração de Login e Senha -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-1"></div>

                        <div class="col-sm-4">
                            <fieldset disabled>
                                <div class="col-sm-4">
                                    <label for="subject">Responsável:</label>
                                </div>
                                <?php echo "<input type='text' class='form-control' name='login' placeholder='".$dados_chamado['nome_responsavel']."'> "; ?>                              
                            </fieldset>         
                        </div>

                        <div class="col-sm-3">
                            <fieldset disabled>
                                <div class="col-sm-4">
                                    <label for="subject">Local:</label>
                                </div>
                                <?php echo "<input type='text' class='form-control' name='login' placeholder='".$dados_chamado['local']."'> "; ?>                              
                            </fieldset>                            
                        </div>
  
                        <div class="col-sm-3">
                            <fieldset disabled>
                                <div class="col-sm-5">
                                    <label for="subject">Campus:</label>
                                </div>
                                <?php echo "<input type='text' class='form-control' name='login' placeholder='".$dados_chamado['campus']."'> "; ?>                              
                            </fieldset>                            
                        </div>

                        <div clas="col-sm-1"></div>
                    </div>
                </div>
   

                <p></p>                                                   

                <div class="row">
                    <div class="form-group">
                        <fieldset disabled>                             
                            <div class="col-sm-4">                                                     
                                <label for="subject">Descrição do chamado:</label> 
                            </div>
                            <div class="span4" style="padding-bottom:0" >
                                <?php echo "<textarea class='span4 well' name='descricao' placeholder='".$descricao_chamado."' 
                                                      rows='10' style='width:80%'></textarea>";  ?>                                         
                            </div>                                                                                  
                        </fieldset>

                    </div>
                </div>

                <?php 

                    if ($_GET['mostrarObs'] == true and !$usuario_comum) {
                        echo "
                        <div class='row'>
                            <div class='col-sm-1'></div>
                            <div class='form-group'>                                                  
                                <div class='col-sm-2'>                                                     
                                    <label for='subject'>Observação:</label> 
                                </div>
                                <div class='span4' style='padding-bottom:0' >
                                    <textarea class='span4 well' name='observacao' placeholder='Adicione uma informação ao chamado'
                                                            rows='10' style='width:80%'></textarea>                                        
                                </div>                                                                                                          
                            </div>
                        </div>";
                    }
                ?>

                <?php
                    if (!$usuario_comum) { 
                        echo "
                            <div class='row'>     
                                <div class='col-sm-1'></div>
                                <div class='col-sm-1'>
                                    <button class='btn btn-secondary' name='apropriar'> Apropriar Chamado </button>
                                </div>
                                <div class='col-sm-6'></div>
                                <div class='col-sm-1'>                                              
                                    <button class='btn btn-secondary' name='mostrarObs'> Adicionar Observação </button>                             
                                </div>
                                <div class='col-sm-1'></div>
                                
                                <div class='col-sm-1'>
                                    <button class='btn btn-primary' type = 'submit' name='enviar'><i class='fa fa-check'></i> Enviar </button>                                 
                                </div>
                                <div class='col-sm-1'></div>
                            </div>   ";
                    }                                                                              
                ?>                                               
            </form>
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