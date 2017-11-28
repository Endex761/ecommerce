<?php
	

	$connessione = connessione_db();
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
	    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
	    <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
	    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<table class="table">
				<thead>
			      <tr>
			        <th>id_prodotto</th>
			        <th>nome_prodotto</th>
			        <th>descrizione</th>
			        <th>prezzo</th>
			        <th>disponibilità</th>
			        <th>foto</th>
			      </tr>
			    </thead>
			    <tbody>
			    	<tr>
			        	<td>1</td>
			        	<td>Comodino</td>
			        	<td>Ottimo comodino</td>
			        	<td>20.5</td>
			        	<td>5</td>
			        	<td>1.jpeg</td>
			      	</tr>
			    	<?php
			    		
			    	?>
			    </tbody>
			</table>
		</div>
	</body>
</html>