<?php
  include 'libreria.php';

  $connessione = connessione_db();

  if(isset($_COOKIE['carrello']))
  {
    //Prendo il cookie e lo assegno al carrello
    $carrello = unserialize($_COOKIE['carrello']);
  }
  else
  {
    //Altrimenti creo un nuovo array
    $carrello = array();
  }

  //Calcola quandi articoli ci sono nel carrello.
  $count_carrello = 0;
  foreach ($carrello as $value)
    $count_carrello += $value;

  //Calcolo il totale degli aritcoli
  $totale = 0.0;

  foreach ($carrello as $id_prodotto => $quantita)
  {
    $query = "SELECT prezzo FROM Prodotto WHERE id_prodotto=$id_prodotto";

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
     <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
     <!--<link rel="stylesheet" type="text/css" href="css/navbar.css">-->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <script src="js/functions.js"></script>
     <?php include_bootstrap(); ?>
   </head>
   <body>

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
           <a href="acquisto.php"><button type="button" class="btn btn-success <?php if(!$count_carrello) echo 'disabled' ?>">Conferma</button></a>
         </div>
       </div>

       <!-- SPEDIZIONE -->
       <div class="col-sm-9 col-xs-12" style="border-radius: 5px; padding-top:5px; background-color:#F9F9F9">
         <div class="row" style="padding:10px;">
           <div class="col-sm-3 col-xs-12">
             <h4>Indirizzo spedizione:</h4>
           </div>
           <div class="col-sm-9 col-xs-12">
             <input type="text" class="form-control" value="Via Ciaculli 14, Palermo, Italia.">
             <br>
             <label onclick="disableEnable('fatturazione');"><input id="checkbox" type="checkbox" checked> Utilizza questo indirizzo come indirizzo di fatturazione.</label>
             <br>
             <a>Cambia indirizzo di spedizione predefinito</a>
           </div>
         </div>

         <div id="fatturazione" class="row" style="padding:10px;">
           <div class="col-sm-3 col-xs-12">
             <h4>Indirizzo fatturazione:</h4>
           </div>
           <div class="col-sm-9 col-xs-12">
             <input type="text" class="form-control" value="Via Ciaculli 14, Palermo, Italia." >
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
           <h6>(Le tue carte)</h6>
         </div>

         <div class="col-sm-9 col-xs-12"> <!-- QUI DENTRO VANNO LE CARTE -->
           <form>

             <div class="col-sm-9 col-xs-12" class="form-control" style="margin-bottom:20px;">

               <div class="form-group">
                  <label for="indirizzo">Carta</label>
                  <label class="pull-right" for="seleziona">Seleziona</label><input class="pull-right" type="radio" name="card" checked>
                  <input type="text" class="form-control" id="denominazione" value="Mastercard" disabled>
             </div>
             <div class="form-group">
                 <label for="indirizzo">Intestatario</label>
                 <input name="indirizzo" type="text" class="form-control" id="intestatario" value="Simon Pietro Romeo" disabled>
             </div>
             <div class="row">
               <div class="col-sm-9 col-xs-8">
                 <div class="form-group">
                     <label for="indirizzo">Numero Carta</label>
                     <input name="indirizzo" type="text" class="form-control" id="mese-scadenza" value="**** **** **** 7593" disabled>
                 </div>
               </div>
               <div class="col-sm-3 col-xs-4">
                 <div class="form-group">
                     <label for="indirizzo">CVV</label>
                     <input name="indirizzo" type="text" class="form-control" id="anno-scadenza" value="2020" disabled>
                 </div>
               </div>
             </div>
             <div class="row">
               <div class="col-xs-6">
                 <div class="form-group">
                     <label for="indirizzo">Mese Scadenza</label>
                     <input name="indirizzo" type="text" class="form-control" id="mese-scadenza" value="11" disabled>
                 </div>
               </div>
               <div class="col-xs-6">
                 <div class="form-group">
                     <label for="indirizzo">Anno Scadenza</label>
                     <input name="indirizzo" type="text" class="form-control" id="anno-scadenza" value="2020" disabled>
                 </div>
               </div>
             </div>
           </div>


              <div class="col-sm-9 col-xs-12" class="form-control" style="margin-bottom:10px;">

                <div class="form-group">
                    <label for="indirizzo">Carta</label><label class="pull-right" for="indirizzo">Seleziona</label><input class="pull-right" type="radio" name="card">
                    <input type="text" class="form-control" id="denominazione" value="Mastercard" disabled>
                </div>
                <div class="form-group">
                    <label for="indirizzo">Intestatario</label>
                    <input name="indirizzo" type="text" class="form-control" id="intestatario" value="Simon Pietro Romeo" disabled>
                </div>
                <div class="row">
                  <div class="col-sm-9 col-xs-8">
                    <div class="form-group">
                        <label for="indirizzo">Numero Carta</label>
                        <input name="indirizzo" type="text" class="form-control" id="mese-scadenza" value="**** **** **** 7593" disabled>
                    </div>
                  </div>
                  <div class="col-sm-3 col-xs-4">
                    <div class="form-group">
                        <label for="indirizzo">CVV</label>
                        <input name="indirizzo" type="text" class="form-control" id="anno-scadenza" value="2020" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                        <label for="indirizzo">Mese Scadenza</label>
                        <input name="indirizzo" type="text" class="form-control" id="mese-scadenza" value="11" disabled>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                        <label for="indirizzo">Anno Scadenza</label>
                        <input name="indirizzo" type="text" class="form-control" id="anno-scadenza" value="2020" disabled>
                    </div>
                  </div>
                </div>
              </div>
            </form>
         </div> <!-- FINE CARTE -->
       </div>





     <?php draw_footer(); ?>
   </body>
</html>

<?php
  mysqli_close($connessione);
 ?>
