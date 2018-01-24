<?php

  /*
    File:recupero.php
    Il file consente, dopo aver inserito l'email  e la domanda di sicurezza, di resettare la password
    La password verra impostata a "12345678" e verrà consigliato all'utente di cambiarla
    Effettuando l'accesso dopo aver recuperato la password si verrà indirizzati alle impostazioni
  */

  //Includiamo la libreria di base
  include 'libreria.php';

  //Messaggio che avvere l'utente sull'esito dell'operazione, verrà modificato più avanti nel codice.
  $messaggio = "";

  //Se true mostra un pulsante per andare al login
  $modificata = false;

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    //La variabile controlla se tutti i campi del form sono stati inizializati
    $formOk = true;

    if(!empty($_POST['email']))
      $email = test_input($_POST['email']);
    else
      $formOk = false;

    if(!empty($_POST['risposta']))
      $risposta = test_input($_POST['risposta']);
    else
      $formOk = false;

    if(!$formOk)
    {
      errore("Form non compilato correttamente");
      die();
    }

    //Mi connetto al database
    $connessione = connessione_db();

    //Controllo se la risposta corrispondeE
    $query = "SELECT risposta_psw FROM Utente WHERE email ='$email';";

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

       //Prendo la risposta di sicurezza
       $risposta_psw = $row['risposta_psw'];
     }
     else
     {
       //Se non ci sono risultati imposto la risposta a "".
       $risposta_psw = "";
     }

     //Controllo se le due risposte combaciano
     if($risposta == $risposta_psw)
     {
       //Se corrisponde cambio la password in 12345678
       $password_criptata = md5("12345678");
       $query_cambio_password = "UPDATE Utente SET password='$password_criptata' WHERE email='$email';";

       //Invio la query al db
       $result_set = mysqli_query($connessione, $query_cambio_password);

      //Controllo se non ci sono errori nella query
      if($result_set == false)
      {
        die(mysqli_error($connessione));
      }

      //Messaggio che informa l'utente che la password è stata modificata
      $messaggio = "La tua password è stata modifica in '12345678', ti consigliamo di cambiarla nelle impostazioni.";
      $modificata = true;

     }
     else
     {
       //Messaggio che avverte l'utente che la password non è stata modificata
       $messaggio = "Risposta errata, password non recuperata, riprova.";
     }

  }

  //Chiudo la connessione al db
  mysqli_close($connessione);

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Recupero Password </title>
    <?php include_bootstrap(); ?>

  </head>
  <body>

    <section >
      <div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <div class="col-sm-2 col-sm-offset-5 col-xs-6 col-xs-offset-3 img-center">
          <a href="home.php">
            <center><img src="img/logo.png" class="img-responsive img-rounded" width="100px" height="auto"></center>
          </a>
        </div>

        <!-- col-*-offset-* per centrare il contenuto -->
        <div class="col-lg-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" style="border: 2px solid grey; border-radius: 10px; background:#F9F9F9;">


          <div class="col-xm-12">
            <h2>Recupera Password</h2>
            <h4 style="color:red;"><?php echo $messaggio ?></h4>
          </div>


        <form  method="post" name="recupero-form" id="recupero" action="recupero.php">
          <div class="form-group"> <!-- form-attributes----------------------->

            <!-- E-mail -->
            <div class="col-xs-12">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" type="email" class="form-control input-sm" id="email"  autocomplete="off" required>
                </div>
            </div>

            <!-- Recupero password  -->
            <div class="col-xs-12">
                <div class="form-group">
                    <label for="risposta-recupero-psw">Qual è il cognome da nubile di tua madre?</label>
                    <input name="risposta" type="text" class="form-control input-sm" id="risposta-recupero-psw" placeholder="" autocomplete="off" required>
                </div>
            </div>

            <div class="col-xs-12">
              <!-- Bottone Registrati -->
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                      <button type="submit" id="form-submit" class="btn btn-info">Recupera</button>
                  </div>
              </div>
            </div>


          </div>
        </form>

        <div class="col-xs-12" style="margin-bottom:17px;">
          <hr />
          <div class="col-xs-12 text-center">
            <?php
              //Se modificata reindirizzo l'utente al login fornendo al GET l'email dell'Utente
              //Questo mi permette di indirizzarlo direttamente alle impostazioni dopo aver cambiato la password
              if($modificata)
                echo ("<a href='login.php?email=$email'><button type='button' class='btn btn-warning'>Vai al login!</button></a>");
              else
                echo ("<a href='login.php?'><button type='button' class='btn btn-warning'>Vai al login!</button></a>");

            ?>
          </div>
        </div>
      </div>
  </div><!--content-->
  </section>

  <?php
    draw_footer();
  ?>


  <script type="text/javascript" src="js/functions.js"></script>
  </body>
</html>
