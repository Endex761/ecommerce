<?php

  /*
    File:ordini.php

    Il file consente di mostrare gli ordini effettuati ragruppandoli per "carrello" ovvero
    tutti i prodotti acquistati insieme vengono visti come un singolo ordine.
  */

  //Includo la libreria di base
  include "libreria.php";

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?=not-logged");
    /*   */

  //Prendo l'id dell'utente attualmente loggato
  $id_utente = $_SESSION['id_utente'];

  //Creo la connessione la database
  $connessione  = connessione_db();


?>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Ordini </title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/functions.js"></script>
    <?php include_bootstrap(); ?>
  </head>
  <body>
    <?php
      //Disegno la navbar
      $user = $_SESSION['nome'] . " " . $_SESSION['cognome'];
      draw_navbar("",$user, count_carrello());
    ?>

    <div class="container-fluid">
      <div class="col-xs-12 text-center">
        <h1> Ordini effettuati </h1>
      </div>

      <!-- QUI VANNO GLI ORDINI -->
      <div class="col-xs-12" id="ordini">

        <?php

        //Prendo dal db tutti gli acquisti fatti da un utente.
        $query = "SELECT id_acquisto, data_acquisto, acquisto.indirizzo_spedizione AS indirizzo_spedizione, indirizzo_fatturazione, numero_carta FROM carta,utente,acquisto WHERE utente.id_utente = $id_utente AND acquisto.id_utente = utente.id_utente AND carta.id_carta = acquisto.id_carta ORDER BY id_acquisto DESC;";

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
          while($row = mysqli_fetch_assoc($result_set))
          {
            //Prendo le informazioni dell'acqusto
            $id_acquisto = $row['id_acquisto'];
            $data_acquisto = $row['data_acquisto'];
            $indirizzo_spedizione = $row['indirizzo_spedizione'];
            $indirizzo_fatturazione = $row['indirizzo_fatturazione'];
            $numero_carta = $row['numero_carta'];

            //E le stampo attraverso la funzione draw_ordine
            draw_ordine($id_acquisto, $data_acquisto, $indirizzo_spedizione, $indirizzo_fatturazione, $numero_carta, $connessione);
          }

        }
        ?>
      </div>
    </div>

    <?php
      //Disegno il footer
      draw_footer();

      //Chiudo la connessione al db
      mysqli_close($connessione);
    ?>
  </body>
</html>
