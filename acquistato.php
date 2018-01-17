<?php
  include 'libreria.php';

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?status=not_logged");

  /*   */

  $id_utente = $_SESSION['id_utente'];

  $connessione = connessione_db();

  if(isset($_COOKIE['carrello']))
  {
    //Prendo il cookie e lo assegno al carrello
    $carrello = unserialize($_COOKIE['carrello']);
  }
  else
  {
    errore("Carrello vuoto");
    die();
  }

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $formOk = true;

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

    if(!empty($_POST['checkbox']))
      $indirizzo_fatturazione = $indirizzo_spedizione;
      //Se la checkbox è ok imposto stesso indirizzo per entrambi.

    if(!$formOk)
    {
      errore("Form non compilato correttamente");
      die();
    }
  }
  else
  {
    errore("Errore generico");
    die();
  }

  //Creo un acquisto nel database
  $query = "INSERT INTO Acquisto (data_acquisto,indirizzo_spedizione,indirizzo_fatturazione, id_utente, id_carta) values (CURDATE(),'$indirizzo_spedizione','$indirizzo_fatturazione',$id_utente,$id_carta);";


  //Invio la query al db
  $result_set = mysqli_query($connessione, $query);

  //Controllo se non ci sono errori nella query
  if($result_set == false)
  {
    die(mysqli_error($connessione));
  }
  $query_id = "SELECT LAST_INSERT_ID() as last_id;";
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
    $row = mysqli_fetch_assoc($result_set);
    $id_acquisto = $row['last_id'];

    if($id_acquisto == 0)
      errore("Debug: Id acquisto = 0");
  }
  else
  {
    errore("Debug: Nessun last id");
  }

  foreach ($carrello as $id_prodotto => $quantita)
  {
    /* Prendo il prezzo d'acquisto del prodotto*/
    $query = "SELECT prezzo, disponibilita FROM Prodotto WHERE id_prodotto=$id_prodotto";

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
      $disponibilita_attuale = $row['disponibilita'];

      if($disponibilita_attuale < $quantita)
      {
        errore("La disponibilità di alcuni prodotti è cambiata");
      }

    }



    //inserisco il prodotto acquistato nel database
    $query_inserimento = "INSERT INTO AcquistoSingolo(prezzo_acquisto,quantita,id_acquisto,id_prodotto) values ($prezzo,$quantita,$id_acquisto,$id_prodotto);";

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

  //Rimuovo i prodotti dal Carrello
  setcookie('carrello','',1);


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
          <a href="shop.php"><h2>Torna allo shop</h2></a>
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
