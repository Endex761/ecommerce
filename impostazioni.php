<?php

  /*
    File:impostazioni.php
    Il file in questione permette di gestire l'indirizzo di spedizione predefinito, inserire un nuovo
    metodo di pagamento e di modificare la password dell'acount.
  */

  include "libreria.php";

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?=not-logged");
    /*   */

  //Prendo l'id dell'utente loggato
  $id_utente = $_SESSION['id_utente'];

  //Modificato si riferisce all'indirizzo, se è stato modificato verra impostato a true successivamente
  $modificato = false;

  //Se la password viene modificata con successo verrà impostato a true
  $password_modificata = false;

  //La variabile controlla se tutti i campi del form sono stati inizializati
  $formOk = true;

  //Apro la connessione per poi utilizzarla nelle query
  $connessione = connessione_db();

  //Se richiesto modifico l'indirizzo di spedizone predefinito
  if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['password']))
  {
    //La variabile controlla se tutti i campi del form sono stati inizializati
    $formOk = true;

    if(!empty($_POST['password']))
      $password = test_input($_POST['password']);
    else
      $formOk = false;

    if(!empty($_POST['password_vecchia']))
      $password_vecchia = test_input($_POST['password_vecchia']);
    else
      $formOk = false;

    if(!$formOk)
    {
      errore("Form non compilato correttamente");
      die();
    }

    //Prendo la password attuale
    $query = "SELECT password FROM utente WHERE id_utente ='$id_utente';";

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
       $password_attuale = $row['password'];
     }

   //Se la vecchia password corrisponde con la password attuale
   if($password_attuale == md5($password_vecchia))
   {
     //Allora procedo al cambio della password
     $nuova_password_criptata = md5($password);
     $query_modifica = "UPDATE Utente SET password='$nuova_password_criptata' WHERE id_utente=$id_utente;";

     //Invio la query al db
     $result_set = mysqli_query($connessione, $query_modifica);

     //Controllo se non ci sono errori nella query
     if($result_set == false)
     {
       die(mysqli_error($connessione));
     }
      //Se abbiamo modificato la password mettiamo questo flag a true che farà in modo di
      //stampare la scritta "Password Cambiata"
     $password_modificata = true;
   }
 }

//Cambiamo l'indirizzo di spedizione predefinito
 if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nuovo_indirizzo']))
 {
   //Se il nuovo indirizzo è impstato
    if(!empty($_POST['nuovo_indirizzo']))
    {
      //Lo mettiamo nella variabile
      $nuovo_indirizzo = test_input($_POST['nuovo_indirizzo']);
    }
    else if(!$formOk)
    {
      //Stampiamo un messaggio d'errore
      errore("Form non compilato correttamente");
      die();
    }

    //Creo la query per modificare l'indirizzo di spedizione
    $query_modifica = "UPDATE Utente SET indirizzo_spedizione='$nuovo_indirizzo' WHERE id_utente=$id_utente;";

    //Invio la query al db
    $result_set = mysqli_query($connessione, $query_modifica);

    //Controllo se non ci sono errori nella query
    if($result_set == false)
    {
      die(mysqli_error($connessione));
    }

    //Se abbiamo modificato l'indirizzo mettiamo questo flag a true che farà in modo di
    //stampare la scritta "Salvato"
    $modificato = true;
  }

   //Prendo l'indirizzo di spedizione
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

   //Chiudo la connessione al db
   mysqli_close($connessione);

?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <!--<link rel="stylesheet" type="text/css" href="css/basic.css">-->
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <meta charset="utf-8">
    <title>RS Furnitures - Impostazioni </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/functions.js"></script>
    <?php include_bootstrap(); ?>

  </head>
  <body>
    <?php
    //Prendo nome e cognome dell'utente e stampo la navbar
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
            <form action="impostazioni.php" method="post">
            <div class='input-group'>
              <input name="nuovo_indirizzo" type="text" class="form-control" value="<?php echo $indirizzo ?>">
              <div class='input-group-btn'>
                <button class='btn btn-default' type='submit'>Salva</button>
              </div>
            </div>
            <?php
              //Se abbiamo modificato l'indirizzo stampa "Salvato"
              if($modificato)
                echo "<h5 style='color:green;'>Salvato</h5>";
            ?>

            </form>
          </div>
        </div>
        <!-- INSERIMENTO CARTA -->
        <div class="col-sm-3 col-xs-12">
          <h4>Aggiungi Carta</h4>
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
                     <input name='numero_carta' type='text' onkeypress="numeroCarta(this);" class='form-control' id='numero_carta'  maxlength="19">
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
                     <input name='mese_scadenza' oninput="return checkMonth(this);" type='text' class='form-control' id='mese_scadenza'  maxlength="2">
                   </div>
                 </div>
                 <div class='col-xs-6'>
                   <div class='form-group'>
                     <label for='anno_scadenza'>Anno Scadenza</label>
                     <input name='anno_scadenza' oninput="return checkYear(this)" type='text' class='form-control' id='anno_scadenza'  maxlength="4">
                   </div>
                 </div>
                 <div class="col-xs-6">
                   <button type="submit" class="btn btn-primary">Aggiungi Carta</button>
                 </div>
               </div>
          </form>
        </div>
      </div>

      <!-- CAMBIO PASSWORD -->
      <div class="col-sm-3 col-xs-12">
        <h4>Cambia Password</h4>
        <?php
        //Se abbiamo modificato la password stampa "Passwword Cambiata"
          if($password_modificata)
            echo "<h5 style='color:green;'>Password Cambiata</h5>";
        ?>
      </div>
      <div class="col-md-9 col-xs-12">
        <form action="impostazioni.php" method="post">
          <div class="col-sm-9 col-xs-12">
              <div class="form-group contact-field">
                  <label for="password">Vecchia Password</label>
                  <input name="password_vecchia" type="password"  class="form-control input-sm" id="password_vecchia" minlength="8" maxlength="16"  required>
              </div>

              <div class="form-group contact-field">
                  <label for="password">Nuova Password</label>
                  <input name="password" type="password"  class="form-control input-sm" id="password" minlength="8" maxlength="16"  required>
              </div>

              <div class="form-group contact-field">
                  <label for="password">Ripeti Nuova Password</label>
                  <input name="conferma_password" type="password" oninput="checkPassword(this);"  class="form-control input-sm" id="conferma_password" minlength="8" maxlength="16"  required>
              </div>


              <div class="form-group">
                <button type="submit" id="form-submit" class="btn btn-primary"> Cambia Password </button>
              </div>

          </div>
        </form>
      </div>


    </div>
    <?php
      draw_footer();
    ?>
  </body>
</html>
