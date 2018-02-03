<?php

	/*
		File: prodotti.php
		IL file consente di stampare una tabella contente tutte le informazioni riguardanti i prodotti all'interno del database
		Consente di eliminare, aggiungere o rifornire i vari prodotti prodotti.
		I prodotti sono ordinati in modo da mostrare quelli con un disponibilità minore più in alto.
	*/
	//Includo la libreria di base
	include "libreria.php";

	/*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

	//Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['ADMIN']))
    reindirizza("login.php?status=not_logged");

    /*   */

		//Creo la connessione al db
		$connessione = connessione_db();

		if($_SERVER["REQUEST_METHOD"] == "GET")
		{
			//Se add è settato aumentimo di 1 la disponibilità del prodotto
			if(isset($_GET['add']))
			{
				//Prendo il valore di add e lo metto nella variabile dopo averlo testato
				$add = test_input($_GET['add']);

				//Prendo la disponibilità del prodotto che intendo rifornire
				$query = "SELECT disponibilita FROM Prodotto WHERE id_prodotto=$add;";

				//Invio la query al db
				$result_set = mysqli_query($connessione, $query);

				//Controllo se non ci sono errori nella query
				if($result_set == false)
				{
					die(mysqli_error($connessione));
				}

				//Controllo se ci sono righe nel risultato
				if(mysqli_num_rows($result_set) > 0)
				{
					//Faccio il fetch dell'array associativo
					$row = mysqli_fetch_assoc($result_set);
					$disponibilita = $row['disponibilita'];
				}
				//Aumento la disponibilità di uno
				$disponibilita_aggiornata = $disponibilita + 1;

				//E la inserisco nel database
				$query_rifornimento = "UPDATE prodotto SET disponibilita=$disponibilita_aggiornata WHERE id_prodotto=$add;";

				//Invio la query al db
				$result_set = mysqli_query($connessione, $query_rifornimento);

				//Controllo se non ci sono errori nella query
				if($result_set == false)
				{
					die(mysqli_error($connessione));
				}
			}
		}

//AUMENTO IL PREZZO
		if(isset($_GET['plus']))
		{
			//Prendo il valore di add e lo metto nella variabile dopo averlo testato
			$plus = test_input($_GET['plus']);

			//Prendo la disponibilità del prodotto che intendo rifornire
			$query = "SELECT prezzo FROM Prodotto WHERE id_prodotto=$plus;";

			//Invio la query al db
			$result_set = mysqli_query($connessione, $query);

			//Controllo se non ci sono errori nella query
			if($result_set == false)
			{
				die(mysqli_error($connessione));
			}

			//Controllo se ci sono righe nel risultato
			if(mysqli_num_rows($result_set) > 0)
			{
				//Faccio il fetch dell'array associativo
				$row = mysqli_fetch_assoc($result_set);
				$prezzo = $row['prezzo'];
			}
			//Aumento la disponibilità di uno
			$prezzo_aggiornato = $prezzo + 1.0;

			//E la inserisco nel database
			$query_rifornimento = "UPDATE prodotto SET prezzo=$prezzo_aggiornato WHERE id_prodotto=$plus;";

			//Invio la query al db
			$result_set = mysqli_query($connessione, $query_rifornimento);

			//Controllo se non ci sono errori nella query
			if($result_set == false)
			{
				die(mysqli_error($connessione));
			}

		}
//DIMINUISCO IL PREZZO
		if(isset($_GET['minus']))
		{
			//Prendo il valore di add e lo metto nella variabile dopo averlo testato
			$minus = test_input($_GET['minus']);

			//Prendo la disponibilità del prodotto che intendo rifornire
			$query = "SELECT prezzo FROM Prodotto WHERE id_prodotto=$minus;";

			//Invio la query al db
			$result_set = mysqli_query($connessione, $query);

			//Controllo se non ci sono errori nella query
			if($result_set == false)
			{
				die(mysqli_error($connessione));
			}

			//Controllo se ci sono righe nel risultato
			if(mysqli_num_rows($result_set) > 0)
			{
				//Faccio il fetch dell'array associativo
				$row = mysqli_fetch_assoc($result_set);
				$prezzo = $row['prezzo'];
			}
			//Aumento la disponibilità di uno
			$prezzo_aggiornato = $prezzo - 1.0;

			//E la inserisco nel database
			$query_rifornimento = "UPDATE prodotto SET prezzo=$prezzo_aggiornato WHERE id_prodotto=$minus;";

			//Invio la query al db
			$result_set = mysqli_query($connessione, $query_rifornimento);

			//Controllo se non ci sono errori nella query
			if($result_set == false)
			{
				die(mysqli_error($connessione));
			}
		}

?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
	  <meta charset="utf-8">
		<title>RS Furnitures - Prodotti</title>
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
			<a href="logout.php">Esci</a>
		</div>

		<div class="col-xs-12">
			<table class="table table-bordered">
				<thead>
			      <tr >
			        <th class="text-center">ID</th>
			        <th class="text-center">Nome</th>
			        <th class="text-center">Descrizione</th>
			        <th class="text-center">Prezzo</th>
			        <th class="text-center">Disponibilità</th>
			        <th class="text-center">Foto</th>
							<th class="text-center">Acquisti</th>
							<th></th>
			      </tr>
			    </thead>
			    <tbody>

						<tr class= "text-center"> <!--riga per aggiungere un nuovo prodotto -->
							<form action="add_product.php" method="POST" class="form-group" enctype="multipart/form-data">
								<td></td>
								<td><input class="form-control" type="text" name="nome-prodotto" placeholder="Nome prodotto"></td>
								<td><input class="form-control" type="text" name="descrizione" placeholder="Descrizione"></td>
								<td><input class="form-control" type="text" name="prezzo" placeholder="Prezzo"></td>
								<td><input class="form-control" type="number" name="disponibilita" placeholder="Disponibilità"></td>
								<td><input type="file" name="foto"  accept=".jpg, .jpeg"></td>
								<td></td>
								<td><button type="submit" class="btn-link"><span class="glyphicon glyphicon-plus"></span></button></td>
							</form>
						</tr>
			    	<!--<tr>
			        	<td>1</td>
			        	<td>Comodino</td>
			        	<td>Ottimo comodino</td>
			        	<td>20.5</td>
			        	<td>5</td>
			        	<td>1.jpeg</td>
			      	</tr>-->
			    	<?php
							//Creo la query per prendere i prodotti nel database in ordine di disponibilita, i meno disponibili stanno in cima
							$query = "SELECT * FROM prodotto ORDER BY disponibilita ASC;";

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
									//Prendo i dati relativi a un singolo prodotto
									$id_prodotto	  = $row['id_prodotto'];
									$nome_prodotto  = $row['nome_prodotto'];
									$descrizione    = $row['descrizione'];
									$prezzo         = $row['prezzo'];
									$disponibilita 	= $row['disponibilita'];
									$foto         	= $row['foto'];

									//Prendo il numero di prodotti acquistati
									$q = "SELECT SUM(quantita) AS sum FROM acquistosingolo WHERE id_prodotto = $id_prodotto;";
									$rs = mysqli_query($connessione, $q);
									$r = mysqli_fetch_assoc($rs);
									$acquisti = $r['sum'];
									if($acquisti == "")
										$acquisti = 0;

									//Le li stampo all'interno di una tabella

									echo "<tr class='text-center'>";
									echo "	<td>$id_prodotto</td>";
									echo "	<td>$nome_prodotto</td>";
									echo "	<td>$descrizione</td>";
									echo "	<td><a href='prodotti.php?minus=$id_prodotto'><span class='glyphicon glyphicon-minus'></span></a> $prezzo <a href='prodotti.php?plus=$id_prodotto'><span class='glyphicon glyphicon-plus'></span></a></td>";

									//Se la disponibilità è 0 coloro il numero di ROSSO
									if($disponibilita == 0)
										echo "<td style='color:red;'>$disponibilita <a href='prodotti.php?add=$id_prodotto'>Rifornisci</a></td>";
									else
										echo "<td>$disponibilita <a href='prodotti.php?add=$id_prodotto'>Rifornisci</a></td>";
									echo "	<td>$foto</td>";
									echo "	<td>$acquisti</td>";
									echo "	<td>";
									echo "		<a href='delete_product.php?id=$id_prodotto'><span class='glyphicon glyphicon-trash'></span></a>";
									echo "	</td>";
									echo "<tr>";
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
