<?php

$campus = $_POST['campus'];
$local = $_POST['local'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];

 // Upload de arquivos para o servidor
if(isset($_POST['enviar'])){
    $totalArquivos = count($_FILES['arquivos_']['name']);
    $contador = 0;

    while ($contador < $totalArquivos) {    

        $extensao = pathinfo($_FILES['arquivos_']['name'][$contador], PATHINFO_EXTENSION);
        $pasta = "users/user_uplod/";
        $temporario = $_FILES['arquivos_']['tmp_name'][$contador];
        $novoNome = uniqid().".$extensao";
        echo "$pasta $novoNome";
        if (move_uploaded_file($temporario, $pasta.$novoNome)) {
            $mensagem = "Upload realizado";
        } else {
            $mensagem = "erro upload";
        }
        echo $mensagem;
        $contador++;
    }
  
}

