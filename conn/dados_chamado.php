<?php
$sql_chamado =
           "SELECT
              CONCAT(usu.nome, ' ',usu.sobrenome) as nome_completo, cam.nomeCampus as campus
            , usu.email, usu.telefone, stat.nomeStatus as status, cat.nomeCategoria as categoria
            , cha.ticket, cha.local, cha.dtHoraAbertura as abertura_chamado, cha.idUsuarioNSI as responsavel
            , cha.descricao, COALESCE(CONCAT(nsi.nome, ' ',nsi.sobrenome), 'Sem Responsável') as nome_responsavel
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
    $observacao_chamado = mysqli_fetch_array($retorno_observacao);

    if (!empty($observacao_chamado['observacao']) OR !is_null($observacao_chamado['observacao'])){
        $descricao_chamado = $dados_chamado['descricao']."
            \n";
        while ($dados = $observacao_chamado){
            $descricao_chamado = $descricao_chamado." 
            Responsável: ".$observacao_chamado['usuario_observacao'].", Data da observação: ".DATE('d/m/Y H:i:s', strtotime($observacao_chamado['datahoraObservacao']))."
            \n
            Observação: ".$observacao_chamado['observacao']."\n";

        }
    } else {
        $descricao_chamado = $dados_chamado['descricao']; 
    }
?>