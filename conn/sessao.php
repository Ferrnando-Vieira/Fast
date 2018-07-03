<?php
    //Conexão com o banco
    require_once 'conn/conecta_banco.php';
    $erros = array();

    //verifica se houve erro na conexão
    if (!empty($erro_conexao)) {
       $erros [] = "<center>
                        <h3>Houve um erro de conexão.</h3>
                    </center><br>";
    }

    //Inicia sessão
    session_start();

    // Verifica sessão
    if (!isset($_SESSION['logado'])){
        header('Location: index.php');
    }

    //Dados do usuário
    $id = $_SESSION['idUsuario'];    
    $ultimo_acesso = $_SESSION['ultimoAcesso'];

    if ($perfil == 1) {
        $home = "home.php";
    }else{
        $home = "acompanhamento.php?status=0";
    }

    $sql = "SELECT usu.*, cam.idCampus as idCampus_usuario, cam.nomeCampus as campus_usuario,
            case when idPerfil = 1 then true else false end as usuario_comum ,
            case when idPerfil = 4 then true else false end as usuario_adm
            FROM usuario usu, campus cam
            WHERE usu.idUsuario = $id
                  and cam.idCampus = usu.idCampus ";
    $sql_user = mysqli_query($connect, $sql);
    $dados_user = mysqli_fetch_array($sql_user);

    $perfil = $dados_user['idPerfil'];
    $usuario_comum = $dados_user['usuario_comum'];
    $usuario_adm = $dados_user['usuario_adm'];
    $campus_usu = $dados_user['campus_usuario'];
    $idCampus_usu = $dados_user['idCampus_usuario'];
    $idArquivo = $dados_user['idArquivo'];
?>
