<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Alteração de Cadastro</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  	
</head>
<body>
<div class="container">	
	<div class="row">
		<h1>Alteração de Contato</h1>	
		<a class="btn btn-default" href="index.php?r=contato"><i class="glyphicon glyphicon-arrow-left"></i></a>
	</div>
	
	<hr/>

	<div class= "<?= (isset($retornoExc) ?  'panel-success' : '') ?>">   
        <div class="panel-heading">
        	<span><?= isset($retornoExc) ? $retornoExc : '&nbsp;' ?></span>
        </div>
	<div>


	<div class ="col-md-2">
		<p>Altere os dados do contato no formulário ao lado para finalizar seu cadastro!</p>
	</div>

	<div class ="col-md-10">
		
		<form method="POST" action="index.php?r=contato&p=alterar">
			<div class="form-group">
				<label>Digite o nome completo:</label>
				<input class = "form-control" type="text" maxlength="120" name="txtNomeUsuario" value="<?=$dados['nome']?>">
			</div>

			<div class="form-group">
				<label>Informe a rua:</label>
				<input class="form-control" type="text" maxlength="120" name="txtLograUsuario" value="<?=$dados['logradouro']?>">
			</div>

			<div class="container-fluid">
				<div class="col-md-6">
					<div class="form-group">
						<label>Informe o numero:</label>
						<input class="form-control" type="text" maxlength="120" name="txtNumUsuario"  value="<?=$dados['numero']?>">
					</div>

					<div class="form-group">
						<label>Informe o bairro:</label>
						<input class="form-control" type="text" maxlength="120" name="txtBairroUsuario"  value="<?=$dados['bairro']?>">
					</div>

					<div class="form-group">
						<label>Informe o telefone:</label>
						<input class="form-control" type="text" maxlength="120" name="txtTelUsuario" value="<?=$dados['telefone']?>">
					</div>

					<div class="form-group">
						<label>Informe a cidade</label>
						<input class="form-control" type="text" maxlength="120" name="txtCidadeUsuario"  value="<?=$dados['cidade']?>">
					</div>

				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Informe o estado:</label>
						<input class="form-control" type="text" maxlength="120" name="txtEstadoUsuario"  value="<?=$dados['estado']?>">
					</div>

			
					<div class="form-group">
						<label>Informe o email:L</label>
						<input class="form-control" type="email" maxlength="120" name="txtEmailUsuario"  value="<?=$dados['email']?>">
					</div>		

					<div class="form-group">
						<label>Informe a data de nascimento:</label>
						<input class="form-control" type="date" maxlength="120" name="txtDtnascUsuario" value="<?=$dados['dtNasc']?>" >
					</div>

					<div class="form-group">
						<label>Informe o género sexual:</label><br/>
						<input type="radio" name="txtSexoUsuario" value="masculino"> Masculino<br/>
						<input type="radio" name="txtSexoUsuario" value="feminino"> Feminino
					</div>
					
				</div>

				<div class="form-group">
					<input name="idusuario" type="hidden"  value="<?=$dados['id']?>">
					<input class="btn btn-primary" type="submit" value="Alterar Contato">
				</div>
		</form>

	</div>
			
	</div>
		
	</div>

	</div>
	
</div>
</body>
</html>