<?php

	include "libreria.php";
	//Creo la connessione al database
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

						<!--<tr>
			        <td>id_prodotto</td>
			        <td>nome_prodotto</td>
			        <td>descrizione</td>
			        <td>prezzo</td>
			        <td>disponbilità</td>
			        <td>foto</td>
			      </tr>-->

			    	<?php
			    		//Creo la query per richiedere i prodotti all'interno del database
							$query = "SELECT * FROM prodotto;";

							//Lancio la query e metto il risultato nel result_set
							$result_set = mysqli_query($connessione, $query);

							//Controllo se non ci sono errori nella query
							if($result_set == false)
							{
								die(mysqli_error($connessione));
							}

							//Se la query restituisce almeno una riga
						  if(mysqli_num_rows($result_set) > 0 )
						  {
						    //Faccio il fetch dell'array associativo
						    //$row è un array associativo contente una tupla che descrive un prodotto
						    while($row = mysqli_fetch_assoc($result_set))
								{
									//Stampo gli elementi di una riga
									echo "<tr>";
									foreach ($row as $value)
									{
											echo "<td>$value</td>";
									}
									echo "</tr>";
								}
							}

			    	?>
			    </tbody>
			</table>
		</div>
	</body>
</html>

<?php
	mysqli_close($connessione);
 ?>
