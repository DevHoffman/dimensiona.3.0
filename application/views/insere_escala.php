<?php 



$arquivo = new DOMDocument();
$arquivo->load($_FILES['arquivo']['tmp_name']);

$linhas = $arquivo->getElementsByTagName('Row');

$primeira_linha = true;

foreach($linhas as $linha){

    if($primeira_linha == false){

        $nome = $linha->getElementsByTagName('Data')->item(0)->nodeValue;

        $DataEscala = $linha->getElementsByTagName('Data')->item(1)->nodeValue;
        $DataEscala = substr($DataEscala, 0, 10);

        $data_Hoje = new DateTime($DataEscala);
        $data_Hoje = date_format($data_Hoje, 'Y-m-');
        
        $data_ultimo_dia = new DateTime($DataEscala);
        $ultimo_dia_M = date_format($data_ultimo_dia, 't');

        $HorarioEscala = $linha->getElementsByTagName('Data')->item(2)->nodeValue;
        // $HorarioEscala = substr($HorarioEscala, 11, 5);

        // echo $nome . ' : ' . $DataEscala . ' - ' . $HorarioEscala . '<br />';

        $Supervisor = $linha->getElementsByTagName('Data')->item(3)->nodeValue;

        $Coordenador = $linha->getElementsByTagName('Data')->item(4)->nodeValue;

        $Campanha = $linha->getElementsByTagName('Data')->item(5)->nodeValue;
       
        $sql_usuario = "SELECT CodiUsuario, Usuario FROM tbl_usuarios WHERE Usuario='$nome' LIMIT 1";
        $query_usuario = $ligacao->query($sql_usuario);
       
        $sql_campanha = "SELECT * FROM tbl_campanha WHERE Campanha='$Campanha' LIMIT 1";
        $query_campanha = $ligacao->query($sql_campanha);
       
        $sql_supervisor = "SELECT S.CodiSupervisor, U.Usuario FROM tbl_supervisor S, tbl_usuarios U WHERE U.Usuario='$Supervisor' AND U.CodiUsuario=S.CodiUsuario LIMIT 1";
        $query_supervisor = $ligacao->query($sql_supervisor);

        $sql_coordenador = "SELECT C.CodiCoordenador, U.Usuario FROM tbl_coordenador C, tbl_usuarios U WHERE U.Usuario='$Coordenador' AND U.CodiUsuario=C.CodiUsuario LIMIT 1";
        $query_coordenador = $ligacao->query($sql_coordenador);



        if ( $row_usuario = mysqli_fetch_array($query_usuario) ){ // Verifica se o Usuário Existe

            $CodiUsuario = $row_usuario[0];

        }
        else{ // Caso não exista, insere Usuário

            $insere_usuario = "INSERT INTO tbl_usuarios (Usuario, CodiNivelAcesso) VALUES ('$nome', '8')";
            $ligacao->query($insere_usuario);
       
            $sql_usuario = "SELECT CodiUsuario, Usuario FROM tbl_usuarios WHERE Usuario='$nome' LIMIT 1";
            $query_usuario = $ligacao->query($sql_usuario);

            if ( $row_usuario = mysqli_fetch_array($query_usuario) ){ // Verifica se o Usuário Existe
    
                $CodiUsuario = $row_usuario[0];
    
            }

        }

        if ( $row_campanha = mysqli_fetch_array($query_campanha) ){ // Verifica se a Campanha Existe

            $CodiCampanha = $row_campanha[0];            

        }
        else {

            $sql_campanha = "INSERT INTO tbl_campanha (Campanha) VALUES ('$Campanha');";
            $ligacao->query($sql_campanha);
   
            $sql_campanha = "SELECT * FROM tbl_campanha WHERE Campanha='$Campanha' LIMIT 1";
            $query_campanha = $ligacao->query($sql_campanha);

            if ( $row_campanha = mysqli_fetch_array($query_campanha) ){
                $CodiCampanha = $row_campanha[0]; 
                echo $CodiCampanha . '<br />';
            }        

        }

        if ( $row_supervisor = mysqli_fetch_array($query_supervisor) ){ // Verifica se o Supervisor Existe

            $CodiSupervisor = $row_supervisor[0];

        }

        if ( $row_coordenador = mysqli_fetch_array($query_coordenador) ){ // Verifica se o Coordenador Existe

            $CodiCoordenador = $row_coordenador[0];

        }

        for ( $i=1; $i <= $ultimo_dia_M; $i++ ){

            if ($i < 10){
                $i = 0 . $i;
            }

            $Data = $data_Hoje . $i;

            $sql_consulta_escala = "SELECT * FROM tbl_escala WHERE CodiUsuario='$CodiUsuario' AND (DataEscalaUsuario='$Data');";
            $query_consulta_escala = $ligacao->query($sql_consulta_escala);

            if ( $query_consulta_escala->num_rows == 0 ){
                // Inserindo Escala no banco de Dados
                $insere = "INSERT INTO tbl_escala (CodiUsuario, CodiSupervisor, CodiCoordenador, CodiCampanha, DataEscalaUsuario, HorarioEscalaUsuario) VALUES ('$CodiUsuario', '$CodiSupervisor', '$CodiCoordenador', '$CodiCampanha', '$Data', '$HorarioEscala')";
                $ligacao->query($insere);
                // echo $Data . ' - <br />';
            }
            else{
                if ( $Data == $DataEscala ){
                    $altera = "UPDATE tbl_escala SET HorarioEscalaUsuario='F' WHERE CodiUsuario='$CodiUsuario' AND (DataEscalaUsuario='$Data');";
                    $ligacao->query($altera);
                    // echo $Data . ' - ' . $DataEscala . '<br />';
                }
            }
        }
    }
    $primeira_linha = false;
}

$_SESSION['TituloMensagem'] = "Escala Inserida!";
$_SESSION['TipoMensagem'] = "success";
$_SESSION['Mensagem'] = "A escala foi importada com Sucesso!";


?>