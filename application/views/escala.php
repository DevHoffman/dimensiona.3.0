<?php

//Conectando ao Banco
require_once 'assets/includes/conexao.php';

$_SESSION['painel_administrativo'] = true;

if ( !isset($_SESSION['auth']) ){
  $_SESSION['auth'] = false;
}

if ( $_SESSION['auth'] == false ){
    require_once '../assets/includes/header.php';
    require_once '../administrativo/login.php';
    exit;
}
else{
    require_once 'assets/includes/header.php';
}


require_once 'assets/includes/menu_esquerdo.php';

require_once 'assets/includes/menu_topo.php';

if ( isset($_FILES['arquivo']['tmp_name']) ){
	include 'insere_escala.php';
}


if (isset($_POST['CodiUsuarioE']) and isset($_POST['DataEscalaE']) and isset($_POST['HorarioE'])){

	$CodiUsuario = trim(addslashes($_GET['CodiUsuarioE']));
	$DataEscalaE = trim(addslashes($_GET['DataEscalaE']));
	$HorarioE = trim(addslashes($_GET['HorarioE']));

	$data = new DateTime($DataEscalaE);
	$DataEscalaE = date_format($data, 'Y-m-d');

	$sql = "SELECT * FROM tbl_escala WHERE CodiUsuario='$CodiUsuario' AND DataEscalaUsuario='$DataEscalaE' AND HorarioEscalaUsuario<>'$HorarioE'";
	$query = $ligacao->query($sql);

	if ($row_ = mysqli_fetch_array($query)){

		$CodiEscala = $row_[0];

		$sql = "UPDATE tbl_escala SET HorarioEscalaUsuario='$HorarioE' WHERE CodiEscala='$CodiEscala'";
		$ligacao->query($sql);

		$_SESSION['TituloMensagem'] = "Escala Atualizada!";
	    $_SESSION['TipoMensagem'] = "success";
	    $_SESSION['Mensagem'] = "Você atualizou a Escala Com Sucesso!<br />Meus Paranélsons!";

	}
	else {

		$_SESSION['TituloMensagem'] = "Esta Escala Não Existe!";
	    $_SESSION['TipoMensagem'] = "error";
	    $_SESSION['Mensagem'] = "Cadastre essa escala para conseguir alterar!";

	}

}

if ( isset($_POST['CodiUsuario']) and isset($_POST['DataUltimoAcesso']) ) {

	$CodiUsuario = trim(addslashes($_POST['CodiUsuario']));
	$DataUltimoAcesso = trim(addslashes($_POST['DataUltimoAcesso']));

	$DataUltimoAcesso = new DateTime($DataUltimoAcesso);
	$DataUltimoAcesso = date_format($DataUltimoAcesso, 'Y-m-d');

	$sql_deleta = "DELETE FROM tbl_escala WHERE CodiUsuario='$CodiUsuario' AND DataEscalaUsuario>='$DataUltimoAcesso';";
	$deleta = $ligacao->query($sql_deleta);

	if ( $deleta == true ){

		$DataUltimoAcesso = new DateTime($DataUltimoAcesso);
		$DataUltimoAcesso = date_format($DataUltimoAcesso, 'd/m/Y');

		$sql = "SELECT CodiUsuario, Usuario FROM tbl_usuarios WHERE CodiUsuario='$CodiUsuario' LIMIT 1";
		$query = $ligacao->query($sql);

		if ( $row = mysqli_fetch_array($query) ) {
			$Usuario = $row[1];
		}

	    $_SESSION['TituloMensagem'] = "Escala Removida!";
	    $_SESSION['TipoMensagem'] = "success";
	    $_SESSION['Mensagem'] = "Escala do Usuário " . $Usuario . " foi removida do sistema a partir do dia " . $DataUltimoAcesso . " !";

	}
	else{

        $_SESSION['TituloMensagem'] = "Erro ao Cadastrar!";
        $_SESSION['TipoMensagem'] = "error";
        $_SESSION['Mensagem'] = "Verifique as Informações e tente novamente.";

	}

}

$sql_ = "SELECT CodiUsuario, Usuario FROM tbl_usuarios WHERE CodiNivelAcesso='6' ORDER BY Usuario";
$query_ = $ligacao->query($sql_);

// Query Lista
$sql_usuario_exclusao = "SELECT E.CodiUsuario, U.Usuario, U.Login
	FROM tbl_usuarios U, tbl_escala E WHERE U.CodiUsuario=E.CodiUsuario GROUP BY U.Usuario";
$query_usuario_exclusao = $ligacao->query($sql_usuario_exclusao);

mysqli_close($ligacao);

?>



<?php require_once 'assets/includes/footer.php'; ?>

