<!DOCTYPE html>
<html>
    <?php include_once 'conn/sessao.php'; ?>
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
            
            <p></p>

            <form accept-charset="UTF-8" action="conn/criar_usuario.php" method="POST">       

                <!-- Linha de cadastro de nome e sobrenome -->
                <div class="row">    
                    <div class="form-group">                        
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3">
                            <label for="subject">Nome:</label>
                                <input type="text" class="form-control" required="" name="nome"
                                placeholder="Nome">                                                                                
                        </div>
                        <div class="col-sm-7">
                            <label for="subject">Sobrenome:</label>
                                <input type="text" class="form-control" required="" name="sobrenome"
                                placeholder="Sobrenome">                                                
                        </div>                        
                        <div class="col-sm-1"></div>
                    </div>
                </div> 
                <!-- Fim da Linha de cadastro de nome e sobrenome -->                                  

                <p></p>

                <!-- Linha de cadastro de Telefone e E-mail -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3">
                            <label for="subject">Telefone:</label>
                                    <input type="text" class="form-control" name="telefone"
                                        placeholder="Ex.: 998764321">  
                        </div>
                        <div class="col-sm-7">
                            <label for="subject">Email:</label>              
                                <fieldset>                            
                                    <input type="email" placeholder="email@usuario.com.br" required="" class="form-control" name="email">
                                </fieldset>                             
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <!-- Fim da Linha de cadastro de Telefone e E-mail -->

                <p></p>

                <!-- Linha de cadastro de Campus, Genero e Perfil -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3">
                            <label for="subject">Campus:</label>
                                <select id="subject" name="campus" class="form-control" required="">
                                    <option value="" selected=""></option>
                                    <?php 
                                        $sql = "SELECT *
                                                FROM  campus
                                                ORDER BY nomeCampus ";
                                                        
                                        $perfil = mysqli_query ($connect, $sql);

                                        while ($dados = mysqli_fetch_array($perfil)) {
                                            echo '<option value="'.$dados['idCampus'].'">'.$dados['nomeCampus'].'</option>';
                                        };
                                    ?> 
                                </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="subject">Gênero:</label>
                                <select id="subject" name="genero" class="form-control" required="">                         
                                    <option value="" selected=""></option>
                                    <option value="M"> Masculino </option>
                                    <option value="F"> Feminino </option>
                                    <option value="O"> Outros </option>
                                    <option value="N"> Não Informado </option>
                                </select>                    
                        </div>
                        <div class="col-sm-4">
                            <label for="subject">Perfil:</label>
                                    <select id="subject" name="perfil" class="form-control" required="required" >
                                            <?php 

                                                if ($usuario_adm) { 
                                                    $condicao = "1 = 1";
                                                } else {
                                                    $condicao = "idPerfil <> 4";                                                    
                                                }

                                                $sql = "SELECT *
                                                        FROM  perfil
                                                        WHERE
                                                            $condicao
                                                        ORDER BY idPerfil ";
                                                                
                                                $tipo_perfil = mysqli_query ($connect, $sql);

                                                while ($dados = mysqli_fetch_array($tipo_perfil)) {
                                                    echo '<option value="'.$dados['idPerfil'].'">'.$dados['nomePerfil'].'</option>';
                                                };
                                            ?>   
                                    </select>
                        </div>
                        <div clas="col-sm-1"></div>
                    </div>
                </div>
                <!-- Fim da Linha de cadastro de Campus, Genero e Perfil -->
                <p></p>                   
                                                
                <!--  Linha de cadastro de Login e Senha -->                                                                                                  
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3">
                            <label for="subject">Login:</label>
                                <input type="text" size="34" class="form-control" name="login" 
                                       placeholder="Login" required="">
                        </div>
                        <div class="col-sm-3">
                            <label for="subject">Senha:</label>
                             <input type="password" class="form-control" name="senha" placeholder="Senha" required="" >
                        </div>
                        <div class="col-sm-4">
                            <label for="subject">Confime a senha:</label>
                                <input type="password" class="form-control" name="confirma_senha" placeholder="Digite a senha novamente" required="">     
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <!-- Fim da Linha de cadastro de Login e Senha -->                                                                                                  
                                                
                <p></p>                                                

                <div class="row">                            
                    <div class="col-sm-10"></div>
                    <div class="col-sm-1">
                        <button class="btn btn-primary" type = "submit" name="enviar"><i class="fa fa-check"></i> Enviar </button>                                 
                    </div>
                    <div class="col-sm-1"></div>
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
