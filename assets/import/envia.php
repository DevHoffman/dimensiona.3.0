<?php 

    require_once 'assets/includes/conexao.php';

    // $dados = $_FILES['arquivo'];
    // var_dump($dados);
    if(!empty($_FILES['arquivo']['tmp_name'])){
        $arquivo = new DOMDocument();
        $arquivo->load($_FILES['arquivo']['tmp_name']);
        // var_dump($arquivo);

        $linhas = $arquivo->getElementsByTagName('Row');
        // var_dump($linhas);

        $primeira_linha = true;

        foreach($linhas as $linha){
            if($primeira_linha == false){
                $nome = $linha->getElementsByTagName('Data')->item(0)->nodeValue;
                echo 'Nome: ' . $nome . ' <br />';

                $email = $linha->getElementsByTagName('Data')->item(1)->nodeValue;
                echo 'Email: ' . $email . ' <br />';

                $nivies_acesso_id = $linha->getElementsByTagName('Data')->item(2)->nodeValue;
                echo 'Nível de Acesso: ' . $nivies_acesso_id . ' <br />';

                echo '<hr />';

                // Inserir no banco de Dados
                $query = "INSERT INTO tbl_teste (Nome, Email, NivelAcesso) VALUES('$nome', '$email', '$nivies_acesso_id')";
                $ligacao->query($query);
        }

            $primeira_linha = false;
        }
    }

?>