<?php
    $sql_chamado =
           "SELECT
              CONCAT(usu.nome, ' ',usu.sobrenome) as nome_completo, cam.nomeCampus as campus
            , usu.email, usu.telefone, stat.nomeStatus as status, cat.nomeCategoria as categoria
            , cha.ticket, cha.local, cha.dtHoraAbertura as abertura_chamado, cha.idUsuarioNSI as responsavel
            , cha.descricao, COALESCE(CONCAT(nsi.nome, ' ',nsi.sobrenome), 'Sem Responsável') as nome_responsavel
            , cha.anexo
            FROM
              chamado cha
            left join usuario nsi on nsi.idUsuario = cha.idUsuarioNSI
            , usuario usu
            , statusChamado stat
            , categoria cat
            , campus cam
            WHERE
                cha.idUsuario = usu.idUsuario
            and stat.idStatus = cha.idStatus
            and cat.idCategoria = cha.idCategoria
            and cam.idCampus = cha.idCampus
            and cha.idChamado = ".$idChamado;
                
    $sql_status_chamado =
            "SELECT
              stat.nomeStatus
            , stat.idStatus
            FROM
                chamado cha
            , statusChamado stat
            WHERE
                cha.idStatus = stat.idStatus
            and cha.idChamado = ".$idChamado;

    $sql_observacao_chamado =
            "SELECT
                CONCAT(usu.nome, ' ', usu.sobrenome) as usuario_observacao, obs.datahoraObservacao
            ,   obs.descricaoObservacao as observacao
            FROM
                chamado cha
            ,   observacaoChamado obs
            ,   usuario usu
            WHERE
                obs.idChamado = cha.idChamado
            and usu.idUsuario = obs.idUsuario
            and cha.idChamado = ".$idChamado;

    $retorno_chamado = mysqli_query ($connect, $sql_chamado);
    $retorno_status = mysqli_query ($connect, $sql_status_chamado);
    $retorno_observacao = mysqli_query ($connect, $sql_observacao_chamado);

    $dados_chamado = mysqli_fetch_array($retorno_chamado);
    $status_chamado = mysqli_fetch_array($retorno_status);

    $descricao_chamado = $dados_chamado['descricao'];

//Exibição da descrição do chamado e histórico de observação
if (mysqli_num_rows($retorno_observacao) > 0) {
$descricao_chamado = $descricao_chamado."\n
------------------------------------------------
Observações do Chamado: \n";

    while ($dados = mysqli_fetch_array($retorno_observacao)){
        $descricao_chamado = $descricao_chamado." 
Responsável: ".$dados['usuario_observacao'].", Data da observação: ".DATE('d/m/Y H:i:s', strtotime($dados['datahoraObservacao']))."            
Observação: ".$dados['observacao']."\n";

    }
}

$lista_anexo = "";

//Verifica se há arquivos anexos e retorna os mesmos
if ($dados_chamado['anexo']) {

    $sql_anexo = 
        "SELECT 
            arq.nome_arquivo
          , arq.local_arquivo        
         FROM
            arquivos arq
         WHERE
            arq.idChamado = ".$idChamado;

    $retorno_anexo = mysqli_query($connect,$sql_anexo);   

    $lista_anexo = "
    <div class='row'>
        
        <div class='col-sm-12'>
            <div class='col-sm-3'>
                <strong>  Arquivos Anexados: </strong>
            </div>
            <div class='col-sm-1'> ";
            
    while($dados = mysqli_fetch_array($retorno_anexo)){        
        $lista_anexo = $lista_anexo."<a href='".$dados['local_arquivo'].$dados['nome_arquivo']."' target='_blank'>".$dados['nome_arquivo']." </a>";
        
    }
    $lista_anexo = $lista_anexo."
            </div>
            <div class='col-sm-1'></div>
        </div>
        <div class='col-sm-1'></div>
    </div>";
}

?>