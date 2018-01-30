<?php
  include 'libreria.php';

  /*Avvio la sessione e controllo che il login sia stato effettuato*/
  session_start();

  //Se la sessione non è impostata reindirizzo l'utente al login con stato "not_logged"
  if(!isset($_SESSION['id_utente']))
    reindirizza("login.php?status=not_logged");

  //Prendiamo l'id utente loggato
  $id_utente = $_SESSION['id_utente'];
  /*   */

    //Se c'è una richiesta di tipo get
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
      if(!empty($_GET['acquisto']))
      {
        //Prendiamo l'id acquasto passato dal get
        $id_acquisto = test_input($_GET['acquisto']);
      }
      else
      {
        //Altrimenti ritorniamo agli ordini
        reindirizza("ordini.php");
      }
    }

    //Mi connetto al database
    $connessione = connessione_db();

    //Richiedo l'id dell'utente, id acquisto ecc.. dei prodotti acquistati in un ordine
    $query = "SELECT utente.id_utente AS id_acquirente, id_acquisto, nome, cognome, data_acquisto, acquisto.indirizzo_spedizione AS indirizzo_spedizione, indirizzo_fatturazione FROM utente,acquisto WHERE acquisto.id_acquisto = $id_acquisto AND acquisto.id_utente = utente.id_utente;";

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

      //Prendo l'id dell'acquirente
      $id_acquirente = $row['id_acquirente'];

      //E lo confronto con quello dell'utente loggato
      //Se chi tenta di visualizzare la fattura non è chi l'ha generata viene visualizzato un messaggio d'errore.
      if($id_acquirente != $id_utente)
      {
        errore("Non hai i permessi per visualizzare questa pagina.");
        die();
      }

      //Altrimenti prendo le informazioni dalla query
      $nome = $row['nome'];
      $cognome = $row['cognome'];
      $data = $row['data_acquisto'];
      $indirizzo_spedizione = $row['indirizzo_spedizione'];
      $indirizzo_fatturazione = $row['indirizzo_fatturazione'];
    }
    else //Se non ci sono righe nel risultato non ci sono fatture.
    {
      errore("Nessuna fattura disponibile.");
    }

?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rende responsive il tutto-->
    <title>RS Furnitures - Fattura </title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/functions.js"></script>
    <?php include_bootstrap(); ?>
  </head>
  <body>
    <div class="col-md-6 col-xs-12 col-md-offset-3">
      <center><img src="img/logo.png" width="80px"></center>
      <div class="col-xs-12 text-center">
        <h2>RICEVUTA D'ACQUISTO</h2>
      </div>
      <div class="col-xs-12">
        <strong>Numero ordine:</strong><p><?php echo $id_acquisto ?></p>
      </div>
      <div class="col-xs-6">
        <strong>Acquirente:</strong><p><?php echo ($nome . ' ' . $cognome) ?></p>
      </div>
      <div class="col-xs-6 text-right">
        <strong>Data Acquisto:</strong><p><?php echo $data ?></p>
      </div>
      <div class="col-xs-6">
        <strong>Indirizzo Spedizone:</strong><p><?php echo $indirizzo_spedizione ?></p>
      </div>
      <div class="col-xs-6 text-right">
        <strong>Indirizzo Fatturazione:</strong><p><?php echo $indirizzo_fatturazione ?></p>
      </div>
    <table class="table table-bordered">
      <thead>
          <tr>
            <th class="text-center">Quantità</th>
            <th class="text-center">Prodotto</th>
            <th class="text-center">Prezzo</th>
          </tr>
      </thead>
      <tbody>
        <?php
        //Prendiamo quantita, nome e prezzo da ogni singolo prodotto all'interno dell'acquisto
        $query = "SELECT quantita, nome_prodotto, prezzo_acquisto FROM acquistosingolo,prodotto WHERE id_acquisto=$id_acquisto AND acquistosingolo.id_prodotto = prodotto.id_prodotto;";

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
          $totale = 0;
          //Faccio il fetch dell'array associativo
          while($row = mysqli_fetch_assoc($result_set))
          {
            //Prendiamo i dati dalla query
            $quantita = $row['quantita'];
            $prodotto = $row['nome_prodotto'];
            $prezzo   = $row['prezzo_acquisto'];

            //Calcoliamo il prezzo per la quantità
            $prezzo *= $quantita;

            //Calcoliamo il totale speso
            $totale += $prezzo;

            //Stampiamo il tutto all'interno di una riga della tabella
            echo "<tr>";
            echo "  <td class='text-center'>$quantita</td>";
            echo "  <td class=''>$prodotto</td>";
            echo "  <td class='text-center'>€$prezzo</td>";
            echo "</tr>";
          }
        }

        ?>

        <!-- nell'ultima riga stampiamo il totale -->
        <tr>
          <td class='text-right' colspan="2" >Totale:</td>
          <td class='text-center'>€<?php echo $totale ?></td>
        <tr>

      </tbody>
    </table>
    <center><button class="btn btn-primary" onclick="this.style='display:none'; print(); this.style='display:block';">Stampa</button></center>
  </div>
  </body>
</html>
<?php
  //Chiudo la connessione al db
  mysqli_close($connessione);
 ?>
