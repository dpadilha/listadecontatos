<?php

	header('Content-Type: text/html; charset=utf-8');
	/*Abre a conexão do banco de dados*/
	$conexao = @mysqli_connect($db_host,$db_user, $db_pass, $db_name);
	/*Seta que o banco vai utilizar o padrão utf-8*/
	mysqli_set_charset ( $conexao , 'utf8' );

	/*Se a conexão falhar finaliza a aplicação*/
	if(mysqli_connect_errno($conexao)){
		$resultado = "A conexão falhou, erro reportador: ".mysqli_connect_error();
		exit();
	}
	/*Inclue o model de contatos*/
	require("mdl_contato.php");

	/*Verifica se existe ação feita pelo usuário*/
	if(isset($_GET['p'])){
		/*Pega a ação*/
		$passo = $_GET['p'];
	}else{
		/*Passa null para a ação*/
		$passo = null;
	}
	
	/*Entra no switch que a ação foi escolhida pelo usuário e passada pelo get*/
	switch ($passo) {
		case "cadastrar":
			/*Chama a função para cadastrar o usuário passando a conexão*/
			cadastrarUsuario($conexao);
			break;
		case "alterar":
			/*Chama a função de alterar*/
			alterarUsuario($conexao);
			break;
		case "excluir":
			/*Chama função que exclui o contato passando a conexão*/
			$dados = excluirUsuario($conexao);
			/*Retorna mensagem se conseguir excluir*/
			$retornoExc = "Excluido com sucesso.";
			/*Chama lista para exibir os dados*/
			require("view_lista.php");
			break;
		case "buscar":
			/*chama a função de busca de contatos pelo nome ou telefone ou email, passando a conexao*/
			$dados = buscar_contato($conexao);
			/*Se o valor for vazio ele chama a função para listar os dados existentes no banco*/
			if($dados == "" || empty($dados)){
				$dados = listarDados($conexao);
				$retornoExc = "Falha em buscar o Contato ";
				require("view_lista.php");
			}/*Se não ele chama a view de busca passando os dados que forma buscado anteriormente*/
			else{
				require("view_lista_busca.php");
			}
			break;
		default:
			/*Recebe um array com os dados da consulta do banco de dados*/
			$dados = listarDados($conexao);
			/*importação da view*/
			require("view_lista.php");
			break;
	}
	/*fecha a conexão com o banco de dados*/
	@mysqli_close($conexao);

	
	/*-------------------------------------------############--------------------------------------------------*/


	/*Função que lista os dados do banco e retorna um array com os dados*/
	function listarDados($conexao){
		/*chama a função do model passando a conexão do banco que retorna um mysqli_result para a variavel resultado*/
		$resultado = usuario_listar($conexao);
		/*Criação de um array*/
		$data = array();
		/*Enquanto a função encontrar linhas de resultado da consulta do banco ele entra e cria um array com os dados da linha*/
		while($row = mysqli_fetch_array($resultado)){
			$data[] = array("id"=> $row['id'] , "nome" => utf8_encode($row['nome']), "telefone" => $row['telefone'], "email" => $row['email'], "logradouro" => $row['logradouro'], "numero" => $row['numero'], "bairro" => $row['bairro'], "cidade" => $row['cidade'], "estado" => $row['estado'], "sexo" => $row['sexo'], "dtNasc" => $row['dtNasc']);
		}
		/*retorna o array com as consultas do banco de dados*/
		return $data;
	}

	/*Função que exclui o usuário passando o id*/
	function excluirUsuario($conexao){
		/*pega o codigo do usuário passado pela url mas se nao existir ele será -1*/
		$id_usuario= (isset($_GET["codigo"]) ? $_GET["codigo"] : -1);
		/*Pega o resultado da exclusão no banco de dados passando a conexão e o id*/
		$resultado = usuario_excluir($conexao, $id_usuario);
		/*Criação de um array*/
		$data = array();
		/*Caso consiga excluir ele entra no if e retorna os dados agora sem o contato que foi excluido*/
		if($resultado){
			$data = listarDados($conexao);
			return $data;
		}else{
			return false;
		}
	}
	/*Função para cadastrar usuário passando a conexão do banco de dados*/
	function cadastrarUsuario($conexao){
		/*Recebe a requisição via post e os dados do contato pelo formulario*/
		if(isset($_POST["frmCadUsuario"])){
			$nome = $_POST['txtNomeUsuario'];
			$telefone = $_POST['txtTelUsuario'];
			$email = $_POST['txtEmailUsuario'];
			$logradouro = $_POST['txtLograUsuario'];
			$numero = $_POST['txtNumUsuario'];
			$bairro = $_POST['txtBairroUsuario'];
			$cidade = $_POST['txtCidadeUsuario'];
			$estado = $_POST['txtEstadoUsuario'];
			$sexo = isset($_POST['txtSexoUsuario']);
			$dtNasc = $_POST['txtDtnascUsuario'];


			/*Chama a função para cadastrar o contato passando os parametros*/
			$resultado = usuario_cadastrar($conexao,$nome,$telefone,$email,$logradouro,$numero,$bairro,
				$cidade,$estado,$sexo,$dtNasc);
			/*Se conseguir cadastrar entra no if informa a mensagem de sucesso e retorna os novos dados chamando a view*/
			if($resultado){
				$retornoExc = " Contato Cadastrado com Sucesso!";
				$dados = listarDados($conexao);
				require("view_lista.php");
			/*Se o cadastro falhou manda a mensagem informando do erro e chama o formulario de cadastro novamente*/
			}else{
				if(!valida_email($email)){
					$retornoExc = "O cadastro falhou, digite um email valido!";
				}
				else if($nome == ""){
					$retornoExc = "O cadastro falhou o campo nome é obrigatório, tente novamente!";
				}
				require("view_form_cadastro_novo_usuario.php");
			}
		
		}else{
			require("view_form_cadastro_novo_usuario.php");
		}

	}

	function alterarUsuario($conexao){
		/*Verifica se foi enviado id pelo formulario*/
		if(isset($_POST["idusuario"])){
			/*preenche os dados com as informações vindas do formulário*/
			$nome = $_POST['txtNomeUsuario'];
			$telefone = $_POST['txtTelUsuario'];
			$email = $_POST['txtEmailUsuario'];
			$logradouro = $_POST['txtLograUsuario'];
			$numero = $_POST['txtNumUsuario'];
			$bairro = $_POST['txtBairroUsuario'];
			$cidade = $_POST['txtCidadeUsuario'];
			$estado = $_POST['txtEstadoUsuario'];
			$sexo = isset($_POST['txtSexoUsuario']);
			$dtNasc = $_POST['txtDtnascUsuario'];
			$id = $_POST['idusuario'];

			/*Chama a função para alterar no banco passando os novos valores*/
			$retorno = usuario_alterar($conexao,$nome,$telefone,$email,$logradouro,$numero,$bairro,
				$cidade,$estado,$sexo,$dtNasc,$id);

			/*Se existir algum retorno ele entra coloca uma mensagem de sucesso e chama a pagina para listar os dados*/
			if($retorno){
				$retornoExc = "Contato Alterado com Sucesso!";
				$dados = listarDados($conexao);
				require("view_lista.php");
			}else{
				/*retorna mensagem informando que a alteração não foi realizada*/
				if(!valida_email($email)){
					$retornoExc = "A alteração falhou, digite um email valido!";
				}
				else if($nome == ""){
					$retornoExc = "A alteração falhou o campo nome é obrigatório, tente novamente!";
				}
				$dados = listarDados($conexao);
				require("view_lista.php");
			}
			
		}else if(isset($_GET['codigo'])){
			/*Pega o id passado pela url do contato que deseja excluir*/
			$id = $_GET['codigo'];
			/*Pega os dados do usuário passando a conexão e id*/
			$retorno = usuario_porId($conexao,$id);
			/*Se não existir retorno informa que busca falhou e retorna falso*/
			if(!$retorno){
				$retornoExc = "Falha em buscar o Contato ";
				return false;
			}
			/*Cria uma linha com os dados do contato passando para a variavel*/
			$dadosUsuario = mysqli_fetch_row($retorno);
			/*Passa para a variavel dados as informações do array com seus indices*/
			$dados  = array("id" => $dadosUsuario[0], "nome" => $dadosUsuario[1], "logradouro" => $dadosUsuario[2] , "numero" => $dadosUsuario[3], "bairro" => $dadosUsuario[4], "cidade" => $dadosUsuario[5], "estado" => $dadosUsuario[6], "telefone" => $dadosUsuario[7], "email" => $dadosUsuario[8], "sexo" => $dadosUsuario[9], "dtNasc" => $dadosUsuario[10]);
			/*Chama o formulario para alteração do usuário*/
			require("view_form_cadastro_altera_usuario.php");
		}else{
			$dados = listarDados($conexao);
			require("view_lista.php");
		}
		
	}

	function buscar_contato($conexao){
		/*Pega o texto que é realizado para busca*/
		$busca = (isset($_POST["txtBusca"]) ? $_POST["txtBusca"] : "");
		/*Chama a função pegando passando a conexão e o texto para busca de e espera o retorno da busca no banco de dados */
		$resultado = usuario_busca($conexao,$busca);
		/*se o resultado não for vazio ele entra criar um array e tranforma a query realizada em uma array e retorna esses dados*/
		if($resultado != ""){
			$data = array();
			while($row = mysqli_fetch_array($resultado)){
			$data[] = array("id"=> $row['id'] , "nome" => utf8_encode($row['nome']), "telefone" => $row['telefone'], "email" => $row['email'], "logradouro" => $row['logradouro'], "numero" => $row['numero'], "bairro" => $row['bairro'], "cidade" => $row['cidade'], "estado" => $row['estado'], "sexo" => $row['sexo'], "dtNasc" => $row['dtNasc']);
			}
			return $data;
		}
		/*se for vazio ele retorna vazio*/
		return "";
	}