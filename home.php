<!DOCTYPE html>

<?php include_once 'conn/sessao.php'; ?>

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
                    <h2>Abertura de Chamado</h2> 

                    <?php     
                    //Após o usuário enviar os dados será exibido uma mensagem de erro ou de sucesso. (Ver abrir_chamado.php)
                    if(isset($_SESSION['mensagem'])) {
                        $alerta = $_SESSION['mensagem'];
                        echo "<h5>$alerta</h5>";
                    }

                    unset($_SESSION['mensagem']);
                    ?>  
                </div>

            </div>              

             <hr/>
            
            <form accept-charset="UTF-8" action="conn/abrir_chamado.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">                        
                        <div class="form-group">                        
                            <label for="subject">Campus</label>
                                <select name="campus" class="form-control" required="required" style="width:50%">
                                    <option value="" selected=""></option>                                                                             
                                        <?php 

                                            $sql = " SELECT cam.idCampus, cam.nomeCampus
                                                     FROM  campus cam ";
                                                            
                                            $campus = mysqli_query ($connect, $sql);

                                            while ($dados = mysqli_fetch_array($campus)) {
                                                echo '<option value="'.$dados['idCampus'].'">'.$dados['nomeCampus'].'</option>';
                                            };

                                        ?>                         

                                </select>
                        </div>   
                                                                               
                    
                        <label for="subject">Local</label>
                        <input type="text" class="form-control" name="local" style="width:50%"
                            placeholder="Ex.: Sala 1004">                
                        <p></p> 

                        <label for="subject">Categoria</label>
                            <select id="subject" name="categoria" class="form-control" required="" style="width:50%" >
                                <option value="" selected=""></option>
                                <?php 

                                            $sql = " SELECT *
                                                     FROM  categoria ";
                                                            
                                            $categoria = mysqli_query ($connect, $sql);

                                            while ($dados = mysqli_fetch_array($categoria)) {
                                                echo '<option value="'.$dados['idCategoria'].'">'.$dados['nomeCategoria'].'</option>';
                                            };

                                        ?>   
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
