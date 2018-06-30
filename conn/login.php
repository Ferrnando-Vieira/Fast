<?php 
//Conexão com o banco
    require_once 'conn/conecta_banco.php';
    $erros = array();

    //verifica se houve erro na conexão
    if (!empty($erro_conexao)) {
       $erros [] = "<center>
                        <p>Houve um erro de conexão.</p>
                        <h5> $erro_conexao </h4>
                    </center>";
    }

    //Inicia sessão
    session_start();

    //Verifica se os dados estão corretos
    if (isset($_POST['enviar'])){
       
        $login = mysqli_escape_string($connect, $_POST['login']);
        $senha = mysqli_escape_string($connect, $_POST['senha']);

        $sql = "SELECT usu.* FROM usuario usu WHERE usu.login = lower('$login');";

        $retorno = mysqli_query($connect, $sql);
        $dados_usuario = mysqli_fetch_array($retorno);


        if (md5($senha) == $dados_usuario['senha']) {
            $_SESSION['logado'] = true;
            $_SESSION['idUsuario'] = $dados_usuario ['idUsuario'];
            $_SESSION['idPerfil'] = $dados_usuario ['idPerfil'];
            $_SESSION['ultimoAcesso'] = $dados_usuario ['ultimoAcesso'];

            if ($_SESSION['perfil'] == 1) {
                header('Location: home.php'); 
            }else{
                header('Location: acompanhamento.php?status=0');
            }
                       
        } else {
            $erros[] = "<center>
                            <h3>Usuário ou Senha incorretos.</h3>
                        </center>";
        }
    }
?>