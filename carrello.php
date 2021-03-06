<?php
  /*
  File:carrello.php
  Questo file contine lo script php per mostrare gli elementi presenti all'interno del carrello dell'utente.
  Il carrello è stato implementato utilizzando i cookie.
  All'interno della variabile $_COOKIE['carrello'] viene memorizzato un array associativo.
  L'array in questione ha per chiave l'id del prodotto che l'utente ha inserito nel carrello, e
  come valore la quantita di prodotto che vuole acquistare.
  Lo script oltre che a mostrare il contenuto attraverso la funzione draw_prodotto_carrello consente
  attraverso il metodo GET di incrementare, diminuire o rimuovere un prodotto dal carrello.
  */

  include 'libreria.php';

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?status=not_logged");
  /*   */

  //Questo file permette la gestione del carrello


  //Apro la connessione al database
  $connessione = connessione_db();

  /*Gestione dei cookie*/
  //Utilizzo un array dove la key è il codice prodotto e il value è la quantità del prodotto nel Carrello
  $carrello;

  //Controllo se il cookie è impostato
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

  //Se sto usando il metodo GET
  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
    //AUMENTO DI UNA UNITA' DELLA QUANTITA' DEL PRODOTTO
    if(isset($_GET['add']))
    {
      //Prendo il valore di add e lo metto nella variabile dopo averlo testato
      $add = test_input($_GET['add']);

      //Seleziono la disponibilità del prodotto di cui voglio aumentare la quantità
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

      //Se il prodotto è già presente nel carrello
      if(isset($carrello[$add]) and $carrello[$add] < $disponibilita)
      {
        //Aumento la quantità del prodotto nel carrello
        $carrello[$add] ++;
      }
      else
      {
        //Altrimenti aggiungo il prodotto ponendo il valore a 1.
        $carrello[$add] = 1;
      }

      //Setto il cookie serializzando l'array
      setcookie('carrello',serialize($carrello),time() + (86400 * GIORNI_SCADENZA_CARRELLO));
    }

    //DIMINUZIONE DI UNA UNITA' DELLA QUANTITA' DEL PRODOTTO
    if(isset($_GET['minus']))
    {

      //La variabile minus contiene  l'id del prodotto ceh vogliamo diminuire
      //Prendo il valore di minus e lo metto nella variabile dopo averlo testato
      $minus = test_input($_GET['minus']);

      //Se la quantità è 1 e premo - rimuovo il prodotto dal carello
      if(isset($carrello[$minus]) && $carrello[$minus] == 1)
      {
        unset($carrello[$minus]);
      }

      //Se il prodotto è già presente nel carrello
      if(isset($carrello[$minus]) && $carrello[$minus]>1)
      {
        //Diminuisci la quantità del prodotto nel carrello
        $carrello[$minus] --;
      }

      //Setto il cookie serializzando l'array
      setcookie('carrello',serialize($carrello),time() + (86400 * GIORNI_SCADENZA_CARRELLO));
    }

    // RIMOZIONE PRODOTTO DAL CARRELLO
    if(isset($_GET['remove']))
    {
      //Remove contiene l'id del prodotto che voglioamo rimuovere dal carrello
      //Prendo il valore di remove lo metto nella variabile dopo averlo testato
      $remove = test_input($_GET['remove']);

      //Se il prodotto è già presente nel carrello
      if(isset($carrello[$remove]))
      {
        //Rimuovo il valore dal vettore
        unset($carrello[$remove]);
      }

      //Setto il cookie serializzando l'array
      setcookie('carrello',serialize($carrello),time() + (86400 * GIORNI_SCADENZA_CARRELLO));
    }
  }
  else //Se non sto usando il metodo get.
  {
    errore("Errore Generale.");
  }

  //Calcola quanti articoli ci sono nel carrello.
  $count_carrello = 0;
  foreach ($carrello as $value)
    $count_carrello += $value;

  //Calcolo il totale degli aritcoli
  $totale = 0.0;

  foreach ($carrello as $id_prodotto => $quantita)
  {
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
     <title>RS Furnitures - Carrello </title>
     <link rel="stylesheet" type="text/css" href="css/navbar.css">
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <?php include_bootstrap(); ?>
   </head>
   <body>

     <?php
      //Prendo il nome e il cognome dell'utente loggato e disegno la navbar
        $user = $_SESSION['nome'] . " " . $_SESSION['cognome'];
        draw_navbar("", $user, $count_carrello);
      ?>

     <div class="container-fluid">

       <div class="col-xs-12 text-center">
         <h1> Carrello </h1>
       </div>

       <div class="col-xs-12">

        <div class="col-sm-3 col-xs-12 pull-right text-center" style="background-color:#F3F3F3;border-radius: 5px;">
           <div "col-xs-12">
             <h3>Totale (<?php echo $count_carrello ?> prodotti)</h3>
           </div>
           <div "col-xs-12">
             <h2 style="color:red;">€<?php echo $totale ?></h2>
           </div>
           <div "col-xs-12">
             <!-- Se il conunt_carrello = 0 non permettere il reindirizzamento ad acquisto -->
             <a href="<?php if(!$count_carrello) echo '#'; else echo 'acquisto.php'; ?>"><button type="button" class="btn btn-success <?php if(!$count_carrello) echo 'disabled' ?>">Procedi all'aquisto!</button></a>
           </div>
           <hr />
           <div "col-xs-12" style="padding:10px;">
             <a href="shop.php"><button type="button" class="btn btn-warning">Torna allo shop!</button></a>
           </div>
        </div>


          <div class="col-sm-9 col-xs-12" style="border: 2px solid #F9F9F9; border-radius: 5px; padding:5px; ">

          <?php
            //Se il carello non è vuoto
            if($count_carrello>0)
            {
                //Per ogni prodotto all'interno del carello
                foreach ($carrello as $id_prodotto => $quantita)
                {
                  //Prendo il nome, il prezzo, la disponibilità e la foto
                  $query = "SELECT nome_prodotto,prezzo,disponibilita,foto FROM Prodotto WHERE id_prodotto=$id_prodotto";

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

                    //Prendo i dati del prodotto
                    $nome_prodotto =  $row['nome_prodotto'];
                    $prezzo        =  $row['prezzo'];
                    $disponibilita =  $row['disponibilita'];
                    $foto          =  $row['foto'];

                    //Infine stampo il prodotto nel carrello
                    draw_prodotto_carrello($id_prodotto, $nome_prodotto, $prezzo, $disponibilita, $foto, $quantita);

                  }
                }
            }
            else
            {
              //Se il carello è vuoto stampo un messaggio di avviso
              echo "<h3 class='text-center'>Carrello Vuoto!</h3>";
            }
            ?>
        </div>

      </div>

    <!-- Questo script risolve il bug di aggiungere più prodotti al refresh della pagina -->
    <script> window.onload = function () { history.replaceState('', '', 'carrello.php'); } </script>
  </div><!--content-->

  <?php
    //Disegno il footer e chiudo la connessione al database
    draw_footer();
    mysqli_close($connessione);
  ?>
  </body>

</html>
