<?php

  /*
  File: acqusitato.php
  Lo script consente di inserire all'interno del database l'acquisto degli articoli presenti all'interno del carello.
  Una volta acqusitati aggiorna la disponibilità dei prodotti all'interno del database.
  */

  //Includiamo la libreria di funzioni e costanti definite nel file libreria.php
  include 'libreria.php';

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?status=not_logged");

  /*   */

  //Prendo l'id dell'utente appena collegato
  $id_utente = $_SESSION['id_utente'];

  //Creo la connessione al database
  $connessione = connessione_db();

  //Se il coockie del carrello è già impostato
  if(isset($_COOKIE['carrello']))
  {
    //Prendo il cookie e lo assegno al carrello
    $carrello = unserialize($_COOKIE['carrello']);
  }
  else//Altrimenti
  {
    //Stampo un messaggio d'errore, l'utente non puo' acquistare nulla se il carrello è vuoto.
    errore("Carrello vuoto");
    //Termino lo script
    die();
  }

  //Se sto utilizzando il post
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    //Flag che ci permette di controllare se il form è ok
    $formOk = true;

    //Prendo le informazioni passate dal form in acquisto.php
    if(!empty($_POST['indirizzo_spedizione']))
      $indirizzo_spedizione = test_input($_POST['indirizzo_spedizione']);
    else
      $formOk = false;

    if(!empty($_POST['indirizzo_fatturazione']))
      $indirizzo_fatturazione = test_input($_POST['indirizzo_fatturazione']);
    else
      $formOk = false;

    if(!empty($_POST['id_carta']))
      $id_carta = test_input($_POST['id_carta']);
    else
      $formOk = false;

    //Se la checkbox è spuntata imposto stesso indirizzo di fatturazione e spedizione
    if(!empty($_POST['checkbox']))
      $indirizzo_fatturazione = $indirizzo_spedizione;

    //Controllo se il form è ok
    if(!$formOk)
    {
      errore("Form non compilato correttamente");
      die();
    }
  }
  else//Se non uso il metodo post.
  {
    errore("Errore generico");
    die();
  }

  //Creo un acquisto nel database
  $query = "INSERT INTO Acquisto (data_acquisto,indirizzo_spedizione,indirizzo_fatturazione, id_utente, id_carta) VALUES (CURDATE(),'$indirizzo_spedizione','$indirizzo_fatturazione',$id_utente,$id_carta);";

  //Invio la query al db
  $result_set = mysqli_query($connessione, $query);

  //Controllo se non ci sono errori nella query
  if($result_set == false)
  {
    die(mysqli_error($connessione));
  }

  //Prendo l'id dell'ultimo acquisto inserito, questo per poter collegare i vari acquisti singoli all'acquisto
  $query_id = "SELECT LAST_INSERT_ID() AS last_id;";

  //Invio la query al db
  $result_set = mysqli_query($connessione, $query_id);

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

    //Prendo l'ultimo id inserito in acquisto
    $id_acquisto = $row['last_id'];

    //Codice di debug.
    if($id_acquisto == 0)
      errore("Debug: Id acquisto = 0");
  }
  else
  {
    //Codice di debug.
    errore("Debug: Nessun last id");
  }

  //Per ogni prodotto all'interno del carrello
  foreach ($carrello as $id_prodotto => $quantita)
  {
    // Seleziono il prezzo d'acquisto del prodotto
    $query = "SELECT prezzo, disponibilita FROM Prodotto WHERE id_prodotto=$id_prodotto;";

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

      //Ottengo il prezzo dell'articolo
      $prezzo = $row['prezzo'];

      //Ottengo la disponibilità attuale dell'articolo
      $disponibilita_attuale = $row['disponibilita'];

      //Se la disponibilità dell'articolo è minore della quantità che si intende acquistare
      if($disponibilita_attuale < $quantita)
      {
        //Mando un messaggio d'errore
        errore("La disponibilità di alcuni prodotti è cambiata");
        die();
      }

    }

    //inserisco il prodotto acquistato nel database
    $query_inserimento = "INSERT INTO AcquistoSingolo(prezzo_acquisto,quantita,id_acquisto,id_prodotto) VALUES ($prezzo,$quantita,$id_acquisto,$id_prodotto);";

    //Invio la query al db
    $result_set = mysqli_query($connessione, $query_inserimento);

    //Controllo se non ci sono errori nella query
    if($result_set == false)
    {
      die(mysqli_error($connessione));
    }

    //Modifico la disponibilità dei prodotti nel database
    $disponibilita_aggiornata = $disponibilita_attuale - $quantita;
    $query_update = "UPDATE prodotto SET disponibilita=$disponibilita_aggiornata WHERE id_prodotto=$id_prodotto;";

    //Invio la query al db
    $result_set = mysqli_query($connessione, $query_update);

    //Controllo se non ci sono errori nella query
    if($result_set == false)
    {
      die(mysqli_error($connessione));
    }
  } //Chiusura foreach

  //Rimuovo i prodotti dal Carrello facendo scadere il cookie
  setcookie('carrello','',1);

  //Chiudo la connessione al database
  mysqli_close($connessione);

?>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Acquisto Effettuato </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/functions.js"></script>
    <?php include_bootstrap(); ?>
  </head>
  <body>
    <div class="container-fluid">
      <div class="col-xs-12 text-center" >
        <h1 style="color:green;"> Acquisto Confermato</h1>
      </div>
      <div class="row">
        <div class="col-md-6 col-xs-12 text-center">
          <a href="shop.php"><h2>Torna allo Shop</h2></a>
        </div>
        <div class="col-md-6 col-xs-12 text-center">
          <a href="ordini.php"><h2>Visualizza Acquisti</h2></a>
        </div>
      </div>
      <?php
        draw_footer();
       ?>
  </body>

</html>
