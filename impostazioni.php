<?php

  include "libreria.php";

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?=not-logged");
    /*   */

  //Apro la connessione per poi utilizzarla nelle query
  $connessione = connessione_db();


   //Prendo l'indirizzo di spedizione
   $id_utente = $_SESSION['id_utente'];
   $query = "SELECT indirizzo_spedizione FROM utente WHERE id_utente ='$id_utente';";

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
     $indirizzo = $row['indirizzo_spedizione'];
   }


?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/functions.js"></script>
    <?php include_bootstrap(); ?>
  </head>
  <body>
    <script src="js/functions.js"></script>
    <?php
      $user = $_SESSION['nome'] . " " . $_SESSION['cognome'];
      draw_navbar("",$user, count_carrello());
    ?>

    <div class="container-fluid">

      <div class="col-xs-12 text-center">
        <h1> Impostazioni </h1>
      </div>

      <div class="col-sm-9 col-xs-12" style="border-radius: 5px; padding-top:5px; background-color:#F9F9F9">
        <div class="row" style="padding:10px;">
          <div class="col-sm-3 col-xs-12">
            <h4>Indirizzo spedizione:</h4>
          </div>
          <div class="col-sm-9 col-xs-12">
            <div class='input-group'>
              <input name="indirizzo_spedizione" type="text" class="form-control" value="<?php echo $indirizzo ?>">
              <div class='input-group-btn'>
                <button class='btn btn-default' type='submit'>Salva</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-xs-12">
          <h4>Carte</h4>
        </div>
        <div class="col-md-9 col-xs-12">
          <form action="aggiungi_carta.php" method="post">
             <div class='col-sm-9 col-xs-12' class='form-control' style='margin-bottom:20px;'>
               <div class='form-group'>
                 <label for=>Carta</label>
                 <input name='denominazione' type='text' class='form-control' id='denominazione' placeholder="Mastercard, Visa, AmericanExpress..">
               </div>
               <div class='form-group'>
                 <label for='intestatario'>Intestatario</label>
                 <input name='intestatario' type='text' class='form-control' id='intestatario'>
               </div>
               <div class='row'>
                 <div class='col-sm-9 col-xs-8'>
                   <div class='form-group'>
                     <label for='numero_carta'>Numero Carta</label>
                     <input name='numero_carta' type='text' onkeypress="numeroCarta(this);" class='form-control' id='numero_carta'  maxlength="19" placeholder="nnnn-nnnn-nnnn-nnnn" >
                   </div>
                 </div>
                 <div class='col-sm-3 col-xs-4'>
                   <div class='form-group'>
                     <label for='codice_sicurezza'>CVV</label>
                     <input name='codice_sicurezza' type='text' class='form-control' id='codice_sicurezza'  maxlength="5">
                   </div>
                 </div>
               </div>
               <div class='row'>
                 <div class='col-xs-6'>
                   <div class='form-group'>
                     <label for='mese_scadenza'>Mese Scadenza</label>
                     <input name='mese_scadenza' type='text' class='form-control' id='mese_scadenza'  maxlength="2">
                   </div>
                 </div>
                 <div class='col-xs-6'>
                   <div class='form-group'>
                     <label for='anno_scadenza'>Anno Scadenza</label>
                     <input name='anno_scadenza' type='text' class='form-control' id='anno_scadenza'  maxlength="4">
                   </div>
                 </div>
                 <div class="col-xs-6">
                   <button type="submit" class="btn btn-primary">Aggiungi Carta</button>
               </div>
             </div>
          </form>
        </div>
      </div>
    </div>
    <?php
      draw_footer();
    ?>
  </body>
</html>
