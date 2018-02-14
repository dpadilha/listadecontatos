<?php
	/*Informações do banco de dados*/
	$db_host= "localhost";
	$db_user= "root";
	$db_pass= "";
	$db_name="contatos";
	/*Trocar a Codificação de Caracteres Padrão*/
	ini_set('default_charset', 'UTF-8');
	/*Pega o valor r passado via Get*/
	$r = $_GET['r'];
	/* E chama o index da pasta do valor r*/
	require_once($r."/index.php");