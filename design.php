<?php

  /* design.php */
  // Questo file contiene funzioni in php per la creazione di parti
  // grafiche per il sito come title, footer, navbar ecc

  /* Funzione draw_prodotto che prende come parametri le caratteristiche di un prodotto nel database
     e le stampa in un panel. Nell pannel-heading verra' stampato il nome del prodotto.
     All' interno del panel-body viene mostrata una foto del prodotto e la descrizione.
     Nel panel-footer viene mostrato il prezzo del prodotto, se la disoponibilità è 0 mostra
     il messaggio "Prodotto non disponibile". Viene inoltre stampato un pulsante per aggiungere
     un istanza del prodotto all'interno del carrello.
     La funzione viene utilizzata nella pagina shop.php */
  function draw_prodotto($id_prodotto, $nome_prodotto, $descrizione, $prezzo, $disponibilita, $foto)
  {
    //Stampa un singolo prodotto

    //Variabile disable inizializzata a null, se la disponibilità è 0 viene impostata a "disable"
    //e il pulzante per aggiungere il prodotto nel carrello viene disabilitato.
    $disabled = "";

    //Script del pulsante per aggiungere il prodott al carello
    $script = "location.href = \"carrello.php?add=$id_prodotto\"";

    echo "<div class='col-sm-4 col-xs-12'>";
    echo " <div class='panel panel-primary'>";
    echo "  <div class='panel-heading text-center'>$nome_prodotto</div>";
    echo "    <div class='panel-body'>";
    echo "      <a href='product_img/$foto'><img src='product_img/$foto' class='img-responsive center-block' height='200px' width='200px'></a>";
    echo "      <hr/>";
    echo "      <h4>Descrizione:</h4>";
    echo "      <center>";
    echo "        <p>$descrizione</p>";
    echo "      </center>";
    echo "    </div>";
    echo "    <div class='panel-footer'>";
    echo "      <center>";
    if($disponibilita==0)
    {
      echo "       <h3 style='color:red'>Prodotto non disponibile</h3>";

      //Se non dispobile disabilita il pulzante di acquisto
      $disabled = "disabled";

      // E elimina il reindirizzamento altrimenti viene reindirizzato comunque
      $script = "";
    }
    else
    {
      echo "       <h3 style='color:green'>€ $prezzo </h3>";
    }
    echo "         <button type='button' class='btn btn-primary $disabled' onclick='$script'>";
    echo "         <span class='glyphicon glyphicon-shopping-cart'></span> Aggiungi al carrello";
    echo "         </button>";
    echo "        </center>";
    echo "     </div>";
    echo "   </div>";
    echo "</div>";
  }

  /*Funzione draw_prodotto_carrello prende come parametri le caratteristiche di un prodotto e lo stampa nel
    formato del carrello con bottoni per la rimozione del prodotto dal carello, pulzanti per aumentare o
    diminuire la quantità del prodotto all'interno del carello.
    Se la disponibilità è minore o maggiore del numero di prodotti che vogliono essere aggiunti nel Carrello
    i pulsanti + e - vengono disabilitati. Inoltre se il prodotto non  è disponibile per una qualunque ragione
    viene stampato un messaggio che avverte l'utente che il prodotto non è dispobibile.
    La funzione viene richiamata all'interno della pagina carello.php */

  function draw_prodotto_carrello($id_prodotto, $nome_prodotto, $prezzo, $disponibilita, $foto, $quantita)
  {
    echo "<div class='col-xs-12 text-center' style='background-color:#F9F9F9; padding:5px; margin-bottom:5px;'>";

    echo "  <div class='col-sm-3 col-xs-12'>";
    echo "    <a href='product_img/$foto'><img class='img-thumbnail' src='product_img/$foto' height='150px' width='150px'></a>";
    echo "  </div>";

    echo "  <div class='col-sm-6 col-xs-12'>";
    echo "    <div class='col-xs-12'>";
    echo "     <h3 class='text-primary'> $nome_prodotto </h3>";
    echo "    </div>";
    echo "    <div class='col-xs-12'>";
    echo "     <h6> Disponibilità:$disponibilita</h6>";
    echo "      <a href='carrello.php?remove=$id_prodotto'> Rimuovi </a>";
    echo "    </div>";
    echo "  </div>";

    echo "  <div class='col-sm-3 col-xs-12'>";
    echo "    <div class='col-xs-12'>";
    echo "      <h4>Prezzo</h4>";
    if($disponibilita > 0)
      echo "      <h3 style='color:green;'>€$prezzo</h3>";
    else
      echo "      <h3 style='color:red;'>Non disponibile</h3>";
    echo "    </div>";
    echo "    <div class='col-xs-12'>";
    echo "      <h5>Quantità:$quantita</h5>";

    if($quantita>0)
      echo "      <a href='carrello.php?minus=$id_prodotto'><span class='glyphicon glyphicon-minus'></a>";
    else
      echo "      <a href='#'><span class='glyphicon glyphicon-minus'></a>";

    if($disponibilita>$quantita)
      echo "      <a href='carrello.php?add=$id_prodotto'><span class='glyphicon glyphicon-plus'></a>";
    else
      echo "      <a href='#'><span class='glyphicon glyphicon-plus'></a>";
    echo "    </div>";
    echo "  </div>";

    echo "</div>";
  }

  /*Funzione che stampa un singolo ordine all'interno della pagina ordini.php mostrando immagine
  nome del prodotto prezzo d'acquisto e quantita del prodotto acquistato.
  Questa funzione viene richiamata all'interno della funzone draw_prodotto*/

  function draw_singolo_ordine($id_prodotto, $nome_prodotto, $prezzo, $foto, $quantita)
  {
    echo "<div class='col-md-9 col-xs-12 text-center' style='background-color:#F9F9F9; padding:5px; margin-bottom:5px;'>";
    echo "  <div class='col-md-3 col-xs-12'>";
    echo "    <a href='product_img/$foto'><img class='img-thumbnail' src='product_img/$foto' height='150px' width='150px'></a>";
    echo "  </div>";
    echo "  <div class='col-md-6 col-xs-12'>";
    echo "    <div class='col-xs-12'>";
    echo "     <h3 class='text-primary'> $nome_prodotto </h3>";
    echo "    </div>";
    echo "  </div>";
    echo "  <div class='col-md-3 col-xs-12'>";
    echo "    <div class='col-xs-12'>";
    echo "      <h4>Prezzo</h4>";
    echo "      <h3 style='color:green;'>€$prezzo</h3>";
    echo "    </div>";
    echo "    <div class='col-md-12'>";
    echo "      <h5>Quantità:$quantita</h5>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
  }

  /* Funzione che stampa un acquisto in un pannello.
    Nell'header del pannello vengono stampati indirizzo di spedizione, fatturazione, numero carta, prezzo totale e id acquisto.
    All'interno del body vengono stampati i vari prodotti acquistati attraverso la funzione draw_singolo_ordine.
    Viene stampato inoltre lo stato della spedizione (Non implementato) e il pulzante per visualizzare la fattura dell'acqusito.
    Questa funzione viene utilizzata nela pagina prodotti.php*/

  function draw_ordine($id_acquisto, $data_acquisto, $indirizzo_spedizione, $indirizzo_fatturazione, $numero_carta, $connessione)
  {
    //Prendo gli ultimi 4 numeri del numero della carta.
    $numero_carta = substr($numero_carta, 15);

    //Seleziono il totale dei prodotti acqustitai per stamparli nell'header.
    $query = "SELECT SUM(prezzo_acquisto*quantita) AS totale FROM Prodotto, AcquistoSingolo WHERE id_acquisto=$id_acquisto AND prodotto.id_prodotto = acquistosingolo.id_prodotto;";

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
      $totale = $row['totale'];
    }
    else
    {
      //In caso di errore il prezzo sarà -1.
      $totale = -1;
    }

    echo "<div class='panel panel-default'>";
    echo "  <div class='panel-heading'>"; //Info sull'ordine complessivo
    echo "    <div class='row text-center'>";
    echo "      <div class='col-md-2 col-xs-12'>";
    echo "        <strong>Ordine effettuato:</strong>";
    echo "        <br>";
    echo "        <p>$data_acquisto</p>";
    echo "      </div>";
    echo "      <div class='col-md-3 col-xs-12'>";
    echo "        <strong>Indirizzo spedizione:</strong>";
    echo "        <br>";
    echo "        <p>$indirizzo_spedizione</p>";
    echo "      </div>";
    echo "      <div class='col-md-3 col-xs-12'>";
    echo "        <strong>Indirizzo Fatturazione:</strong>";
    echo "        <br>";
    echo "        <p>$indirizzo_fatturazione</p>";
    echo "      </div>";
    echo "      <div class='col-md-1 col-xs-12'>";
    echo "        <strong>Totale:</strong>";
    echo "        <br>";
    echo "        <p>€$totale</p>";
    echo "      </div>";
    echo "      <div class='col-md-2 col-xs-12'>";
    echo "        <strong>Pagamento:</strong>";
    echo "        <p>****-****-****-$numero_carta</p>";
    echo "      </div>";
    echo "      <div class='col-md-1 col-xs-12'>";
    echo "        <strong>ID Ordine:</strong>";
    echo "        <br>";
    echo "        <p>#$id_acquisto</p>";
    echo "      </div>";
    echo "    </div>";
    echo "  </div>";
    echo "  <div class='panel-body'>";//<!-- QUI DENTRO VANNO I SINGOLI ORDINI -->
    echo "    <div class='col-sm-3 col-xs-12 pull-right text-center'>";
    echo "      <h4>Stato consegna: In transito</h4>";
    echo "      <a href='fattura.php?acquisto=$id_acquisto' target='_blank'><button class='btn btn-warning'>Visualizza la fattura</button></a>";
    echo "    </div>";

    //Seleziono tutte le informazioni di ogni acquisto singolo fatto dall'utente loggato
    $query = "SELECT prodotto.id_prodotto AS id_prodotto, prezzo_acquisto, quantita, foto, nome_prodotto FROM Prodotto, AcquistoSingolo WHERE id_acquisto=$id_acquisto AND prodotto.id_prodotto = acquistosingolo.id_prodotto;";

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
        //Prendo i dati dei singoli oridni
        $id_prodotto    = $row['id_prodotto'];
        $nome_prodotto  = $row['nome_prodotto'];
        $prezzo         = $row['prezzo_acquisto'];
        $foto           = $row['foto'];
        $quantita       = $row['quantita'];

        //Stampo il singolo ordine
        draw_singolo_ordine($id_prodotto, $nome_prodotto, $prezzo, $foto, $quantita);
      }
    }

    echo "  </div>";
    echo "</div>";
  }

  /* Funzione che stampa il footer nelle pagine in cui è richiamata. */
  function draw_footer()
  {
    echo "<footer class='footer'>";
    echo "  <div class='col-xs-12 text-center' style='background:#F0F0F0; padding:10px;'>";
    echo "    <span class='text-muted'>RS Furnitures Copyright @ 2018 Simon Pietro Romeo & Dario Stella</span>";
    echo "  </div>";
    echo "</footer>";
  }

  /* Funzione che stampa la navbar all'interno della pagine in cui è richiamata.
    Prende in ingresso la variabile $ricerca che imposta il valore dell'input all'ultima ricerca effettuata.
    $user contiene il nome e il cognome dell'utente che è attualmente loggato e viene stampata nella navbar
    $count_carrello contiene il numero di prodotti all'interno del carrello e li stampa come badge*/

  function draw_navbar($ricerca, $user, $count_carrello)
  {
    //Ricerca è il valore della precendente ricerca da mostrsre nel input
    //User è il nome e il cognome dell'utente loggato da stampare nella nav
    //Count_carrello è il numero badge accanto al carrello e indica il numero di elementi nel carello
    echo "<nav class='navbar navbar-inverse'>";
    echo "  <div>";
    echo "    <div class='navbar-header'>";
    echo "      <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>";
    echo "        <span class='icon-bar'></span>";
    echo "        <span class='icon-bar'></span>";
    echo "        <span class='icon-bar'></span>";
    echo "      </button>";
    echo "      <a class='navbar-brand' href='shop.php'>RS Furnitures</a>";
    echo "    </div>";
    echo "    <div class='collapse navbar-collapse' id='myNavbar'>";
    echo "      <ul class='nav navbar-nav'>";
    echo "        <form class='navbar-form navbar-left' id='navBarSearchForm'  action='shop.php' method='get'>";
    echo "          <div class='input-group'>";
    echo "            <input name='ricerca' type='text' class='form-control' value='$ricerca' placeholder='Mobili, Comodini, Sedie ..' >";
    echo "            <div class='input-group-btn'>";
    echo "              <button class='btn btn-default' type='submit'>Cerca</button>";
    echo "            </div>";
    echo "          </div>";
    echo "        </form>";
    echo "      </ul>";
    //Qui stampo i link che stanno sulla destra della navbar
    echo "      <ul class='nav navbar-nav navbar-right'>";
    echo "        <li><a href='shop.php'><span class='glyphicon glyphicon-home'></span> Shop </a></li>";
    echo "        <li><a href='impostazioni.php'><span class='glyphicon glyphicon-cog'></span> Impostazioni </a></li>";
    echo "        <li><a href='carrello.php'><span class='glyphicon glyphicon-shopping-cart'></span> Carrello <span class='badge'> $count_carrello </span></a></li>";
    echo "        <li><a href='ordini.php'><span class='glyphicon glyphicon-user'></span> $user </a></li>";
    echo "        <li><a href='logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
    echo "      </ul>";
    echo "    </div>";
    echo "  </div>";
    echo "</nav>";

  }

  /* Funzione che stampa le informazioni delle carte di credito inserite dell'utente all'interno della pagina
    acquisto.php e ne permette la selezione per poi procedere all'acquisto.*/

  function draw_carta($id_carta, $intestatario, $numero_carta, $mese_scadenza, $anno_scadenza, $codice_sicurezza, $denominazione)
  {
    //Mostra solo gli ultimi 4 numeri del numero
    $numero_carta = substr($numero_carta, 15);

    echo "<div class='col-sm-9 col-xs-12' class='form-control' style='margin-bottom:20px;'>";
    echo "  <div class='form-group'>";
    echo "    <label for='indirizzo'>Carta</label>";
    echo "    <label class='pull-right' for='seleziona'>Seleziona</label><input class='pull-right' type='radio' name='id_carta' value='$id_carta' required>";
    echo "    <input type='text' class='form-control' id='denominazione' value='$denominazione' disabled>";
    echo "  </div>";
    echo "  <div class='form-group'>";
    echo "    <label for='indirizzo'>Intestatario</label>";
    echo "    <input name='indirizzo' type='text' class='form-control' id='intestatario' value='$intestatario' disabled>";
    echo "  </div>";
    echo "  <div class='row'>";
    echo "    <div class='col-sm-9 col-xs-8'>";
    echo "      <div class='form-group'>";
    echo "        <label for='indirizzo'>Numero Carta</label>";
    echo "        <input name='indirizzo' type='text' class='form-control' id='numero-carta' value='**** **** **** $numero_carta' disabled>";
    echo "      </div>";
    echo "    </div>";
    echo "    <div class='col-sm-3 col-xs-4'>";
    echo "      <div class='form-group'>";
    echo "        <label for='indirizzo'>CVV</label>";
    echo "        <input name='indirizzo' type='text' class='form-control' id='codice-sicurezza' value='$codice_sicurezza' disabled>";
    echo "      </div>";
    echo "    </div>";
    echo "  </div>";
    echo "  <div class='row'>";
    echo "    <div class='col-xs-6'>";
    echo "      <div class='form-group'>";
    echo "        <label for='indirizzo'>Mese Scadenza</label>";
    echo "        <input name='indirizzo' type='text' class='form-control' id='mese-scadenza' value='$mese_scadenza' disabled>";
    echo "      </div>";
    echo "    </div>";
    echo "    <div class='col-xs-6'>";
    echo "      <div class='form-group'>";
    echo "        <label for='indirizzo'>Anno Scadenza</label>";
    echo "        <input name='indirizzo' type='text' class='form-control' id='anno-scadenza' value='$anno_scadenza' disabled>";
    echo "      </div>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
  }

  //Funzione che importa il framework bootstrap cdn e ajax nelle pagine in cui è richiamato.
  //Importa anche la Favicon, l'iconcina in alto nel tab della pagina.
  function include_bootstrap()
  {
    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>";
    echo "<link rel='icon' type='image/x-icon' href='img/favicon.png' />";
  }


  ?>
