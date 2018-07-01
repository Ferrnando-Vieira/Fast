<!DOCTYPE html>

<?php include_once 'conn/sessao.php'; 

    if (isset($_GET['idUsr'])) {
        $idUsr = $_GET['idUsr'];
    }else{
        $_SESSION['mensagem'] = "Não foi possível recuperar o usuário!";
    }

    $sql = "SELECT
              CONCAT(usu.nome, ' ',usu.sobrenome) as nome_completo, cam.nomeCampus as campus_usuario
            , cam.idCampus as idCampus_usuario, per.nomePerfil as perfil_usuario
            , per.idPerfil as idPerfil_usuario, usu.email, usu.telefone, usu.login
            FROM
              usuario usu
            , campus cam
            , perfil per
            WHERE
                usu.idCampus = cam.idCampus
                AND usu.idPerfil = per.idPerfil
                AND usu.idUsuario = $idUsr ";
                
    $retorno = mysqli_query ($connect, $sql);

    $dado_atual = mysqli_fetch_array($retorno);

    $id_perfis= array (
        0 => '1',
        1 => '2',
        2 => '3',
        3 => '4',
    );

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
                    <h2>Alteração de Dados</h2>

                    <?php     
                    //Caso não tenha sido possível recuperar o id do usuaŕio será apresentado uma mensagem de erro.
                    if(isset($_SESSION['mensagem'])) {
                        $alerta = $_SESSION['mensagem'];
                        echo "<h5>$alerta</h5>";
                    }

                        unset($_SESSION['mensagem']);
                    ?>  

                </div>  
            </div>              

             <hr/>
            
            <form accept-charset="UTF-8" <?php echo "action='conn/alterar_dados.php?idUsr=$idUsr' "; ?> method="POST">

                <!-- Linha com o nome e sobrenome do usuário e Campus-->
                <div class="row">    
                    <div class="form-group">                        
                        <div class="col-sm-1"></div>
                        <div class="col-sm-7">
                            <fieldset disabled>                                
                                <div class="col-sm-3" >
                                    <label for="subject">Nome Completo:</label>
                                </div>
                                <div class="col-sm-9"></div>
                                <?php echo "<input type='text' class='form-control' placeholder='".$dado_atual['nome_completo']."'> "; ?>                                                                                  
                            </fieldset>                            
                        </div>    
                        <div class="col-sm-3">
                            <div class="col-sm-4">
                            <label for="subject">Campus:</label>
                            </div>
                            <div class="col-sm-8"></div>
                                    <select id="subject" name="campus" class="form-control">                                        
                                        <?php 
                                            echo "<option value='".$dado_atual['idCampus_usuario']."' selected='' >".$dado_atual['campus_usuario']."</option>";
                                            $sql = "SELECT *
                                                    FROM  campus
                                                    WHERE idCampus <> ".$dado_atual['idCampus_usuario']."
                                                    ORDER BY nomeCampus";
                                                            
                                            $perfil = mysqli_query ($connect, $sql);

                                            while ($dados = mysqli_fetch_array($perfil)) {
                                                echo '<option value="'.$dados['idCampus'].'">'.$dados['nomeCampus'].'</option>';
                                            };
                                        ?> 
                                    </select>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div> 
                <!-- Fim da linha com o nome e sobrenome do usuário e Campus-->                

                <p></p>

                <!-- Linha de cadastro de Telefone e E-mail -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3">
                            <div class="col-sm-5">
                                <label for="subject">Telefone:</label>
                            </div>
                            <div class="col-sm-7"></div>
                            <?php echo "<input type='tel' class='form-control' placeholder='".$dado_atual['telefone']."'> "; ?>       
                        </div>

                        <!-- Caso seja um usuário normal, ele não poderá ver a opção de alterar o menu -->
                        <?php
                            if ($usuario_comum) {
                                echo "<div class='col-sm-7'>";                                
                            }else {
                                echo "<div class='col-sm-4'>";
                            }
                             ?>
                            <div class="col-sm-3">
                                <label for="tel">Email:</label>                                   
                            </div>
                                <?php echo "<input type='tel' class='form-control' placeholder='".$dado_atual['email']."'> "; ?>                                
                        </div>
                        
                    <?php 
                        if (!$usuario_comum) {
                        $opcao_perfil = "
                        <div class='col-sm-3'>
                            <div class='col-sm-3'>
                                <label for='subject'>Perfil:</label>
                            </div>
                                    <select id='subject' name='perfil' class='form-control'>                                            
                                        <option value='".$dado_atual['idPerfil_usuario']."' selected='' >".$dado_atual['perfil_usuario']."</option>";
                                    
                                    if ($usuario_adm) { 
                                        $condicao = "1 = 1 and idPerfil <> ".$dado_atual['idPerfil_usuario'];
                                    } else {                                        
                                        $condicao = "idPerfil <> 4 and idPerfil <>".$dado_atual['idPerfil_usuario'];
                                    }

                                    $sql = "SELECT *
                                            FROM  perfil
                                            WHERE
                                                $condicao
                                            ORDER BY idPerfil ";
                                                    
                                    $tipo_perfil = mysqli_query ($connect, $sql);

                                    while ($dados = mysqli_fetch_array($tipo_perfil)) {
                                        $opcao_perfil = $opcao_perfil."<option value='".$dados['idPerfil']."'>".$dados['nomePerfil']."</option> ";
                                    };
                                    $opcao_perfil = $opcao_perfil."
                                    </select>
                        </div> ";

                        echo $opcao_perfil;
                        }
                    ?>
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
                            <div class="col-sm-4">
                                <label for="subject">Login:</label>
                            </div>
                            <?php echo "<input type='text' class='form-control' name='login' placeholder='".$dado_atual['login']."'> "; ?>                              
                        </div>
  
                        <div class="col-sm-3">
                            <div class="col-sm-4">
                                <label for="subject">Senha:</label>
                            </div>
                            <input type="password" class="form-control" name="senha" placeholder="Senha">
                        </div>

                        <div class="col-sm-4">
                            <div class="col-sm-5">
                                <label for="subject">Confime a senha:</label>
                            </div>
                                <input type="password" class="form-control" name="confirma_senha" placeholder="Digite a senha novamente">     
                        </div>

                        <div clas="col-sm-1"></div>
                    </div>
                </div>
                <!-- Fim da Linha de cadastro de Campus, Genero e Perfil -->

                <p></p>                                                   

                <div class="row">                            
                    <div class="col-sm-10"></div>
                    <div class="col-sm-1">
                        <button class="btn btn-primary" type = "submit" name="enviar"><i class="fa fa-check"></i> &nbsp Enviar</button>                                 
                    </div>
                    <div class="col-sm-1"></div>
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
