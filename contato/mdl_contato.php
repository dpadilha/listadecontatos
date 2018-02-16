<?php
	
	function usuario_listar($conexao){
		$sql = "SELECT * FROM contato ORDER BY nome";
		$resultado = mysqli_query($conexao,$sql);
		return $resultado;
	}

	function usuario_porId($conexao,$id){
		$sql = sprintf("SELECT * FROM contato WHERE id = %s", $id);
		$resultado = mysqli_query($conexao,$sql);
		return $resultado;
	}


	function usuario_excluir($conexao, $id){
		$sql = sprintf("DELETE FROM contato WHERE id = %s", $id);
		$resultado = mysqli_query($conexao,$sql);
		return $resultado;
	}

	function usuario_cadastrar($conexao,$nome,$telefone,$email,$logradouro,$numero,$bairro,
				$cidade,$estado,$sexo,$dtNasc){
	
		$sql = sprintf("INSERT INTO contato(nome, telefone, email, logradouro, numero, bairro, cidade, estado, sexo, dtNasc) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $nome, $telefone,$email,$logradouro,$numero,$bairro,$cidade,$estado,$sexo,$dtNasc);

		$resultado = mysqli_query($conexao,$sql);
		return $resultado;
	}

	function usuario_alterar($conexao,$nome,$telefone,$email,$logradouro,$numero,$bairro,
				$cidade,$estado,$sexo,$dtNasc,$id){
		if($nome == "" || !valida_email($email)){
			return false;

		}
		$sql = sprintf("UPDATE contato SET nome = '%s', telefone = '%s', email = '%s', logradouro = '%s', numero = %s, bairro = '%s', cidade = '%s', estado = '%s', sexo = '%s', dtNasc = '%s' WHERE id = '%s' ", $nome, $telefone,$email,$logradouro,$numero,$bairro,$cidade,$estado,$sexo,$dtNasc,$id);
		
		$resultado = mysqli_query($conexao,$sql);
		return $resultado;
	}

	function usuario_busca($conexao,$busca){
		if($busca == ""){
			return "";
		}
		$sql = "SELECT * FROM contato WHERE nome LIKE '%".$busca."%' OR telefone LIKE '%".$busca."%' OR email LIKE '%".$busca."%'";
		$resultado = mysqli_query($conexao,$sql);
		return $resultado;
	}

	function valida_email($email) {
		if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $email) || empty($email) || $email == "") {
			return true;
		}else{
			return false;
		}
}