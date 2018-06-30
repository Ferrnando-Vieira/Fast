<?php
//Inicia conexão
require_once 'conecta_banco.php';


//Inicia sessão
session_start();

// Verifica sessão
if (!isset($_SESSION['logado'])){
    header('Location: index.php');
}

//Id do usuario que abriu sessão
$id = $_SESSION['idUsuario'];

$erro = 0; // 0 = sem erro, 1 = com erro

//SQL para gerar o número do chamado, que é a junção do ano+mes+dia de abertura do chamado + usuario (5 dígitos) que abriu o chamado + o número de chamados 
// abertos por ele no dia (2 digitos).
$sql = "SELECT CONCAT(EXTRACT(YEAR_MONTH FROM NOW()), EXTRACT(DAY FROM CURDATE()), LPAD ($id, 5, '0'), LPAD(ok.totalChamados, 2, '0')) AS numero_chamado,
               NOW() AS abertura
        FROM (
            SELECT COUNT(idChamado) + 1 as totalChamados 
            FROM chamado 
            WHERE idUsuario = $id) as ok;";

$retorno = mysqli_query($connect, $sql);

$ticket = mysqli_fetch_array($retorno);

$numero_chamado = $ticket['numero_chamado'];
$abertura_chamado = $ticket['abertura']; 

$campus = mysqli_escape_string($connect, $_POST['campus']);
$local = mysqli_escape_string($connect, $_POST['local']);
$categoria = mysqli_escape_string($connect, $_POST['categoria']);
$descricao = mysqli_escape_string($connect, $_POST['descricao']);


 // Upload de arquivos multiplos para o servidor
if(isset($_POST['enviar'])){
    
    //Loop só será realizado caso exista algum arquivo
    if ($_FILES['arquivos_']['name'][0] <> "") {

        $totalArquivos = count($_FILES['arquivos_']['name']);
        $contador = 0;

        while ($contador < $totalArquivos) {    

            //Extensão do arquivo
            $extensao = pathinfo($_FILES['arquivos_']['name'][$contador], PATHINFO_EXTENSION);

            //Tamanho do arquivo
            (int)$tamanho = $_FILES["file"]["size"][$contador];                

            /*  //Pasta onde o arquivo será transferido
            $pasta = "../users/user_uplod/";*/

            //Nome temporário do arquivo
            $temporario = $_FILES['arquivos_']['tmp_name'][$contador];

            //Nome sem a extensão
            $nome = $numero_chamado.($contador + 1);

            //Arquivo
            $arquivo = file_get_contents($temporario);

            //Escape para evitar erro no MySQL
            $arquivo = mysqli_real_escape_string($connect,$arquivo);


            //Sql para inserir o arquivo no banco
            $sql = "INSERT INTO arquivos (nomeArquivo, extensaoArquivo, arquivo)
                    VALUES ('$nome', '$extensao', '$arquivo');";
            
            if (mysqli_query($connect, $sql)) {
                $_SESSION['mensagem'] = "Upload do(s) arquivo(s) realizado! <br>";  
                $possui_anexo = true;
            } else {
                $_SESSION['mensagem'] = "<br> Um ou mais arquivos não puderam ser adicionados!<br>";
                $erro = 1;                      
            }

            $contador++;

        }
        
    } else {

        $possui_anexo = false;
    }
}

 //Abertura do chamado caso não tenha ocorrido erro de upload
if ($erro == 0) {

    // SQL para criação do chamado
    $ins_chamado = "INSERT INTO chamado (idUsuario,idCampus,idCategoria, local ,dtHoraAbertura, ticket ,descricao, anexo) 
    VALUES ($id, $campus, $categoria, '$local' , '$abertura_chamado' , '$numero_chamado' , '$descricao', '$possui_anexo');";

    //verifica se foi possível abrir o chamado
    if (mysqli_query($connect, $ins_chamado)) {
        if ($possui_anexo) {
            $_SESSION['mensagem'] = $_SESSION['mensagem']."Chamado aberto com sucesso.";
            header('Location: ../home.php');
        } else {
            $_SESSION['mensagem'] = "Chamado aberto com sucesso.";
            header('Location: ../home.php');
        }
    //Caso não tenha sido criado o chamado é exibido uma mensagem de erro.
    } else {
        $_SESSION['mensagem'] = "Não foi possível abrir o chamado. 
                             <br>Verifique se o tamanho somado dos arquivos não ultrapassa 2MB ou tente novamente mais tarde.";
        header('Location: ../home.php');
    }
} else {
    //Caso tenha ocorrido erro no upload é apresentada uma mensagem de erro.
    $_SESSION['mensagem'] = "Não foi possível abrir o chamado. ".$_SESSION['mensagem'];
    header('Location: ../home.php');
}

?>