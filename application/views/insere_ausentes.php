<?php 

// Dia de Ontem Até amanhã de Hoje
$DataZona = new DateTimeZone('America/Sao_Paulo');
$data = new DateTime('NOW');
$data->setTimezone($DataZona);
$data_Hoje = date_format($data, 'Y-m-');

$sql = "SELECT U.CodiUsuario, U.Usuario, C.Campanha, N.NivelAcesso, E.DataEscalaUsuario 
FROM tbl_usuarios U, tbl_escala E, tbl_campanha C, tbl_nivelacesso N
WHERE NOT EXISTS (SELECT * FROM tbl_auditoria A 
WHERE A.CodiUsuario=E.CodiUsuario AND A.DataAcesso=E.DataEscalaUsuario) AND U.CodiNivelAcesso>6 AND E.CodiUsuario=U.CodiUsuario AND 
E.CodiCampanha=C.CodiCampanha AND N.CodiNivelAcesso=U.CodiNivelAcesso AND E.DataEscalaUsuario LIKE '$data_Hoje%' AND E.HorarioEscalaUsuario<>'F'";
$query = $ligacao->query($sql);

while ($row_presenca = mysqli_fetch_assoc($query)){
    $CodiUsuario = $row_presenca['CodiUsuario'];
    $DataAcesso = $row_presenca['DataEscalaUsuario'];

    $sql = "SELECT * FROM tbl_ausencia WHERE CodiUsuario='$CodiUsuario' AND DataAusencia='$DataAcesso'";
    $query_ = $ligacao->query($sql);
    $row_Ausencia = mysqli_num_rows($query_);

    if (  $query_->num_rows == 0 ){
        $CodiAusente = $row_Ausencia['CodiAusente'];
        $insere = "INSERT INTO tbl_ausencia (CodiUsuario, DataAusencia) VALUES ('$CodiUsuario', '$DataAcesso')";
        // $insere = "UPDATE tbl_teste SET CodiUsuario='$CodiUsuario' AND DataAusencia='$DataAcesso' WHERE CodiAusente='$CodiAusente'";
        $ligacao->query($insere);
    }

}

mysqli_close($ligacao); 

?>