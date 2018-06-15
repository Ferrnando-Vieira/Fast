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

        $sql = "SELECT usu.* FROM usuario usu WHERE usu.login = lower('$login') AND usu.senha = (SELECT PASSWORD('$senha')) ";

        $retorno = mysqli_query($connect, $sql);

        if (mysqli_num_rows($retorno) == 0) {
            $erros[] = "<center>
                            <h3>Usuário ou Senha incorretos.</h3>
                        </center>";
        } else {
            $dados = mysqli_fetch_array($retorno);
            $_SESSION['logado'] = true;
            $_SESSION['idUsuario'] = $dados ['idUsuario'];
            header('Location: home.php');
        }
    }
?>