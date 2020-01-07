<?php
	session_start();
	
	unset(
		$_SESSION['auth'],
		$_SESSION['usuarioId'],
		$_SESSION['usuarioNome'],
		$_SESSION['usuarioSenha'],
		$_SESSION['usuarioNivelAcessoId']
	);
	
	$_SESSION['TituloMensagem'] = "Deslogado Com Sucesso!";
	$_SESSION['TipoMensagem'] = "green";
	$_SESSION['Mensagem'] = "Você saiu do sistema com sucesso!";
	//redirecionar o usuario para a página de login
	header('location: /');
	exit;
?>