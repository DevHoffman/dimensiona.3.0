<?php

	@session_start();

	$servidor = "localhost";
	$usuario = "root";
	$senha = "Abc12three@";
	$dbname = "dimensiona";
	
	//Criar a conexao
	$ligacao = mysqli_connect($servidor, $usuario, $senha, $dbname);

	// Aqui está o segredo dos caracteres especiais - Glória a Deus!!!! Obrigado Senhor!!!
	$sql= "SET NAMES 'utf8'";
	mysqli_query($ligacao, $sql);
	$sql = 'SET character_set_connection=utf8';
	mysqli_query($ligacao, $sql);
	$sql ='SET character_set_client=utf8';
	mysqli_query($ligacao, $sql);
	$sql ='SET character_set_results=utf8';
	mysqli_query($ligacao, $sql);
	
	if(!$ligacao){
		die("Falha na conexao: " . mysqli_connect_error());
	}else{
		//echo "Conexao realizada com sucesso";
	}	
	
	// habilita todas as exibições de erros
	ini_set('display_errors', true);
	error_reporting(E_ALL);
?>