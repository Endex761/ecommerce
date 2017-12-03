<?php

	include "libreria.php";
	$connessione = connessione_db();
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
	    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
	    <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
	  <meta charset="utf-8">
		<?php include_bootstrap(); ?>

		<style>
		.fileupload .btn{vertical-align:middle;}
		.fileupload-exists .fileupload-new,.fileupload-new .fileupload-exists{display:none;}
		.fileupload-inline .fileupload-controls{display:inline;}
		.fileupload-new .input-append .btn-file{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}
		</style>
	</head>
	<body>
		<div class="col-xs-12">
			<table class="table">
				<thead>
			      <tr >
			        <th class="text-center">ID</th>
			        <th class="text-center">Nome</th>
			        <th class="text-center">Descrizione</th>
			        <th class="text-center">Prezzo</th>
			        <th class="text-center">Disponibilità</th>
			        <th class="text-center">Foto</th>
							<th></th>
			      </tr>
			    </thead>
			    <tbody>
			    	<!--<tr>
			        	<td>1</td>
			        	<td>Comodino</td>
			        	<td>Ottimo comodino</td>
			        	<td>20.5</td>
			        	<td>5</td>
			        	<td>1.jpeg</td>
			      	</tr>-->
			    	<?php
							//Creo la query per controllare che i dati inseriti corrispondano a un account e che le credenziali siano giuste
							$query = "SELECT * FROM prodotto;";

							//Lancio la query e metto il risultato nel result_set
							$result_set = mysqli_query($connessione, $query);

							//Controllo se non ci sono errori nella query
							if($result_set == false)
							{
								die(mysqli_error($connessione));
							}

							//Se la query restituisce almeno una riga allora ha trovato una corrispondenza
							if(mysqli_num_rows($result_set) > 0 )
							{
								while($row = mysqli_fetch_assoc($result_set))
								{
									$id_prodotto	  = $row['id_prodotto'];
									$nome_prodotto  = $row['nome_prodotto'];
									$descrizione    = $row['descrizione'];
									$prezzo         = $row['prezzo'];
									$disponibilita 	= $row['disponibilita'];
									$foto         	= $row['foto'];

									echo "<tr class='text-center'>";
									echo "	<td>$id_prodotto</td>";
									echo "	<td>$nome_prodotto</td>";
									echo "	<td>$descrizione</td>";
									echo "	<td>$prezzo</td>";
									echo "	<td>$disponibilita</td>";
									echo "	<td>$foto</td>";
									echo "	<td>";
									echo "		<a href='delete_product.php?id=$id_prodotto'><span class='glyphicon glyphicon-trash'></span></a>";
									echo "	</td>";
									echo "<tr>";
								}
							}
			    	?>

						<tr class= "text-center"> <!--riga per aggiungere un nuovo prodotto -->
							<form action="add_product.php" method="POST" class="form-group" enctype="multipart/form-data">
								<td></td>
								<td><input class="form-control" type="text" name="nome-prodotto" placeholder="Nome prodotto"></td>
								<td><input class="form-control" type="text" name="descrizione" placeholder="Descrizione"></td>
								<td><input class="form-control" type="text" name="prezzo" placeholder="Prezzo"></td>
								<td><input class="form-control" type="number" name="disponibilita" placeholder="Disponibilità"></td>
								<td><input type="file" name="foto"  accept=".jpg, .jpeg, .png"></td>
								<td><button type="submit" class="btn-link"><span class="glyphicon glyphicon-plus"></span></button></td>
							</form>
			    </tbody>
			</table>
		</div>
	</body>
</html>
<?php
			mysqli_close($connessione);
 ?>
