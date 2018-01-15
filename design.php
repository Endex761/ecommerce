<?php

  /* design.php created by Simon Pietro 27/11/2017-00:09 */
  // Questo file contiene funzioni in php per la creazione di parti
  // grafiche per il sito come title, footer, navbar ecc


  function draw_prodotto($id_prodotto, $nome_prodotto, $descrizione, $prezzo, $disponibilita, $foto)
  {
    //Stampa un singolo prodotto
    $disabled = "";
    $script = "location.href = \"carrello.php?add=$id_prodotto\"";
    //$disponibilita = 0;

    echo "<div class='col-sm-4 col-xs-12'>";
    echo " <div class='panel panel-primary'>";
    echo "  <div class='panel-heading text-center'>$nome_prodotto</div>";
    echo "    <div class='panel-body'>";
    echo "      <a href='product_img/$foto'><img src='product_img/$foto' class='img-responsive center-block' height='200px' width='200px'></a>";
    echo "      <hr />";
    echo "      <h4>Descrizone:</h4>";
    echo "      <center>";
    echo "        <p>$descrizione</p>";
    echo "      </center>";
    echo "    </div>";
    echo "    <div class='panel-footer'>";
    echo "      <center>";

    if($disponibilita==0)
    {
      echo "       <h3 style='color:red'>Prodotto non disponibile</h3>";
      $disabled = "disabled"; //Se non dispobile disabilita il pulzante di acquisto
      $script = ""; // E elimina il reindirizzamento
    }
    else
      echo "       <h3 style='color:green'>€ $prezzo </h3>";

    echo "         <button type='button' class='btn btn-primary $disabled' onclick='$script'>";
    echo "         <span class='glyphicon glyphicon-shopping-cart'></span> Aggiungi al carrello";
    echo "        </button>";
    echo "      </center>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
  }

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

    if($quantita>1)
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

  function draw_footer()
  {
    echo "<footer class='footer'>";
    echo "  <div class='col-xs-12 text-center' style='background:#F9F9F9; padding:10px;'>";
    echo "    <span class='text-muted'>SR Furnitures Copyright @ 2017 Simon Pietro Romeo & Dario Stella</span>";
    echo "  </div>";
    echo "</footer>";
  }

  function draw_navbar($ricerca, $user, $count_carrello)
  {
    //Ricerca è il valore della precendente ricerca da mostrsre nel input
    //User è il nome e il cognome dell'utente loggato da stampare nella nav
    //Count_carrello è il numero badge accanto al carrello e indica il numero di elementi nel carello
    echo "<nav class='navbar navbar-inverse'>";
    echo "  <div class=''>";
    echo "    <div class='navbar-header'>";
    echo "      <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>";
    echo "        <span class='icon-bar'></span>";
    echo "        <span class='icon-bar'></span>";
    echo "        <span class='icon-bar'></span>";
    echo "      </button>";
    echo "      <a class='navbar-brand' href='shop.php'>SR Furnitures</a>";
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
    echo "      <ul class='nav navbar-nav navbar-right'>";
    echo "        <li><a href='shop.php'><span class='glyphicon glyphicon-home'></span> Shop </a></li>";
    echo "        <li><a href='impostazioni.php'><span class='glyphicon glyphicon-cog'></span> Impostazioni </a></li>";

    echo "        <li><a href='carrello.php'><span class='glyphicon glyphicon-shopping-cart'></span> Carrello <span class='badge'> $count_carrello </span></a></li>";
    echo "        <li><a href='impostazioni.php'><span class='glyphicon glyphicon-user'></span> $user </a></li>";
    echo "        <li><a href='logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
    echo "      </ul>";
    echo "    </div>";
    echo "  </div>";
    echo "</nav>";

  }

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


  function include_bootstrap()
  {
    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>";
  }


  ?>
