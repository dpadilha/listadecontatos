<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	<title>Busca de Contatos</title>
</head>
<body>
<dir class="container">

	<div class="row">
		<h1>Contatos</h1>

		<a class="btn btn-default" href="index.php?r=contato"><i class="glyphicon glyphicon-chevron-left"></i>Voltar</a>

		<form method="POST" action="index.php?r=contato&p=buscar" class="navbar-form pull-right">
			<input name = "txtBusca" type="text" class="span2" placeholder="Buscar">
			<button class="btn btn-default"><i class ="glyphicon glyphicon-search"></i></button>
		</form>
	</form>

	</div>
	

	
	<hr/>

	<div class= "<?= (isset($retornoExc) ?  'panel-success' : '') ?>">   
        <div class="panel-heading">
        	<span><?= isset($retornoExc) ? $retornoExc : '&nbsp;' ?></span>
        </div>
     
		<table class="table table-striped table-condensed">
			<thead>
				<tr>
					<td>NOME</td>
					<td>TELEFONE</td>
					<td>E-MAIL</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($dados as $linha) { ?>
					<tr>
						<td><?=$linha['nome']?></td>
						<td><?=$linha['telefone']?></td>
						<td><?=$linha['email']?></td>
						<td><a class="btn btn-info" href="index.php?r=contato&p=excluir&codigo=<?=$linha['id']?>" onclick="return confirm('Deseja excluir o registro?')">Excluir</a>
						<a class="btn btn-danger" href="index.php?r=contato&p=alterar&codigo=<?=$linha['id']?>">Alterar</a></td>
					</tr>
				<?php } ?>

			</tbody>
			
		

		</table>
	</div>
</dir>
</body>
</html>