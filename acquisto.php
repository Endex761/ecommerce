<?php

  /*
  File: acquisto.php
  Lo script consente di scegliere l'indirizzo di spedizione, fatturazione e il metodo di pagamento per acquistare
  i prodotti all'interno del carrello.
  Dopo aver controllato che il carello contiene articoli viene calcolato e mostrato il totale degli articoli
  e il numero di articoli che si stanno per acquistare con la possibilità di tornare rapidamente al carrello.
  */

  //Includiamo la libreria di funzioni e costanti definite nel file libreria.php
  include 'libreria.php';

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?=status=not_logged");

  /*   */

  //Prendo l'id dell'utente attualmente collegato.
  $id_utente = $_SESSION['id_utente'];

  //Creo la connessione al database
  $connessione = connessione_db();

  //Se il cookie del carrello è impostato.
  if(isset($_COOKIE['carrello']))
  {
    //Prendo il cookie e lo assegno al carrello
    $carrello = unserialize($_COOKIE['carrello']);
  }
  else
  {
    //Altrimenti creo un nuovo array che conterrà le informazioni del carrello
    $carrello = array();
  }

  //Calcola quandi articoli ci sono nel carrello.
  $count_carrello = 0;
  foreach ($carrello as $quantita)
    $count_carrello += $quantita;

  //Calcolo il totale degli aritcoli
  $totale = 0.0;

  //Per ogni prodotto nel carello
  foreach ($carrello as $id_prodotto => $quantita)
  {
    //Seleziono il prezzo del prodotto
    $query = "SELECT prezzo FROM Prodotto WHERE id_prodotto=$id_prodotto;";

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

      //Aggiungo al totale il prezzo del prodotto per la quantità
      $totale += $row['prezzo'] * $quantita;
    }
    else
    {
      errore("Errore generale.");
    }
  } //Fine calcolo totale
 ?>

 <html>
   <head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
     <title>RS Furnitures - Acquisto </title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <script src="js/functions.js"></script>
     <?php include_bootstrap(); ?>
   </head>
   <body onload="disableEnable('fatturazione');">
     <!-- al caricamento uso la funzione disableEnable per disattivare a prescindere il box dell'indirizzo di fatturazione-->
     <form action="acquistato.php" method="post">
       <!-- il form comprende la carta selezionata, gli indirizzi di spedizione e fatturazione e il bottone conferma di submit -->

     <div class="container-fluid">

       <div class="col-xs-12 text-center" >
         <h1> Spedizione & Pagamento </h1>
       </div>
       <!-- CONFERMA -->

       <div class="col-sm-3 col-xs-12 pull-right text-center" style="background-color:#F3F3F3; padding-bottom:5px; border-radius: 5px;">
         <div "col-xs-12">
           <h3>Totale <a href="carrello.php">(<?php echo $count_carrello ?> prodotti)</a></h3>
         </div>
         <div "col-xs-12">
           <h2 style="color:red;">€<?php echo $totale ?></h2>
         </div>
         <div "col-xs-12">
           <button type="submit" class="btn btn-success <?php if(!$count_carrello) echo 'disabled' ?>">Conferma</button>
         </div>
       </div>

       <!-- SPEDIZIONE -->

       <?php
        //Prendo l'indirizzo di spedizione
        $query = "SELECT indirizzo_spedizione FROM utente WHERE id_utente = $id_utente;";

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

          //Prendo l'indirizzo di spedizione predefinito
          $indirizzo = $row['indirizzo_spedizione'];
        }


        ?>
       <div class="col-sm-9 col-xs-12" style="border-radius: 5px; padding-top:5px; background-color:#F9F9F9">
         <div class="row" style="padding:10px;">
           <div class="col-sm-3 col-xs-12">
             <h4>Indirizzo spedizione:</h4>
           </div>
           <div class="col-sm-9 col-xs-12">
             <input name="indirizzo_spedizione" type="text" class="form-control" value="<?php echo $indirizzo ?>">
             <br>
             <label onclick="disableEnable('fatturazione');"><input id="checkbox" name="checkbox" type="checkbox" checked> Utilizza questo indirizzo come indirizzo di fatturazione.</label>
             <br>
             <a href="impostazioni.php#nuovo_indirizzo">Cambia indirizzo di spedizione predefinito.</a>
           </div>
         </div>

         <div id="fatturazione" class="row" style="padding:10px;">
           <div class="col-sm-3 col-xs-12">
             <h4>Indirizzo fatturazione:</h4>
           </div>
           <div class="col-sm-9 col-xs-12">
             <input name="indirizzo_fatturazione" type="text" class="form-control" value="<?php echo $indirizzo ?>" >
             <br>
           </div>
         </div>
       </div>

       <div class="col-xs-9">
         <br>
       </div>

       <!-- PAGAMENTO -->
       <div class="col-sm-9 col-xs-12" style="border-radius: 5px; padding-top:5px; background-color:#F9F9F9">
         <div class="col-sm-3 col-xs-12">
           <h4>Metodo Pagamento:</h4>
           <!--<h6>(Le tue carte)</h6>-->
         </div>

         <div class="col-sm-9 col-xs-12"> <!-- QUI DENTRO VANNO LE CARTE -->

           <div class ="col-sm-9 col-xs-12">
                <label class='pull-right' for='contrassegno'>Pagamento in contrassegno </label><input class='pull-right' type='radio' name='id_carta' value='999' required>
           </div>

           <div class="col-xs-12">
             <br>
           </div>

           <br>
          <?php
            //Stampiamo le carte dell'utente
            //$id_utente = $_SESSION['id_utente']; dichiarato sopra

            //Seleziono tutte le informazioni relative alle carte dell'utente
            $query = "SELECT * FROM Carta WHERE id_utente = '$id_utente';";

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
                //Per ogni carta all'interno del resultset
                //Seleziono i seguenti attributi
                $id_carta           = $row['id_carta'];
                $intestatario       = $row['intestatario'];
                $numero_carta       = $row['numero_carta'];
                $mese_scadenza      = $row['mese_scadenza'];
                $anno_scadenza      = $row['anno_scadenza'];
                $codice_sicurezza   = $row['codice_sicurezza'];
                $denominazione      = $row['denominazione'];

                //Stampo gli attributi attraverso la funzione draw carta.
                draw_carta($id_carta, $intestatario, $numero_carta, $mese_scadenza, $anno_scadenza, $codice_sicurezza, $denominazione);
              }
            }
            else
            {
              //Se non ci sono righe nel risultato avverto l'utente che non ha inserito nessuna carta
              echo "<h3>Non hai inserito nessuna carta</h3>";

              //Fornisco all'utente il link per aggiungere una nuova carta.
              echo "<a href='impostazioni.php#denominazione'>Vai alle impostazioni</a>";
            }
           ?>
         </div> <!-- FINE CARTE -->
       </div>
       </form>

     <?php draw_footer(); ?>
   </body>
</html>

<?php
  //Chiudo la connessione al database.
  mysqli_close($connessione);
 ?>
