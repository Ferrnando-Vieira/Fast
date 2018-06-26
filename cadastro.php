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
                    <h2>Cadastro de usuário</h2>

                    <?php     
                    //Após o usuário enviar os dados será exibido uma mensagem de erro ou de sucesso. (Ver criar_usuario.php)
                    if(isset($_SESSION['mensagem'])) {
                        $alerta = $_SESSION['mensagem'];
                        echo "<h5>$alerta</h5>";
                    }

                    unset($_SESSION['mensagem']);
                    ?>  

                </div>
            </div>              

             <hr/>
            
            <form accept-charset="UTF-8" action="conn/criar_usuario.php" method="POST">
                <div class="row">
                    <div class="col-md-6">                        
                        <div class="form-group">                        
                           <label for="subject">Nome:</label>
                                <input type="text" class="form-control" required="" name="nome" style="width:40%"
                                placeholder="Ex.: Bruce">                
                             <p></p> 

                            <label for="subject">Sobrenome:</label>
                                <input type="text" class="form-control" required="" name="sobrenome" style="width:40%"
                                placeholder="Ex.: Wayne">                
                             <p></p> 
                                                               
                            <label for="subject">Email:</label>              
                                <fieldset>                            
                                    <input type="email" placeholder="batman@batcaverna.com"
                                        size="30" required="" style="width:40%" class="form-control" name="email">
                                </fieldset>
                            <p></p>    

                            <label for="subject">Telefone:</label>
                                <input type="text" class="form-control" name="telefone" style="width:40%"
                                placeholder="Ex.: 998764321">                
                             <p></p>

                            <label for="subject">Campus</label>
                            <select id="subject" name="campus" class="form-control" required="required" style="width:40%" >
                                <option value="" selected=""></option>
                                <?php 
                                    $sql = " SELECT *
                                            FROM  campus
                                            ORDER BY nomeCampus ";
                                                    
                                    $perfil = mysqli_query ($connect, $sql);

                                    while ($dados = mysqli_fetch_array($perfil)) {
                                        echo '<option value="'.$dados['idCampus'].'">'.$dados['nomeCampus'].'</option>';
                                    };
                                ?> 
                            </select>
                            <p></p>                        

                            <label for="subject">Gênero</label>
                            <select id="subject" name="genero" class="form-control" required="" style="width:40%" >                         
                                <option value="M" selected=""> Masculino </option>
                                <option value="F" selected=""> Feminino </option>
                                <option value="O" selected=""> Outros </option>
                                <option value="N" selected=""> Nao Informado </option>
                            </select>
                            <p></p> 
                       
                            <label for="subject">Tipo de perfil</label>
                                <select id="subject" name="perfil" class="form-control" required="required" style="width:40%" >
                                        <?php 
                                            $sql = " SELECT *
                                                    FROM  perfil
                                                    ORDER BY idPerfil ";
                                                            
                                            $perfil = mysqli_query ($connect, $sql);

                                            while ($dados = mysqli_fetch_array($perfil)) {
                                                echo '<option value="'.$dados['idPerfil'].'">'.$dados['nomePerfil'].'</option>';
                                            };
                                        ?>   
                                </select>
                                <p></p> 

                            <label for="subject">Login:</label>
                            <input type="text" size="34" class="form-control" name="login" 
                                   placeholder="Login" required="" autofocus="" style="width: 40%;">
                            <p></p>
                        
                            <label for="subject">Senha:</label>
                            <input type="password" size="34" class="form-control" name="senha" placeholder="Senha" required="" style="width: 40%;" />   
                            <p></p>

                            <label for="subject">Confime a senha:</label>
                            <input type="password" size="34" class="form-control" name="confirma_senha" placeholder="Digite a senha novamente" required="" style="width: 40%;" />     
                            <p></p>
                                               
                        <div class="row">                            
                            <center>                                
                                <button class="btn btn-primary" type = "submit" name="enviar"><i class="fa fa-check"></i> &nbsp Enviar</button>                                 
                            </center>
                        </div>                        
                        <p></p><p></p>

                    <!-- Rodapé --> 
                    <div class="animated fadeIn footer">
                            &copy; 2018 Fast.
                    </div> 

                    </div>                     
                </div>
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
