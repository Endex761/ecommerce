<?php

  /*
    File: shop.php
    Il file consente di mostrare i prodotti all'interno del database e di effettuare ricerche in base a parole chiave.
  */

  //Includo la libreria di base
  include "libreria.php";

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?status=not_logged");

    /*   */



  //Apro la connessione per poi utilizzarla nelle query
  $connessione = connessione_db();

  /*QUERY DI RICERCA PRODOTTI */

  //Seleziona 9 prodotti casuali da mostrare nello shop
  $search_query = "SELECT * FROM prodotto WHERE disponibilita > 0 ORDER BY rand() LIMIT 9;";

  //Creo la variabile di ricerca
  $ricerca = "";

  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
    //Ricerca dei prodotti nel carrello
    if(isset($_GET['ricerca']))
    {
      //Se il campo 'ricerca' è impostato faccio la ricerca con la seguente query
        $ricerca = test_input($_GET['ricerca']);
        if($ricerca != "")
          $search_query = "SELECT * FROM prodotto WHERE (nome_prodotto LIKE '%{$ricerca}%' OR descrizione LIKE '%{$ricerca}%') ORDER BY rand() LIMIT 9;";
    }
  }

 ?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Shop </title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_bootstrap(); ?>
  </head>
  <body>

    <?php
      //Disegno la navbar e gli passo il campo di ricerca appena effettuato
      $user = $_SESSION['nome'] . " " . $_SESSION['cognome'];
      draw_navbar($ricerca,$user, count_carrello());
    ?>

    <div class="container-fluid">
      <div class="col-xs-12 text-center">
        <h1> Shop </h1>
      </div>

      <!-- prodotti -->
      <div class="col-xs-12">

        <div class="row">

          <?php


            //Invio la query al db
            $result_set = mysqli_query($connessione, $search_query);

            //Controllo se non ci sono errori nella query
            if($result_set == false)
            {
              die(mysqli_error($connessione));
            }

            //Controllo se ci sono righe nel risultato
            if(mysqli_num_rows($result_set) > 0)
            {
              //Counter mi serve per stampare i prodotti a riga ogni 3 prodotti stampati creo una riga
              $counter = 0;

              echo "<div class='row'>";
              //Faccio il fetch dell'array associativo
              while($row = mysqli_fetch_assoc($result_set))
              {
                //Prendo le caratteristiche del prodotto
                $id_prodotto    = $row['id_prodotto'];
                $nome_prodotto  = $row['nome_prodotto'];
                $descrizione    = $row['descrizione'];
                $prezzo         = $row['prezzo'];
                $disponibilita  = $row['disponibilita'];
                $foto           = $row['foto'];

                //stampo il prodotto
                draw_prodotto($id_prodotto, $nome_prodotto, $descrizione, $prezzo, $disponibilita, $foto);

                //Aumento il counter
                $counter++;

                //Ogni tre prodotti chiudo una riga.
                if($counter%3 == 0)
                  echo "</div><div class='row'>";

                //Per l'ultimo prodotto chiudo il  div
                if($counter == 9)
                  echo "</div>";
              }
            }
            else
            {
              //Se non ci sono righe nel result_set stampo "nessun risultato.".
              echo "<h3 class='text-center'> Nessun risultato. </h3>";
            }
          ?>
        </div> <!-- row -->
      </div>
    </div>
    <?php
      draw_footer();
    ?>

  </body>
</html>

<?php
  //Chiudo la connessione al db
  mysqli_close($connessione);
 ?>
